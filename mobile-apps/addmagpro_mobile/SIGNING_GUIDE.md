# 🔐 AddMagPro Android App Signing Guide

## Current Status
- ✅ App code complete with all 14 modules
- ✅ App icons created (mdpi, hdpi, xhdpi, xxhdpi, xxxhdpi)
- ✅ Release APK configured with obfuscation
- ⚠️ Currently using debug keystore - MUST create production keystore before Play Store submission

---

## 🔑 Production Keystore Generation

### Option 1: Generate Keystore on Windows (Recommended)

**Prerequisites:**
- Java Development Kit (JDK) 8 or higher installed
- Set `JAVA_HOME` environment variable

**Steps:**

1. **Install JDK** (if not already installed):
   - Download from: https://www.oracle.com/java/technologies/downloads/
   - Or use: https://adoptium.net/
   - Install to default location

2. **Set JAVA_HOME** (Windows):
   ```powershell
   # Open Environment Variables (Win+R -> sysdm.cpl)
   # Add JAVA_HOME pointing to your JDK installation
   # Example: C:\Program Files\Java\jdk-17
   
   # Or from PowerShell (Admin):
   $env:JAVA_HOME = "C:\Program Files\Java\jdk-17"
   [Environment]::SetEnvironmentVariable("JAVA_HOME", "C:\Program Files\Java\jdk-17", "Machine")
   ```

3. **Generate Keystore**:
   ```powershell
   cd c:\xampp\htdocs\admagpro\mobile-apps\addmagpro_mobile

   # Command (adjust JAVA_HOME path as needed)
   & "$env:JAVA_HOME\bin\keytool" -genkey -v `
     -keystore android/app/addmagpro.jks `
     -keyalg RSA `
     -keysize 2048 `
     -validity 10950 `
     -alias addmagpro-key `
     -keypass addmagpro123 `
     -storepass addmagpro123 `
     -dname "CN=AddMagPro,OU=Engineering,O=AddMagPro,L=Bangalore,ST=Karnataka,C=IN"
   ```

4. **Verify Keystore**:
   ```powershell
   & "$env:JAVA_HOME\bin\keytool" -list -v -keystore android/app/addmagpro.jks -storepass addmagpro123
   ```

---

## 📝 Update Build Configuration

After generating `addmagpro.jks`, update `android/app/build.gradle.kts`:

```kotlin
signingConfigs {
    create("release") {
        keyAlias = "addmagpro-key"
        keyPassword = "addmagpro123"
        storeFile = file("addmagpro.jks")
        storePassword = "addmagpro123"
    }
}

buildTypes {
    release {
        signingConfig = signingConfigs.getByName("release")
        minifyEnabled = true
        shrinkResources = true
        proguardFiles(
            getDefaultProguardFile("proguard-android-optimize.txt"),
            "proguard-rules.pro"
        )
    }
}
```

---

## 🛠️ Build Release APK

### Step 1: Clean Build
```bash
cd mobile-apps/addmagpro_mobile
flutter clean
flutter pub get
```

### Step 2: Build Release APK
```bash
flutter build apk --release
```

**Output Location**: `build/app/outputs/flutter-apk/app-release.apk`

### Step 3: Build App Bundle (for Play Store)
```bash
flutter build appbundle --release
```

**Output Location**: `build/app/outputs/bundle/release/app-release.aab`

---

## ⚠️ Security Best Practices

**NEVER commit keystore files to version control!**

### .gitignore Entry:
```
# Signing keys
*.jks
*.keystore
*.p12
*.pfx
key.properties
```

### Key Password Storage:
Create `android/key.properties` (NOT in git):
```properties
storePassword=addmagpro123
keyPassword=addmagpro123
keyAlias=addmagpro-key
storeFile=addmagpro.jks
```

### Reference in build.gradle.kts:
```kotlin
val keystoreFile = rootProject.file("key.properties")
val keystoreProperties = Properties()
if (keystoreFile.exists()) {
    keystoreProperties.load(FileInputStream(keystoreFile))
}

signingConfigs {
    create("release") {
        keyAlias = keystoreProperties["keyAlias"] as String?
        keyPassword = keystoreProperties["keyPassword"] as String?
        storeFile = file(keystoreProperties["storeFile"] as String?)
        storePassword = keystoreProperties["storePassword"] as String?
    }
}
```

---

## 📱 Play Store Submission Checklist

- [ ] Production keystore created (`addmagpro.jks`)
- [ ] Build configuration updated with keystore details
- [ ] APK/AAB generated successfully
- [ ] App version bumped: `pubspec.yaml` -> `version: 1.0.1+2`
- [ ] Version name in `android/app/build.gradle.kts` incremented
- [ ] App tested on physical Android device
- [ ] All 14 feature modules tested
- [ ] Backend API calls verified with production endpoint
- [ ] Firebase configuration set for production
- [ ] Razorpay payment tested with live credentials
- [ ] Google Play Developer account created
- [ ] App listing created with screenshots & description
- [ ] Privacy policy published
- [ ] Content rating questionnaire completed
- [ ] APK/AAB uploaded to Play Store
- [ ] Beta testing (internal testing) completed
- [ ] Production release submitted for review

---

## 📊 Current Configuration

**App ID**: `com.admagpro.mobile`  
**Version**: `1.0.0+1`  
**Min SDK**: API 21+ (Android 5.0+)  
**Target SDK**: API 36  
**Architecture**: x86_64, armeabi-v7a, arm64-v8a  

---

## 🆘 Troubleshooting

### "Keystore not found"
- Verify `addmagpro.jks` exists in `android/app/`
- Check path in `build.gradle.kts` is correct

### "Invalid keystore password"
- Verify `storePassword` and `keyPassword` match keystore creation

### "Build fails with obfuscation"
- Add rules to `proguard-rules.pro` for third-party libraries
- Rebuild with `-v` flag for detailed error output

### "APK too large"
- Enable `minifyEnabled` in release build type
- Remove unused dependencies from `pubspec.yaml`

---

## 📞 Support

For issues during signing or building:
1. Check Flutter version: `flutter --version`
2. Update Gradle: In `android/build.gradle.kts`
3. Rebuild Gradle cache: `flutter clean && flutter pub get`
4. Check Java version: `java -version`

