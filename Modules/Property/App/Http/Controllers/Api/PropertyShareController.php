<?php

namespace Modules\Property\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Property\App\Models\Property;
use Modules\Property\Service\ShareService;

class PropertyShareController extends Controller
{
    protected $shareService;

    public function __construct(ShareService $shareService)
    {
        $this->shareService = $shareService;
    }

    /**
     * Generate a share link for a property
     *
     * @param Property $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateShareLink(Property $property)
    {
        $shareData = $this->shareService->generateShareLink($property);

        return returnMessage(true, 'تم إنشاء رابط المشاركة بنجاح', $shareData);
    }
}