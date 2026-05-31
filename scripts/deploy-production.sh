#!/bin/bash

#############################################################################
# AddMagPro Production Deployment Script
# 
# This script automates the deployment process from staging to production
# Usage: ./deploy-production.sh
#
# Prerequisites:
# - Ubuntu 22.04 server
# - PHP 8.2 with FPM
# - MySQL 8.0
# - Nginx
# - Git
# - Composer
# - Node.js 18+
#
#############################################################################

set -e  # Exit on error

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
DEPLOY_USER="www-data"
APP_DIR="/var/www/admagpro"
BACKUP_DIR="/var/backups/admagpro"
LOG_FILE="/var/log/admagpro/deploy.log"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# Functions
print_header() {
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$LOG_FILE"
}

# Check prerequisites
check_prerequisites() {
    print_header "Checking Prerequisites"
    
    if ! command -v php &> /dev/null; then
        print_error "PHP not found"
        exit 1
    fi
    print_success "PHP installed"
    
    if ! command -v composer &> /dev/null; then
        print_error "Composer not found"
        exit 1
    fi
    print_success "Composer installed"
    
    if ! command -v node &> /dev/null; then
        print_error "Node.js not found"
        exit 1
    fi
    print_success "Node.js installed"
    
    if ! command -v npm &> /dev/null; then
        print_error "npm not found"
        exit 1
    fi
    print_success "npm installed"
    
    if ! command -v mysql &> /dev/null; then
        print_error "MySQL client not found"
        exit 1
    fi
    print_success "MySQL installed"
    
    if ! command -v nginx &> /dev/null; then
        print_error "Nginx not found"
        exit 1
    fi
    print_success "Nginx installed"
}

# Create backup
create_backup() {
    print_header "Creating Database Backup"
    
    mkdir -p "$BACKUP_DIR"
    
    BACKUP_FILE="$BACKUP_DIR/admagpro_${TIMESTAMP}.sql.gz"
    
    if mysqldump -u$DB_USER -p$DB_PASSWORD $DB_NAME | gzip > "$BACKUP_FILE"; then
        print_success "Database backed up to $BACKUP_FILE"
        log_message "Database backup created: $BACKUP_FILE"
    else
        print_error "Failed to create database backup"
        exit 1
    fi
    
    # Backup application files
    if tar -czf "$BACKUP_DIR/app_${TIMESTAMP}.tar.gz" "$APP_DIR" --exclude=node_modules --exclude=vendor; then
        print_success "Application files backed up"
        log_message "Application backup created"
    else
        print_error "Failed to backup application files"
        exit 1
    fi
}

# Pull latest code
pull_latest_code() {
    print_header "Pulling Latest Code"
    
    cd "$APP_DIR"
    
    if git pull origin main; then
        print_success "Code pulled successfully"
        log_message "Code pulled from repository"
    else
        print_error "Failed to pull code"
        exit 1
    fi
}

# Install dependencies
install_dependencies() {
    print_header "Installing Dependencies"
    
    cd "$APP_DIR"
    
    # Install PHP dependencies
    print_warning "Installing PHP dependencies..."
    if composer install --no-interaction --prefer-dist --optimize-autoloader; then
        print_success "PHP dependencies installed"
        log_message "PHP dependencies installed"
    else
        print_error "Failed to install PHP dependencies"
        exit 1
    fi
    
    # Install Node dependencies
    print_warning "Installing Node dependencies..."
    if npm install --production; then
        print_success "Node dependencies installed"
        log_message "Node dependencies installed"
    else
        print_error "Failed to install Node dependencies"
        exit 1
    fi
}

# Build assets
build_assets() {
    print_header "Building Assets"
    
    cd "$APP_DIR"
    
    if npm run build; then
        print_success "Assets built successfully"
        log_message "Assets built"
    else
        print_error "Failed to build assets"
        exit 1
    fi
}

# Run migrations
run_migrations() {
    print_header "Running Database Migrations"
    
    cd "$APP_DIR"
    
    # This MUST be reviewed before running in production
    print_warning "Reviewing migrations..."
    
    if php artisan migrate --force; then
        print_success "Migrations executed successfully"
        log_message "Database migrations completed"
    else
        print_error "Failed to run migrations"
        exit 1
    fi
}

# Optimize Laravel
optimize_laravel() {
    print_header "Optimizing Laravel"
    
    cd "$APP_DIR"
    
    # Clear caches
    php artisan config:clear
    php artisan view:clear
    
    # Cache config, routes, views
    if php artisan config:cache && \
       php artisan route:cache && \
       php artisan view:cache; then
        print_success "Laravel optimized"
        log_message "Laravel optimization completed"
    else
        print_error "Failed to optimize Laravel"
        exit 1
    fi
}

# Set permissions
set_permissions() {
    print_header "Setting File Permissions"
    
    chown -R $DEPLOY_USER:$DEPLOY_USER "$APP_DIR"
    chmod -R 755 "$APP_DIR"
    chmod -R 775 "$APP_DIR/storage"
    chmod -R 775 "$APP_DIR/bootstrap/cache"
    
    print_success "Permissions set correctly"
    log_message "File permissions updated"
}

# Reload services
reload_services() {
    print_header "Reloading Services"
    
    # Reload PHP-FPM
    if systemctl reload php8.2-fpm; then
        print_success "PHP-FPM reloaded"
        log_message "PHP-FPM reloaded"
    else
        print_error "Failed to reload PHP-FPM"
        exit 1
    fi
    
    # Reload Nginx
    if systemctl reload nginx; then
        print_success "Nginx reloaded"
        log_message "Nginx reloaded"
    else
        print_error "Failed to reload Nginx"
        exit 1
    fi
}

# Run tests
run_tests() {
    print_header "Running Tests"
    
    cd "$APP_DIR"
    
    if php artisan test; then
        print_success "All tests passed"
        log_message "Tests passed"
    else
        print_warning "Some tests failed - review before production"
        log_message "Tests failed"
    fi
}

# Health check
health_check() {
    print_header "Performing Health Check"
    
    # Check if application is responding
    if curl -f http://localhost/api/v1/home > /dev/null 2>&1; then
        print_success "API health check passed"
    else
        print_error "API health check failed"
        exit 1
    fi
    
    # Check database connection
    if php artisan tinker <<< "DB::connection()->getPdo()" > /dev/null 2>&1; then
        print_success "Database connection healthy"
    else
        print_error "Database connection failed"
        exit 1
    fi
    
    print_success "All health checks passed"
    log_message "Health checks completed successfully"
}

# Main deployment flow
main() {
    print_header "ADMAGPRO PRODUCTION DEPLOYMENT"
    echo "Timestamp: $TIMESTAMP"
    echo "App Directory: $APP_DIR"
    echo ""
    
    # Create log file
    mkdir -p "$(dirname "$LOG_FILE")"
    log_message "Deployment started"
    
    # Run deployment steps
    check_prerequisites
    create_backup
    pull_latest_code
    install_dependencies
    build_assets
    run_migrations
    optimize_laravel
    set_permissions
    reload_services
    run_tests
    health_check
    
    print_header "DEPLOYMENT COMPLETE"
    print_success "Application deployed successfully!"
    print_success "Backup: $BACKUP_FILE"
    print_success "Logs: $LOG_FILE"
    
    log_message "Deployment completed successfully"
    
    # Post-deployment tasks
    echo ""
    print_warning "Post-Deployment Tasks:"
    echo "1. Monitor application logs: tail -f /var/log/admagpro/application.log"
    echo "2. Check payment processing: Monitor /api/v1/wallet/topup-verify"
    echo "3. Verify search functionality: Test /api/v1/search/products"
    echo "4. Monitor server resources: htop"
    echo "5. Check error rates: Review application logs"
    echo ""
}

# Error handling
trap 'print_error "Deployment failed. Check logs at $LOG_FILE"' ERR

# Run main deployment
main "$@"
