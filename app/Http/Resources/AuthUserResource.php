<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar_url' => $this->avatar_url,
            'kyc_status' => $this->kyc_status,
            'wallet_balance' => (float) $this->wallet_balance,
            'referral_code' => $this->referral_code,
            'location' => [
                'address' => $this->location_address,
                'latitude' => $this->location_lat,
                'longitude' => $this->location_lng,
            ],
            'preferences' => $this->preferences,
            'created_at' => $this->created_at,
        ];
    }
}
