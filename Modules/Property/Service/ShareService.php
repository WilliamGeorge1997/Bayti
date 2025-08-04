<?php

namespace Modules\Property\Service;

use Illuminate\Support\Str;
use Modules\Property\App\Models\Property;
use Modules\Property\App\Models\ShareLink;

class ShareService
{
    /**
     * Generate a share link for a property
     *
     * @param Property $property
     * @return array
     */
    public function generateShareLink(Property $property): array
    {
        $token = $this->generateUniqueToken();

        $shareLink = ShareLink::create([
            'property_id' => $property->id,
            'token' => $token
        ]);

        $url = url("/p/{$token}");

        return [
            'share_url' => $url,
            'token' => $token
        ];
    }

    /**
     * Handle a shared link when accessed
     *
     * @param string $token
     * @return array
     */
    public function handleSharedLink(string $token): array
    {
        $shareLink = ShareLink::where('token', $token)->firstOrFail();
        $shareLink->increment('clicks');

        $property = $shareLink->property;

        return [
            'property' => $property,
            'share_link' => $shareLink
        ];
    }

    /**
     * Generate a unique token for sharing
     *
     * @return string
     */
    private function generateUniqueToken(): string
    {
        $token = Str::random(10);

        // Ensure token is unique
        while (ShareLink::where('token', $token)->exists()) {
            $token = Str::random(10);
        }

        return $token;
    }

    /**
     * Get the deep link URL for a property based on platform
     *
     * @param Property $property
     * @param string|null $platform
     * @return string
     */
    public function getDeepLinkUrl(Property $property, ?string $platform = null): string
    {
        $appScheme = config('app.mobile_app_scheme', 'bayti');

        if ($platform === 'ios') {
            return "{$appScheme}://property/{$property->id}";
        } elseif ($platform === 'android') {
            // For Android, you can use either a custom scheme or an https URL with app links
            return "{$appScheme}://property/{$property->id}";
            // Alternative for Android App Links:
            // return "https://yourdomain.com/property/{$property->id}";
        }

        // Default fallback URL (web)
        return route('property.show', $property->id);
    }
}