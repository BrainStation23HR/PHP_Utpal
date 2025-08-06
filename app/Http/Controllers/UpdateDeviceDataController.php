<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Services\DeviceDataService;
use App\Http\Requests\UpdateDeviceRequest;

class UpdateDeviceDataController extends Controller
{
   use ApiResponseTrait;

    public function __construct(protected DeviceDataService $service) {}

    /**
     * Update a device's metadata.
     *
     * @param UpdateDeviceRequest $request
     * @param Device $device
     * @return JsonResponse
     */
    public function __invoke(UpdateDeviceRequest $request, string $id): JsonResponse
    {
        $updatedDevice = $this->service->updateDeviceMetaData($id, $request->validated());

        return $this->success($updatedDevice, 'Device metadata updated successfully.');
    }
}
