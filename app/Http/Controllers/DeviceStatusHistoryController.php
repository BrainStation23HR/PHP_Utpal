<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Services\DeviceDataService;
use App\Http\Requests\GetDeviceHistoryRequest;

class DeviceStatusHistoryController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected DeviceDataService $service)
    {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(GetDeviceHistoryRequest $request, $deviceId)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $data = $this->service->getHistory($deviceId, $from, $to);

        return $this->success($data, 'Device history fetched');
    }
}
