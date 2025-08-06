<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Services\DeviceDataService;
use App\Http\Requests\StoreDeviceDataRequest;
use Illuminate\Http\JsonResponse;

class DeviceDataController extends Controller
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
     * @param StoreDeviceDataRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreDeviceDataRequest $request): JsonResponse
    {
        $record = $this->service->store($request->validated());

        return $this->success($record, 'Device data stored');
    }
}
