@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Classifieds | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item active">Classifieds</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">Classifieds</h4>
            <a href="{{ route('adding_classified') }}" class="btn" style="background:var(--theme-color);color:#fff;">
                <i class="ri-add-line me-1"></i> Post Classified
            </a>
        </div>
        <div class="row g-3">
            @foreach($classifieds as $classified)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('classified_fullview', $classified->id) }}" class="text-decoration-none">
                    <div class="text-center p-3 rounded border h-100" style="transition:.2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(255,153,0,.2)'" onmouseout="this.style.boxShadow=''">
                        @if($classified->classified_image ?? '')
                        <img src="{{ asset($classified->classified_image) }}" alt="{{ $classified->classified_name }}" style="width:80px;height:80px;object-fit:contain;margin-bottom:.75rem;">
                        @else
                        <div style="width:80px;height:80px;background:rgba(255,153,0,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                            <i class="ri-list-check" style="font-size:2rem;color:var(--theme-color);"></i>
                        </div>
                        @endif
                        <h6 class="fw-bold mb-0" style="color:var(--title-color);font-size:.9rem;">{{ $classified->classified_name }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
