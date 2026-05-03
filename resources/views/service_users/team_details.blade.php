@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Team Details | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">My Team</h4>
        <div class="row g-4">
            <div class="col-12">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">
                        <i class="ri-user-add-line me-2"></i>Direct Referrals ({{ $referred_users_by_login_person->count() }})
                    </h6>
                    @if($referred_users_by_login_person->isEmpty())
                    <p class="text-muted text-center py-3">No direct referrals yet. Share your referral link to grow your team!</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background:rgba(255,153,0,.08);">
                                <tr><th>#</th><th>Name</th><th>Mobile</th><th>Location</th><th>Joined</th></tr>
                            </thead>
                            <tbody>
                                @foreach($referred_users_by_login_person as $i => $member)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td class="fw-semibold">{{ $member->member_name }}</td>
                                    <td>{{ $member->member_phone }}</td>
                                    <td>{{ $member->location ?? '-' }}</td>
                                    <td>{{ $member->created_at ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            @if(!empty($chain_users))
            <div class="col-12">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">
                        <i class="ri-team-line me-2"></i>Network Chain ({{ count($chain_users) }})
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background:rgba(255,153,0,.08);">
                                <tr><th>#</th><th>Name</th><th>Mobile</th><th>Location</th></tr>
                            </thead>
                            <tbody>
                                @foreach($chain_users as $i => $member)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td class="fw-semibold">{{ $member['member_name'] }}</td>
                                    <td>{{ $member['member_phone'] }}</td>
                                    <td>{{ $member['location'] ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
