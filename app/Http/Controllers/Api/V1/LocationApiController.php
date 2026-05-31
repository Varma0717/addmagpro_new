<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\GoogleMapsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    use ApiResponse;

    protected $googleMaps;

    public function __construct(GoogleMapsService $googleMaps)
    {
        $this->googleMaps = $googleMaps;
    }

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
     * Detect location from coordinates using Google Maps
     */
    public function detect(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');

        if ($latitude && $longitude) {
            // Use Google Maps reverse geocoding
            $googleLocation = $this->googleMaps->reverseGeocode($latitude, $longitude);
            if ($googleLocation) {
                return $this->successResponse($googleLocation, 'Location detected via Google Maps');
            }
        }

        // Fallback: return default location or nearby locations
        return $this->successResponse([
            'detected' => false,
            'message' => 'Unable to detect precise location. Please provide coordinates or select from available locations.',
            'fallback_locations' => Location::where('is_active', true)
                ->limit(10)
                ->get(['id', 'city', 'state', 'latitude', 'longitude']),
        ], 'Location detection fallback');
    }

    /**
     * Get place suggestions (autocomplete)
     */
    public function searchPlaces(Request $request)
    {
        $input = $request->get('q');
        if (!$input || strlen($input) < 2) {
            return $this->errorResponse('Search query must be at least 2 characters', [], 400);
        }

        $suggestions = $this->googleMaps->getPlaceSuggestions($input);
        return $this->successResponse($suggestions, 'Place suggestions retrieved');
    }

    /**
     * Get place details from Google Maps
     */
    public function getPlaceDetails(Request $request)
    {
        $placeId = $request->get('place_id');
        if (!$placeId) {
            return $this->errorResponse('Place ID is required', [], 400);
        }

        $details = $this->googleMaps->getPlaceDetails($placeId);
        if (!$details) {
            return $this->errorResponse('Unable to fetch place details', [], 404);
        }

        return $this->successResponse($details, 'Place details retrieved');
    }

    /**
     * Reverse geocode coordinates to get address
     */
    public function reverseGeocode(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');

        if (!$latitude || !$longitude) {
            return $this->errorResponse('Latitude and longitude are required', [], 400);
        }

        $location = $this->googleMaps->reverseGeocode($latitude, $longitude);
        if (!$location) {
            return $this->errorResponse('Unable to reverse geocode location', [], 404);
        }

        return $this->successResponse($location, 'Address retrieved via reverse geocoding');
    }

    /**
     * Geocode address to coordinates
     */
    public function geocodeAddress(Request $request)
    {
        $address = $request->get('address');
        if (!$address) {
            return $this->errorResponse('Address is required', [], 400);
        }

        $location = $this->googleMaps->geocode($address);
        if (!$location) {
            return $this->errorResponse('Unable to geocode address', [], 404);
        }

        return $this->successResponse($location, 'Coordinates retrieved for address');

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
