<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Services\DeviceDataService;
use App\Http\Requests\GetDeviceHistoryRequest;
use Illuminate\Http\JsonResponse;

class DeviceStatusHistoryController extends Controller
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
     * @param GetDeviceHistoryRequest $request
     * @param [type] $deviceId
     * @return JsonResponse
     */
    public function __invoke(GetDeviceHistoryRequest $request, $deviceId): JsonResponse
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $data = $this->service->getHistory($deviceId, $from, $to);

        return $this->success($data, 'Device history fetched');
    }
}
