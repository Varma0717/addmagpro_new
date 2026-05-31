# 📱 APP ICON REPLACEMENT QUICK GUIDE

## Current Problem
- App icon is generic orange Material Design icon
- Located in: `android/app/src/main/res/mipmap-**/ic_launcher.png`
- **MUST BE REPLACED** with website logo

---

## ⚡ FASTEST METHOD (5 minutes)

### Step 1: Prepare Your Logo
1. Open your website/logo image
2. Save as **512x512 PNG** (or larger)
3. Save to: `mobile-apps/addmagpro_mobile/assets/logo.png`

### Step 2: Use Flutter Generator
```bash
cd mobile-apps/addmagpro_mobile
flutter pub add flutter_launcher_icons
flutter pub run flutter_launcher_icons:main
```

**Done!** ✅ Icon will be auto-generated for all densities

---

## 🔧 MANUAL METHOD (if above doesn't work)

### Step 1: Prepare Icons for All Densities

You need to create your logo in these sizes:
- **mdpi**: 48x48 px
- **hdpi**: 72x72 px
- **xhdpi**: 96x96 px
- **xxhdpi**: 144x144 px
- **xxxhdpi**: 192x192 px

Use online tool: https://icoconvert.com/ (resize PNG to each size)

### Step 2: Replace Files Manually

Replace these files in your project:

```
android/app/src/main/res/
├── mipmap-mdpi/
│   ├── ic_launcher.png (48x48)
│   └── ic_launcher_foreground.png (48x48)
├── mipmap-hdpi/
│   ├── ic_launcher.png (72x72)
│   └── ic_launcher_foreground.png (72x72)
├── mipmap-xhdpi/
│   ├── ic_launcher.png (96x96)
│   └── ic_launcher_foreground.png (96x96)
├── mipmap-xxhdpi/
│   ├── ic_launcher.png (144x144)
│   └── ic_launcher_foreground.png (144x144)
└── mipmap-xxxhdpi/
    ├── ic_launcher.png (192x192)
    └── ic_launcher_foreground.png (192x192)
```

### Step 3: Rebuild
```bash
flutter clean
flutter pub get
flutter build apk --release
```

---

## 🎨 BEST PRACTICES

### Icon Design
- ✅ Square format (1:1 aspect ratio)
- ✅ Solid/opaque (no transparency needed for background)
- ✅ At least 192x192 px (higher is better)
- ✅ Clear and recognizable at small sizes

### For Adaptive Icon (Android 8+)
If you want a modern look with masked icon:

Create `flutter_launcher_icons.yaml`:
```yaml
flutter_launcher_icons:
  android:
    adaptive_icon_background: "#FFFFFF"
    adaptive_icon_foreground: "assets/logo.png"
```

---

## ✅ VERIFICATION

After replacing icon:

1. **Build APK**:
   ```bash
   flutter build apk --release
   ```

2. **Install on device**:
   ```bash
   flutter install
   ```

3. **Check**:
   - App icon on home screen should be your logo
   - Icon should appear in all size densities
   - Icon should NOT be the orange default anymore

---

## 🚨 TROUBLESHOOTING

### Icon doesn't change after rebuild
- [ ] Run `flutter clean` first
- [ ] Check file paths are correct
- [ ] Ensure PNG files are valid (try opening in image viewer)
- [ ] Clear app cache: Settings > Apps > AddMagPro > Clear Cache
- [ ] Reinstall app: `flutter install --reinstall`

### Icon looks blurry
- [ ] Icon source too small (use 192x192 minimum)
- [ ] Use PNG format (not JPEG)
- [ ] Ensure image is not compressed too much

### Only some icons changed
- [ ] Make sure you updated ALL density folders
- [ ] Don't forget `-foreground` variants
- [ ] Run `flutter clean` and rebuild

---

## 📋 ICON REPLACEMENT CHECKLIST

- [ ] Logo prepared (512x512 PNG)
- [ ] Logo saved to `mobile-apps/addmagpro_mobile/assets/logo.png`
- [ ] Ran `flutter pub get`
- [ ] Either:
  - [ ] Used flutter_launcher_icons tool, OR
  - [ ] Manually replaced files in all mipmap-* folders
- [ ] Ran `flutter clean`
- [ ] Ran `flutter build apk --release`
- [ ] Installed on device
- [ ] Verified icon is your logo (not orange default)
- [ ] Tested on multiple app density sizes

---

## ⏱️ TIME ESTIMATE

- Using flutter_launcher_icons: **5-10 minutes**
- Manual replacement: **15-30 minutes**
- Total with build: **20-40 minutes**

---

**Status**: Ready for icon replacement
**Next**: Replace icon → Test → Deploy to Play Store
