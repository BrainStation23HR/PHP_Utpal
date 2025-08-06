<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DeviceDataService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class DeviceStatusController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected DeviceDataService $service)
    {}
    /**
     * Handle the incoming request.
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
