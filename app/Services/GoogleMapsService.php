<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GoogleMapsService
{
    protected $apiKey;
    protected $enabled;

    public function __construct()
    {
        $this->apiKey = config('google-maps.api_key');
        $this->enabled = config('google-maps.enabled');
    }

    /**
     * Reverse geocode coordinates to get address
     * @param float $latitude
     * @param float $longitude
     * @return array|null
     */
    public function reverseGeocode($latitude, $longitude)
    {
        if (!$this->enabled || !$this->apiKey) {
            return null;
        }

        try {
            $cacheKey = "geocode_{$latitude}_{$longitude}";
            return Cache::remember($cacheKey, 3600, function () use ($latitude, $longitude) {
                $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'latlng' => "{$latitude},{$longitude}",
                    'key' => $this->apiKey,
                ]);

                if ($response->successful() && $response->json('status') === 'OK') {
                    $results = $response->json('results');
                    if (!empty($results)) {
                        $location = $results[0];
                        return [
                            'address' => $location['formatted_address'] ?? null,
                            'city' => $this->extractComponent($location, 'locality'),
                            'state' => $this->extractComponent($location, 'administrative_area_level_1'),
                            'country' => $this->extractComponent($location, 'country'),
                            'postal_code' => $this->extractComponent($location, 'postal_code'),
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                        ];
                    }
                }
                return null;
            });
        } catch (\Exception $e) {
            \Log::error('Google Geocoding Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get location from address
     * @param string $address
     * @return array|null
     */
    public function geocode($address)
    {
        if (!$this->enabled || !$this->apiKey) {
            return null;
        }

        try {
            $cacheKey = "address_" . md5($address);
            return Cache::remember($cacheKey, 3600, function () use ($address) {
                $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $address,
                    'key' => $this->apiKey,
                ]);

                if ($response->successful() && $response->json('status') === 'OK') {
                    $results = $response->json('results');
                    if (!empty($results)) {
                        $location = $results[0];
                        $geometry = $location['geometry']['location'] ?? [];
                        return [
                            'address' => $location['formatted_address'] ?? null,
                            'city' => $this->extractComponent($location, 'locality'),
                            'state' => $this->extractComponent($location, 'administrative_area_level_1'),
                            'country' => $this->extractComponent($location, 'country'),
                            'postal_code' => $this->extractComponent($location, 'postal_code'),
                            'latitude' => $geometry['lat'] ?? null,
                            'longitude' => $geometry['lng'] ?? null,
                        ];
                    }
                }
                return null;
            });
        } catch (\Exception $e) {
            \Log::error('Google Geocoding Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get place suggestions (autocomplete)
     * @param string $input
     * @param string $componentFilter (optional, e.g., 'country:in')
     * @return array
     */
    public function getPlaceSuggestions($input, $componentFilter = null)
    {
        if (!$this->enabled || !$this->apiKey) {
            return [];
        }

        try {
            $params = [
                'input' => $input,
                'key' => $this->apiKey,
                'components' => $componentFilter ?? 'country:in', // Default to India
            ];

            $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json', $params);

            if ($response->successful() && $response->json('status') === 'OK') {
                $predictions = $response->json('predictions', []);
                return array_map(function ($prediction) {
                    return [
                        'place_id' => $prediction['place_id'] ?? null,
                        'description' => $prediction['description'] ?? null,
                        'main_text' => $prediction['structured_formatting']['main_text'] ?? null,
                        'secondary_text' => $prediction['structured_formatting']['secondary_text'] ?? null,
                    ];
                }, $predictions);
            }
            return [];
        } catch (\Exception $e) {
            \Log::error('Google Places Autocomplete Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get details from place ID
     * @param string $placeId
     * @return array|null
     */
    public function getPlaceDetails($placeId)
    {
        if (!$this->enabled || !$this->apiKey) {
            return null;
        }

        try {
            $cacheKey = "place_" . $placeId;
            return Cache::remember($cacheKey, 3600, function () use ($placeId) {
                $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'fields' => 'formatted_address,geometry,address_components,name',
                    'key' => $this->apiKey,
                ]);

                if ($response->successful() && $response->json('status') === 'OK') {
                    $result = $response->json('result');
                    $geometry = $result['geometry']['location'] ?? [];
                    return [
                        'name' => $result['name'] ?? null,
                        'address' => $result['formatted_address'] ?? null,
                        'city' => $this->extractAddressComponent($result, 'locality'),
                        'state' => $this->extractAddressComponent($result, 'administrative_area_level_1'),
                        'country' => $this->extractAddressComponent($result, 'country'),
                        'postal_code' => $this->extractAddressComponent($result, 'postal_code'),
                        'latitude' => $geometry['lat'] ?? null,
                        'longitude' => $geometry['lng'] ?? null,
                    ];
                }
                return null;
            });
        } catch (\Exception $e) {
            \Log::error('Google Place Details Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extract component from geocoding result
     */
    private function extractComponent($location, $componentType)
    {
        $components = $location['address_components'] ?? [];
        foreach ($components as $component) {
            if (in_array($componentType, $component['types'] ?? [])) {
                return $component['long_name'] ?? null;
            }
        }
        return null;
    }

    /**
     * Extract address component
     */
    private function extractAddressComponent($result, $componentType)
    {
        $components = $result['address_components'] ?? [];
        foreach ($components as $component) {
            if (in_array($componentType, $component['types'] ?? [])) {
                return $component['long_name'] ?? null;
            }
        }
        return null;
    }

    /**
     * Calculate distance between two coordinates (Haversine formula)
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * asin(sqrt($a));
        $distance = $earth_radius * $c;

        return round($distance, 2);
    }
}
