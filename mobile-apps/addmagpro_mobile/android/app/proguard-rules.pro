# Flutter specific ProGuard rules
-keep class io.flutter.app.** { *; }
-keep class io.flutter.plugin.** { *; }
-keep class io.flutter.util.** { *; }
-keep class io.flutter.view.** { *; }
-keep class io.flutter.** { *; }
-keep class io.flutter.plugins.** { *; }
-dontwarn io.flutter.embedding.**

# Firebase specific rules
-keep class com.google.firebase.** { *; }
-dontwarn com.google.firebase.**

# Razorpay specific rules
-keep class com.razorpay.** { *; }
-dontwarn com.razorpay.**

# HTTP Client rules
-keep class okhttp3.** { *; }
-keep class com.squareup.okhttp3.** { *; }
-dontwarn okhttp3.**
-dontwarn com.squareup.okhttp3.**

# Keep all native methods
-keepclasseswithmembernames class * {
    native <methods>;
}

# Keep view constructors for inflation
-keepclasseswithmembers class * {
    public <init>(android.content.Context, android.util.AttributeSet);
}

# Preserve line numbers for debugging
-keepattributes SourceFile,LineNumberTable
-renamesourcefileattribute SourceFile

# Keep application classes
-keep class com.admagpro.mobile.** { *; }
-keepclassmembers class com.admagpro.mobile.** { *; }
