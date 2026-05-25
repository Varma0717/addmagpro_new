#!/bin/bash

#############################################################################
# AddMagPro Production Monitoring & Health Check Script
# 
# This script monitors the health of the production application
# Run every 5 minutes via cron: */5 * * * * /var/scripts/health-check.sh
#
#############################################################################

set -e

# Configuration
APP_URL="https://yourdomain.com"
API_URL="$APP_URL/api/v1"
HEALTH_LOG="/var/log/admagpro/health-check.log"
ALERT_EMAIL="admin@yourdomain.com"
STATUS_FILE="/var/run/admagpro-health.status"

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Functions
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$HEALTH_LOG"
}

send_alert() {
    local subject="$1"
    local message="$2"
    echo "$message" | mail -s "ALERT: $subject" "$ALERT_EMAIL"
    log_message "ALERT SENT: $subject"
}

check_http_status() {
    local url="$1"
    local expected_code="$2"
    
    local response=$(curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 "$url")
    
    if [ "$response" = "$expected_code" ]; then
        echo "OK"
        return 0
    else
        echo "FAILED"
        return 1
    fi
}

check_api_endpoint() {
    local endpoint="$1"
    
    local response=$(curl -s -w "\n%{http_code}" "$API_URL$endpoint" --connect-timeout 5)
    local body=$(echo "$response" | head -n -1)
    local code=$(echo "$response" | tail -n 1)
    
    if [ "$code" = "200" ] || [ "$code" = "401" ]; then
        echo "OK"
        return 0
    else
        echo "FAILED ($code)"
        return 1
    fi
}

check_database() {
    php artisan tinker <<< "echo DB::connection()->getPdo() ? 'OK' : 'FAILED';" 2>/dev/null
}

check_redis() {
    redis-cli ping | grep -q "PONG"
    if [ $? -eq 0 ]; then
        echo "OK"
        return 0
    else
        echo "FAILED"
        return 1
    fi
}

check_disk_space() {
    local usage=$(df -h / | awk 'NR==2 {print $(NF-1)}' | sed 's/%//')
    
    if [ "$usage" -gt 80 ]; then
        echo "WARNING: Disk usage at ${usage}%"
        send_alert "Disk Space Critical" "Disk usage is at ${usage}%"
        return 1
    else
        echo "OK (${usage}%)"
        return 0
    fi
}

check_memory() {
    local usage=$(free | awk 'NR==2{printf("%.0f", $3*100/$2)}')
    
    if [ "$usage" -gt 85 ]; then
        echo "WARNING: Memory usage at ${usage}%"
        send_alert "Memory Usage High" "Memory usage is at ${usage}%"
        return 1
    else
        echo "OK (${usage}%)"
        return 0
    fi
}

check_cpu() {
    local usage=$(top -bn1 | grep "Cpu(s)" | awk '{print int($2)}')
    
    if [ "$usage" -gt 80 ]; then
        echo "WARNING: CPU usage at ${usage}%"
        return 1
    else
        echo "OK (${usage}%)"
        return 0
    fi
}

check_payment_processing() {
    # Check if payments are being processed
    local pending_orders=$(mysql -u $DB_USER -p$DB_PASSWORD $DB_NAME -e "SELECT COUNT(*) FROM orders WHERE status='pending' AND created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR);" 2>/dev/null)
    
    if [ "$pending_orders" -gt 5 ]; then
        echo "WARNING: $pending_orders pending orders"
        send_alert "Payment Processing Delayed" "Found $pending_orders orders stuck for >1 hour"
        return 1
    else
        echo "OK"
        return 0
    fi
}

check_error_rate() {
    # Check error log for recent errors
    local recent_errors=$(tail -1000 /var/log/admagpro/application.log 2>/dev/null | grep -c "ERROR" || echo "0")
    
    if [ "$recent_errors" -gt 50 ]; then
        echo "WARNING: $recent_errors recent errors"
        send_alert "High Error Rate" "Found $recent_errors errors in recent logs"
        return 1
    else
        echo "OK ($recent_errors errors)"
        return 0
    fi
}

check_queue_jobs() {
    # Check if queue jobs are processing
    local failed_jobs=$(mysql -u $DB_USER -p$DB_PASSWORD $DB_NAME -e "SELECT COUNT(*) FROM failed_jobs;" 2>/dev/null)
    
    if [ "$failed_jobs" -gt 10 ]; then
        echo "WARNING: $failed_jobs failed queue jobs"
        send_alert "Queue Jobs Failing" "Found $failed_jobs failed queue jobs"
        return 1
    else
        echo "OK ($failed_jobs failed)"
        return 0
    fi
}

# Main Health Check
echo ""
echo "=========================================="
echo "AddMagPro Production Health Check"
echo "Timestamp: $(date)"
echo "=========================================="
echo ""

log_message "Health check started"

# Check application availability
echo -n "Application Status: "
if check_http_status "$APP_URL" "200"; then
    echo -e "${GREEN}✓ OK${NC}"
    log_message "Application: OK"
else
    echo -e "${RED}✗ FAILED${NC}"
    log_message "Application: FAILED"
    send_alert "Application Down" "Application is not responding at $APP_URL"
fi

# Check API
echo -n "API Endpoint: "
if check_api_endpoint "/home"; then
    echo -e "${GREEN}✓ OK${NC}"
    log_message "API: OK"
else
    echo -e "${RED}✗ FAILED${NC}"
    log_message "API: FAILED"
    send_alert "API Down" "API is not responding"
fi

# Check Database
echo -n "Database Connection: "
if check_database > /dev/null 2>&1; then
    echo -e "${GREEN}✓ OK${NC}"
    log_message "Database: OK"
else
    echo -e "${RED}✗ FAILED${NC}"
    log_message "Database: FAILED"
    send_alert "Database Down" "Cannot connect to database"
fi

# Check Redis
echo -n "Redis Cache: "
if check_redis; then
    echo -e "${GREEN}✓ OK${NC}"
    log_message "Redis: OK"
else
    echo -e "${YELLOW}⚠ WARNING${NC}"
    log_message "Redis: FAILED"
fi

# Check Disk Space
echo -n "Disk Space: "
check_disk_space

# Check Memory
echo -n "Memory Usage: "
check_memory

# Check CPU
echo -n "CPU Usage: "
check_cpu

# Check Payment Processing
echo -n "Payment Processing: "
check_payment_processing

# Check Error Rate
echo -n "Error Rate: "
check_error_rate

# Check Queue
echo -n "Queue Jobs: "
check_queue_jobs

echo ""
echo "=========================================="
log_message "Health check completed"
echo "Check logs at: $HEALTH_LOG"
echo ""
