// ============================================================================
// Complete Fixed: android/app/build.gradle.kts
// ============================================================================
// This file has been corrected to fix the Android signing issue where
// Gradle was looking for: android/app/app/addmagpro.jks (duplicate "app")
// 
// The fix uses rootProject.file() to properly resolve the keystore path
// relative to the android/ directory, not relative to android/app/

import java.io.FileInputStream
import java.util.*

plugins {
    id("com.android.application")
    id("kotlin-android")
    id("com.google.gms.google-services")
    // The Flutter Gradle Plugin must be applied after the Android and Kotlin Gradle plugins.
    id("dev.flutter.flutter-gradle-plugin")
}

// ============================================================================
// KEY PROPERTIES LOADING (FIXED)
// ============================================================================
// Loads signing credentials from: android/key.properties
// key.properties should contain:
//   storePassword=<password>
//   keyPassword=<password>
//   keyAlias=<key_alias>
//   storeFile=app/addmagpro.jks  (path relative to android/ directory)

val keystorePropertiesFile = rootProject.file("key.properties")
val keystoreProperties = Properties()
if (keystorePropertiesFile.exists()) {
    keystoreProperties.load(FileInputStream(keystorePropertiesFile))
}

android {
    namespace = "com.admagpro.mobile"
    compileSdk = flutter.compileSdkVersion
    ndkVersion = flutter.ndkVersion

    // Desugaring support for Java 17 features on older Android versions
    compileOptions {
        isCoreLibraryDesugaringEnabled = true
        sourceCompatibility = JavaVersion.VERSION_17
        targetCompatibility = JavaVersion.VERSION_17
    }

    // Kotlin compilation target
    kotlinOptions {
        jvmTarget = JavaVersion.VERSION_17.toString()
    }

    // Duplicate for clarity (required by Android plugin)
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_17
        targetCompatibility = JavaVersion.VERSION_17
    }

    defaultConfig {
        applicationId = "com.admagpro.mobile"
        minSdk = flutter.minSdkVersion
        targetSdk = flutter.targetSdkVersion
        versionCode = flutter.versionCode
        versionName = flutter.versionName
    }

    // ========================================================================
    // SIGNING CONFIGURATION (FIXED - THIS IS THE KEY FIX)
    // ========================================================================
    // BEFORE (WRONG):
    //   storeFile = file(keystoreProperties["storeFile"] as String)
    //   Problem: file() resolves relative to android/app/
    //   Result: android/app/app/addmagpro.jks (duplicate "app")
    //
    // AFTER (CORRECT):
    //   storeFile = rootProject.file(storeFilePath)
    //   Solution: rootProject.file() resolves relative to android/
    //   Result: android/app/addmagpro.jks ✓

    signingConfigs {
        create("release") {
            if (keystoreProperties.isNotEmpty()) {
                keyAlias = keystoreProperties["keyAlias"] as String?
                keyPassword = keystoreProperties["keyPassword"] as String?
                storePassword = keystoreProperties["storePassword"] as String?
                
                // ====== CRITICAL FIX ======
                // Resolve storeFile path relative to the rootProject (android/ directory)
                val storeFilePath = keystoreProperties["storeFile"] as String?
                if (storeFilePath != null) {
                    storeFile = rootProject.file(storeFilePath)
                    println("Signing config: Using keystore from ${storeFile?.absolutePath}")
                }
            }
        }
    }

    buildTypes {
        release {
            if (keystoreProperties.isNotEmpty()) {
                // Apply the release signing configuration
                signingConfig = signingConfigs.getByName("release")
                
                // Enable code obfuscation and resource shrinking for production
                isMinifyEnabled = true
                isShrinkResources = true
                
                // ProGuard configuration files
                proguardFiles(
                    getDefaultProguardFile("proguard-android-optimize.txt"),
                    "proguard-rules.pro"
                )
            }
        }
    }
}

flutter {
    source = "../.."
}

dependencies {
    // Desugaring library for Java 17 compatibility on older Android
    coreLibraryDesugaring("com.android.tools:desugar_jdk_libs:2.1.4")
}

// ============================================================================
// PATH RESOLUTION EXPLANATION
// ============================================================================
// 
// In Android Gradle builds:
// - rootProject = the android/ directory
// - rootProject.file(path) resolves relative to android/
// - file(path) resolves relative to the current build file (android/app/)
//
// So with storeFile=app/addmagpro.jks in key.properties:
//
// WRONG METHOD:
//   file("app/addmagpro.jks")
//   → android/app/ + app/addmagpro.jks
//   → android/app/app/addmagpro.jks ❌ (WRONG!)
//
// CORRECT METHOD:
//   rootProject.file("app/addmagpro.jks")
//   → android/ + app/addmagpro.jks
//   → android/app/addmagpro.jks ✓ (CORRECT!)
//
// ============================================================================
