<?php

namespace Modules\Property\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Property\Service\ShareService;

class ShareController extends Controller
{
    protected $shareService;

    public function __construct(ShareService $shareService)
    {
        $this->shareService = $shareService;
    }


    public function handleSharedLink(string $token)
    {
        try {
            $data = $this->shareService->handleSharedLink($token);
            $property = $data['property'];

            // Detect device type
            $userAgent = request()->header('User-Agent');
            $isIOS = strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false;
            $isAndroid = strpos($userAgent, 'Android') !== false;

            if ($isIOS) {
                $deepLink = $this->shareService->getDeepLinkUrl($property, 'ios');
                return redirect()->away($deepLink);
            } elseif ($isAndroid) {
                $deepLink = $this->shareService->getDeepLinkUrl($property, 'android');
                return redirect()->away($deepLink);
            } else {
                // Web fallback - show property or app download page
                return view('property.shared', compact('property'));
            }
        } catch (\Exception $e) {
            // Handle not found or other errors
            return redirect()->route('home')->with('error', 'The shared link is invalid or has expired.');
        }
    }
}