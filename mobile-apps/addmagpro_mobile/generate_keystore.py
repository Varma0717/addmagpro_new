#!/usr/bin/env python3
"""Generate Android keystore for app signing"""

import subprocess
import sys
import os
from pathlib import Path

def find_jdk():
    """Find Java Development Kit"""
    # Check JAVA_HOME
    java_home = os.environ.get('JAVA_HOME')
    if java_home and Path(java_home).exists():
        keytool = Path(java_home) / 'bin' / 'keytool.exe'
        if keytool.exists():
            return str(keytool)
    
    # Check common paths
    common_paths = [
        r"C:\Program Files\Java",
        r"C:\Program Files (x86)\Java",
        r"C:\Program Files\Android\Android Studio\jre",
    ]
    
    for base_path in common_paths:
        base = Path(base_path)
        if base.exists():
            for jdk_dir in base.glob("jdk*"):
                keytool = jdk_dir / 'bin' / 'keytool.exe'
                if keytool.exists():
                    return str(keytool)
    
    return None

def main():
    keytool = find_jdk()
    if not keytool:
        print("❌ ERROR: Java Development Kit (keytool) not found!")
        print("Please install JDK or set JAVA_HOME environment variable")
        sys.exit(1)
    
    print(f"✅ Found keytool at: {keytool}")
    
    keystore_path = r"android\app\keystore.jks"
    
    # Generate keystore
    cmd = [
        keytool,
        '-genkey', '-v',
        '-keystore', keystore_path,
        '-keyalg', 'RSA',
        '-keysize', '2048',
        '-validity', '10950',  # ~30 years
        '-alias', 'addmagpro-key',
        '-keypass', 'addmagpro123',
        '-storepass', 'addmagpro123',
        '-dname', 'CN=AddMagPro,OU=Engineering,O=AddMagPro,L=India,ST=India,C=IN'
    ]
    
    try:
        result = subprocess.run(cmd, check=True, capture_output=True, text=True)
        print("✅ Keystore generated successfully!")
        print(f"Location: {keystore_path}")
        print("Alias: addmagpro-key")
        print("Store Password: addmagpro123")
        print("Key Password: addmagpro123")
        print("\n⚠️  IMPORTANT: Keep keystore.jks secure - DO NOT commit to version control!")
        return 0
    except subprocess.CalledProcessError as e:
        print(f"❌ Failed to generate keystore: {e.stderr}")
        return 1
    except Exception as e:
        print(f"❌ Error: {e}")
        return 1

if __name__ == '__main__':
    sys.exit(main())
