<?php $__env->startSection('page_title', 'AddMagPro | Earn While You Shop & Share'); ?>

<?php $__env->startSection('extra_css'); ?>
<style>
    .hero-swiper {
        position: relative;
    }

    .hero-swiper .swiper-slide img {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
    }

    .member-card {
        border-radius: 12px;
        transition: transform .2s;
        text-decoration: none;
    }

    .member-card:hover {
        transform: translateY(-4px);
    }

    .stats-strip {
        background: #fff4e6;
        color: #222;
        padding: 2rem 0;
    }

    .stats-strip .stat-item h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #aa5500;
    }

    .stats-strip .stat-item p {
        margin: 0;
        font-size: .9rem;
        color: #444;
    }

    .section-heading {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-heading h2 {
        font-weight: 700;
        color: var(--title-color);
    }

    .section-heading p {
        color: var(--content-color);
    }

    .vendor-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .vendor-card {
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .07);
    }

    .discount-vendor-card {
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .07);
    }

    .discount-vendor-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .discount-badge {
        background: var(--theme-color);
        color: #fff;
        font-weight: 700;
        padding: .3rem .8rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: .4rem;
    }

    .event-card img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        border-radius: 8px;
    }

    .banner-full img {
        width: 100%;
        border-radius: 8px;
    }

    .gallery-grid img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* ====== NEW FEATURES QUICK ACCESS SECTION ====== */
    .feature-card {
        background: linear-gradient(135deg, #fff9f3 0%, #fff5e6 100%);
        border: 2px solid #f0e6d8;
        border-radius: 12px;
        padding: 1.5rem 1rem;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.8rem;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(170, 85, 0, 0.15);
        border-color: var(--theme-color);
        background: linear-gradient(135deg, #fff5e6 0%, #fff0d9 100%);
    }

    .feature-card-icon {
        font-size: 2.2rem;
        color: var(--theme-color);
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(170, 85, 0, 0.1);
        border-radius: 50%;
    }

    .feature-card-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--title-color);
        margin: 0;
    }

    .feature-card-desc {
        font-size: 0.75rem;
        color: var(--content-color);
        margin: 0;
    }

    .features-quick-access {
        background: linear-gradient(90deg, #f9f9f6 0%, #faf9f7 100%);
        padding: 2rem 0;
        margin-bottom: 1.5rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainsection'); ?>


<section class="hero-swiper pb-7" style="margin-top: 0 !important;">
    <div class="swiper hero-slider" id="heroSlider">
        <div class="swiper-wrapper">
            <?php if(isset($main_slider_banner)): ?>
            <?php $__currentLoopData = $main_slider_banner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide">
                <a href="<?php echo e($banner->banner_url ?? '#'); ?>">
                    <img src="<?php echo e(asset($banner->banner_image)); ?>" alt="Banner" loading="lazy">
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>


<?php if(session('service_user_id')): ?>
<section class="features-quick-access">
    <div class="custom-container">
        <div class="section-heading mb-4">
            <h2>Quick Access</h2>
            <p>Your shopping features</p>
        </div>
        <div class="row g-2 g-md-3">
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?php echo e(route('products_list')); ?>" class="feature-card">
                    <div class="feature-card-icon">
                        <i class="ri-shopping-bag-line"></i>
                    </div>
                    <h5 class="feature-card-title">Shop</h5>
                    <p class="feature-card-desc">Browse Products</p>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?php echo e(route('cart')); ?>" class="feature-card">
                    <div class="feature-card-icon">
                        <i class="ri-shopping-cart-line"></i>
                    </div>
                    <h5 class="feature-card-title">Cart</h5>
                    <p class="feature-card-desc">
                        <?php if(isset($cart_count) && $cart_count > 0): ?>
                        <?php echo e($cart_count); ?> items
                        <?php else: ?>
                        View Cart
                        <?php endif; ?>
                    </p>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?php echo e(route('wishlist')); ?>" class="feature-card">
                    <div class="feature-card-icon">
                        <i class="ri-heart-line"></i>
                    </div>
                    <h5 class="feature-card-title">Wishlist</h5>
                    <p class="feature-card-desc">Saved Items</p>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?php echo e(route('account_orders')); ?>" class="feature-card">
                    <div class="feature-card-icon">
                        <i class="ri-file-list-line"></i>
                    </div>
                    <h5 class="feature-card-title">Orders</h5>
                    <p class="feature-card-desc">My Orders</p>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?php echo e(route('user_wallet')); ?>" class="feature-card">
                    <div class="feature-card-icon">
                        <i class="ri-wallet-line"></i>
                    </div>
                    <h5 class="feature-card-title">Wallet</h5>
                    <p class="feature-card-desc">My Balance</p>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="<?php echo e(route('team_details')); ?>" class="feature-card">
                    <div class="feature-card-icon">
                        <i class="ri-share-forward-line"></i>
                    </div>
                    <h5 class="feature-card-title">Refer</h5>
                    <p class="feature-card-desc">Earn More</p>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<section class="category-section section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>Explore Memberships</h2>
            <p>Choose your category and start earning</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="<?php echo e(route('services_list')); ?>" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-briefcase-4-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Services</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="<?php echo e(route('user_stores_list')); ?>" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-store-2-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Stores</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="<?php echo e(route('products_list')); ?>" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-box-3-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Products</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="<?php echo e(route('classifieds_list')); ?>" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-file-list-3-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Classifieds</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="<?php echo e(route('popular_discounts_products')); ?>" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-discount-percent-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Discounts</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="<?php echo e(route('vendors_full_view')); ?>" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-building-2-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Vendors</h6>
                </a>
            </div>
        </div>
    </div>
</section>
<style>
    .member-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .1) !important;
    }

    .member-card:hover .ri-briefcase-4-line,
    .member-card:hover .ri-store-2-line,
    .member-card:hover .ri-box-3-line,
    .member-card:hover .ri-file-list-3-line,
    .member-card:hover .ri-discount-percent-line,
    .member-card:hover .ri-building-2-line {
        transform: scale(1.15);
        transition: transform .2s;
    }
</style>


<?php if(isset($ads_gallery)): ?>
<?php if(count($ads_gallery) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="swiper" id="adsSlider">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $ads_gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <a href="<?php echo e($ad->ads_banner_url ?? '#'); ?>">
                        <img src="<?php echo e(asset($ad->ads_banner_image)); ?>" alt="Ads Banner" class="img-fluid rounded" style="width:100%;">
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($banner1)): ?>
<?php if(count($banner1) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>Groceries</h2>
            <p>Get 100% cashback on grocery products</p>
        </div>
        <div class="banner-full">
            <a href="<?php echo e($banner1[0]->banner_url ?? '#'); ?>">
                <img src="<?php echo e(asset($banner1[0]->banner_image)); ?>" alt="Groceries Banner" class="img-fluid">
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($vendor_banners)): ?>
<?php if(count($vendor_banners) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2><?php echo e($headings[1]->heading ?? 'Featured Vendors'); ?></h2>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $vendor_banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="vendor-card">
                    <a href="<?php echo e(route('products_list_vendor', ['vendor_id' => $vb->vendor_id])); ?>">
                        <img src="<?php echo e(asset($vb->ImageURL)); ?>" alt="Vendor">
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-3">
            <a href="<?php echo e(route('vendors_full_view')); ?>" class="btn btn-outline-dark">View All Vendors</a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($banner2)): ?>
<?php if(count($banner2) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2><?php echo e($headings[2]->heading ?? 'Discount Stores'); ?></h2>
            <p>Select your best discount provider from the market</p>
        </div>
        <div class="banner-full">
            <a href="<?php echo e($banner2[0]->banner_url ?? '#'); ?>">
                <img src="<?php echo e(asset($banner2[0]->banner_image)); ?>" alt="Discounts Banner" class="img-fluid">
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($discount_vendor_banners)): ?>
<?php if(count($discount_vendor_banners) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-3">
            <?php $__currentLoopData = $discount_vendor_banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dvb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="discount-vendor-card">
                    <a href="<?php echo e(route('discount_vendor_detail', ['vendor_id' => $dvb->vendor_id])); ?>">
                        <img src="<?php echo e($dvb->banner_image); ?>" alt="<?php echo e($dvb->shop_name); ?>">
                    </a>
                    <div class="p-2 text-center">
                        <h6 class="fw-bold mb-1"><?php echo e($dvb->shop_name); ?></h6>
                        <p class="text-muted mb-1" style="font-size:.8rem;"><?php echo e($dvb->location); ?></p>
                        <span class="discount-badge"><?php echo e($dvb->discount_margin/2); ?>% Discount</span>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-3">
            <a href="<?php echo e(route('popular_discounts_products')); ?>" class="btn" style="background:var(--theme-color);color:#fff;">View All Discount Stores</a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($banner3)): ?>
<?php if(count($banner3) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>100% Cashback Products</h2>
        </div>
        <div class="banner-full">
            <a href="<?php echo e($banner3[0]->banner_url ?? '#'); ?>">
                <img src="<?php echo e(asset($banner3[0]->banner_image)); ?>" alt="Cashback Banner" class="img-fluid">
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($gadget_gallery)): ?>
<?php if(count($gadget_gallery) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-2">
            <?php $__currentLoopData = $gadget_gallery->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-3">
                <a href="<?php echo e($g->gadget_gallery_url ?? '#'); ?>">
                    <img src="<?php echo e(asset($g->gadget_gallery_image)); ?>" alt="Gallery" class="img-fluid rounded" style="height:160px;width:100%;object-fit:cover;">
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<section class="product-tab-section section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2><?php echo e($headings[3]->heading ?? 'Shop Our Products'); ?></h2>
        </div>
        <div class="row">
            <div class="col-auto mx-auto">
                <ul class="nav nav-pills flex-nowrap" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-latest" type="button">New Arrivals</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-special" type="button">Special Offers</button>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="tab-latest">
                <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <?php if(isset($latest_products)): ?>
                    <?php $__currentLoopData = $latest_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="product-box productMain h-100">
                            <div class="product-image">
                                <a href="<?php echo e(route('latest_products_view')); ?>">
                                    <img src="<?php echo e($lp->product_images ?? asset('assets/kartify/images/product/placeholder.png')); ?>" class="img-fluid" alt="<?php echo e($lp->product_name); ?>">
                                </a>
                                <ul class="product-option">
                                    <li title="Wishlist">
                                        <a href="<?php echo e(route('add_to_wishlist', ['product_id' => $lp->product_id])); ?>">
                                            <i class="iconsax" data-icon-name="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-detail">
                                <a href="<?php echo e(route('latest_products_view')); ?>">
                                    <h5 class="name"><?php echo e($lp->product_name); ?></h5>
                                </a>
                                <h5 class="price theme-color">&#8377;<?php echo e(number_format($lp->selling_price ?? $lp->purchase_price, 2)); ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo e(route('latest_products_view')); ?>" class="btn btn-outline-dark">View All New Arrivals</a>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-special">
                <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <?php if(isset($products)): ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(($product->purchase_price ?? 0) > 3000): ?>
                    <div class="col">
                        <div class="product-box productMain h-100">
                            <div class="product-image">
                                <a href="<?php echo e(route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id])); ?>">
                                    <img src="<?php echo e($product->product_images ?? asset('assets/kartify/images/product/placeholder.png')); ?>" class="img-fluid" alt="<?php echo e($product->product_name); ?>">
                                </a>
                                <ul class="product-option">
                                    <li title="Wishlist">
                                        <a href="<?php echo e(route('add_to_wishlist', ['product_id' => $product->product_id])); ?>">
                                            <i class="iconsax" data-icon-name="heart"></i>
                                        </a>
                                    </li>
                                    <li title="Add to Cart">
                                        <a href="<?php echo e(route('add_to_cart', ['product_id' => $product->product_id, 'quantity' => 1])); ?>">
                                            <i class="iconsax" data-icon-name="basket-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-detail">
                                <a href="<?php echo e(route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id])); ?>">
                                    <h5 class="name"><?php echo e($product->product_name); ?></h5>
                                </a>
                                <h5 class="price theme-color">&#8377;<?php echo e(number_format($product->purchase_price, 2)); ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo e(route('products_list')); ?>" class="btn btn-outline-dark">View All Products</a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php if(isset($categories)): ?>
<?php if(count($categories) > 0): ?>
<section class="section-b-space" style="background:var(--section-bg-color,#f9f9f6);">
    <div class="custom-container py-4">
        <div class="section-heading">
            <h2><?php echo e($headings[4]->heading ?? 'Shop by Category'); ?></h2>
            <p>Select your favourite category and start shopping</p>
        </div>
        <div class="swiper" id="categorySlider" style="padding-bottom:2.25rem;">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide text-center">
                    <a href="<?php echo e(route('top_category_products_list', ['category_id' => $cat->id])); ?>" class="d-block text-decoration-none">
                        <img src="<?php echo e($cat->ImageURL); ?>" class="img-fluid rounded-circle" alt="<?php echo e($cat->CategoryName); ?>" style="height:80px;width:80px;object-fit:cover;">
                        <h6 class="mt-2 fw-bold" style="color:var(--title-color);font-size:.8rem;"><?php echo e($cat->CategoryName); ?></h6>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($store_gallery)): ?>
<?php if(count($store_gallery) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2><?php echo e($headings[6]->heading ?? 'Popular Stores'); ?></h2>
            <p>Select your best speciality store from the market</p>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $store_gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-3">
                <img src="<?php echo e(asset($sg['store_image'])); ?>" alt="Store" class="img-fluid rounded gallery-grid">
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($banner4)): ?>
<?php if(count($banner4) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2><?php echo e($headings[7]->heading ?? 'Speciality Stores'); ?></h2>
        </div>
        <div class="banner-full">
            <a href="<?php echo e($banner4[0]->banner_url ?? '#'); ?>">
                <img src="<?php echo e(asset($banner4[0]->banner_image)); ?>" alt="Banner" class="img-fluid">
            </a>
        </div>
        <?php if(isset($store_gallery_mini)): ?>
        <div class="row g-2 mt-2">
            <?php $__currentLoopData = $store_gallery_mini; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sgm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-3">
                <img src="<?php echo e(asset($sgm['store_image'])); ?>" alt="Store" class="img-fluid rounded">
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($event_banners)): ?>
<?php if(count($event_banners) > 0): ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2><?php echo e($headings[8]->heading ?? 'Upcoming Events'); ?></h2>
            <p>Do not miss out on our exciting events</p>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $event_banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="event-card">
                    <img src="<?php echo e(asset($ev->event_banner_image)); ?>" alt="Event" class="img-fluid rounded">
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>


<section class="stats-strip">
    <div class="custom-container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3 stat-item">
                <h3><?php echo e($visitor_users_count ?? '0'); ?>+</h3>
                <p>Total Visitors</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h3><?php echo e($active_users_count ?? '0'); ?>+</h3>
                <p>Total Joinings</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h3><?php echo e($total_joinings ?? '0'); ?>+</h3>
                <p>Active Members</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h3>100%</h3>
                <p>Cashback Guaranteed</p>
            </div>
        </div>
    </div>
</section>


<section class="section-b-space section-t-space">
    <div class="custom-container">
        <div class="text-center py-4 px-3 rounded" style="background:linear-gradient(135deg,#aa5500 0%,#7a2800 100%);">

            <h2 class="fw-bold mb-2" style="color:#fff!important;">Join AddMagPro Today</h2>
            <p class="mb-3" style="color:rgba(255,255,255,0.9)!important;">Earn while you shop, refer friends, and grow your income!</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <?php if(!session('service_user_id')): ?>
                <a href="<?php echo e(route('service_user_registration')); ?>" class="btn btn-light fw-bold" style="color:var(--theme-color);">Register Now</a>
                <a href="<?php echo e(route('landingpage')); ?>" class="btn btn-outline-light fw-bold">Sign In</a>
                <?php else: ?>
                <a href="<?php echo e(route('team_details')); ?>" class="btn btn-light fw-bold" style="color:var(--theme-color);">Refer &amp; Earn</a>
                <a href="<?php echo e(route('products_list')); ?>" class="btn btn-outline-light fw-bold">Shop Now</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('heroSlider')) {
            new Swiper('#heroSlider', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        }
        if (document.getElementById('adsSlider')) {
            new Swiper('#adsSlider', {
                loop: true,
                autoplay: {
                    delay: 3000
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                slidesPerView: 1,
                spaceBetween: 10
            });
        }
        if (document.getElementById('categorySlider')) {
            new Swiper('#categorySlider', {
                slidesPerView: 2,
                spaceBetween: 12,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                breakpoints: {
                    480: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 4
                    },
                    992: {
                        slidesPerView: 6
                    },
                    1200: {
                        slidesPerView: 8
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('service_user_dashboard_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/service_users/welcome.blade.php ENDPATH**/ ?>