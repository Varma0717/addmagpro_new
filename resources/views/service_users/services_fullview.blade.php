@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Service Professionals | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services_list') }}">Services</a></li>
                <li class="breadcrumb-item active">Professionals</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Service Professionals</h4>
        <div class="row g-4">
            @forelse($service_users as $user)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                    @if($user->business_image ?? '')
                    <img src="{{ asset($user->business_image) }}" alt="{{ $user->member_name }}" style="width:100%;height:180px;object-fit:cover;">
                    @else
                    <div style="width:100%;height:180px;background:linear-gradient(135deg,var(--theme-color),#ff6600);display:flex;align-items:center;justify-content:center;">
                        <i class="ri-user-line" style="font-size:3rem;color:#fff;"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $user->member_name }}</h6>
                        <p class="text-muted mb-1" style="font-size:.85rem;"><i class="ri-phone-line me-1"></i>{{ $user->member_phone }}</p>
                        @if($user->address ?? '')
                        <p class="text-muted mb-1" style="font-size:.85rem;"><i class="ri-map-pin-line me-1"></i>{{ $user->address }}</p>
                        @endif
                        @if($user->description ?? '')
                        <p style="font-size:.85rem;">{{ Str::limit($user->description, 80) }}</p>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <a href="tel:{{ $user->member_phone }}" class="btn w-100" style="background:var(--theme-color);color:#fff;">
                            <i class="ri-phone-line me-1"></i> Contact Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="ri-search-line" style="font-size:3rem;color:#ccc;"></i>
                <p class="text-muted mt-2">No professionals listed yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
