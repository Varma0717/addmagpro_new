@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Services | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">Our Services</h4>
            @if(!$service_used_count)
            <a href="{{ route('adding_service') }}" class="btn" style="background:var(--theme-color);color:#fff;">
                <i class="ri-add-line me-1"></i> List Your Service
            </a>
            @endif
        </div>
        <div class="row g-3">
            @foreach($services as $service)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('service_fullview', $service->service_id) }}" class="text-decoration-none">
                    <div class="text-center p-3 rounded border h-100" style="transition:.2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(255,153,0,.2)'" onmouseout="this.style.boxShadow=''">
                        @if($service->service_category_image ?? '')
                        <img src="{{ asset($service->service_category_image) }}" alt="{{ $service->service_name }}" style="width:80px;height:80px;object-fit:contain;margin-bottom:.75rem;">
                        @else
                        <div style="width:80px;height:80px;background:rgba(255,153,0,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                            <i class="ri-service-line" style="font-size:2rem;color:var(--theme-color);"></i>
                        </div>
                        @endif
                        <h6 class="fw-bold mb-0" style="color:var(--title-color);font-size:.9rem;">{{ $service->service_name }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
