<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DeviceDataService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class DeviceStatusController extends Controller
{
    use ApiResponseTrait;

    /**
     *
     * @param DeviceDataService $service
     */
    public function __construct(protected DeviceDataService $service)
    {}
    
    /**
     *
     * @param integer $deviceId
     * @return JsonResponse
     */
    public function __invoke(int $deviceId): JsonResponse
    {
    $status = $this->service->getLatestStatus($deviceId);

    if (!$status) {
        return $this->error('Device status not found.', 404);
    }
    return $this->success('Device status fetched successfully.', $status);
    }
}
