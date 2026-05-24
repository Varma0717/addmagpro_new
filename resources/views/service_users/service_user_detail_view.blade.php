@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Professional Profile | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item active">Professional Profile</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        @foreach($service_users as $user)
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4">
                @if($user->business_image ?? '')
                <img src="{{ asset($user->business_image) }}" alt="{{ $user->member_name }}" class="img-fluid rounded" style="width:100%;max-height:320px;object-fit:cover;">
                @else
                <div class="rounded d-flex align-items-center justify-content-center" style="height:280px;background:linear-gradient(135deg,var(--theme-color),#7a2800);">
                    <i class="ri-user-line" style="font-size:5rem;color:#fff;"></i>
                </div>
                @endif
            </div>
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">{{ $user->member_name }}</h3>
                <p class="text-muted mb-3"><i class="ri-phone-line me-2"></i>{{ $user->member_phone }}</p>
                @if($user->address ?? '')
                <p class="mb-2"><i class="ri-map-pin-line me-2" style="color:var(--theme-color);"></i>{{ $user->address }}</p>
                @endif
                @if($user->description ?? '')
                <p class="mb-3">{{ $user->description }}</p>
                @endif
                <a href="tel:{{ $user->member_phone }}" class="btn" style="background:var(--theme-color);color:#fff;">
                    <i class="ri-phone-line me-1"></i> Contact Now
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
