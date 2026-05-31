<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    use ApiResponse;

    /**
     * Get all locations
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $locations = Location::where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('city', 'like', "%{$search}%")
                    ->orWhere('state', 'like', "%{$search}%");
            })
            ->orderBy('city')
            ->get()
            ->map(function ($location) {
                return [
                    'id' => $location->id,
                    'city' => $location->city,
                    'state' => $location->state,
                    'country' => $location->country,
                    'latitude' => (float) $location->latitude,
                    'longitude' => (float) $location->longitude,
                    'timezone' => $location->timezone,
                ];
            });

        return $this->successResponse(
            $locations,
            'Locations retrieved'
        );
    }

    /**
     * Detect location from IP (GeoIP)
     */
    public function detect(Request $request)
    {
        // This would integrate with a GeoIP service
        // For now, return a default location or suggest using browser geolocation

        return $this->successResponse([
            'detected' => false,
            'message' => 'Use browser geolocation for accurate results',
            'fallback_locations' => Location::where('is_active', true)
                ->limit(5)
                ->get(['city', 'state', 'latitude', 'longitude']),
        ], 'Location detection initialized');
    }

    /**
     * Save user's location
     */
    public function saveUserLocation(Request $request)
    {
        $validated = $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        if ($request->has('location_id')) {
            // Update from predefined location
            $location = Location::find($validated['location_id']);
            if ($location) {
                $user->update([
                    'location_lat' => $location->latitude,
                    'location_lng' => $location->longitude,
                    'location_address' => $location->city . ', ' . $location->state,
                ]);
            }
        } else {
            // Update from custom lat/lng
            $user->update([
                'location_lat' => $validated['latitude'],
                'location_lng' => $validated['longitude'],
                'location_address' => $validated['address'],
            ]);
        }

        return $this->successResponse([
            'location' => [
                'latitude' => (float) $user->location_lat,
                'longitude' => (float) $user->location_lng,
                'address' => $user->location_address,
            ],
        ], 'Location saved successfully');
    }

    /**
     * Get nearby locations
     */
    public function nearby(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $radius = $request->get('radius', 50); // in km

        if (!$latitude || !$longitude) {
            return $this->errorResponse('Latitude and longitude are required', [], 400);
        }

        // Simple distance calculation (haversine formula)
        $locations = Location::where('is_active', true)
            ->selectRaw(
                '*, 
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                cos(radians(longitude) - radians(?)) + 
                sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$latitude, $longitude, $latitude]
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get()
            ->map(function ($location) {
                return [
                    'id' => $location->id,
                    'city' => $location->city,
                    'state' => $location->state,
                    'distance_km' => round($location->distance, 2),
                ];
            });

        return $this->successResponse(
            $locations,
            'Nearby locations retrieved'
        );
    }

    /**
     * Get all states
     */
    public function getStates(Request $request)
    {
        try {
            // Try with state_id first (if that's the primary key)
            $states = \App\Models\State::query()
                ->orderBy('state_name')
                ->get()
                ->map(function ($state) {
                    return [
                        'id' => $state->state_id ?? $state->id ?? null,
                        'state_name' => $state->state_name ?? 'Unknown',
                        'state_code' => $state->state_code ?? '',
                    ];
                });

            return $this->successResponse($states, 'States retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch states: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get districts for a specific state
     */
    public function getDistricts($stateId)
    {
        try {
            $districts = \App\Models\District::where('state_id', $stateId)
                ->orderBy('district_name')
                ->get()
                ->map(function ($district) {
                    return [
                        'id' => $district->district_id ?? $district->id ?? null,
                        'district_name' => $district->district_name ?? 'Unknown',
                        'state_id' => $district->state_id,
                    ];
                });

            return $this->successResponse($districts, 'Districts retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch districts: ' . $e->getMessage(),
                [],
                500
            );
        }
    }
}
