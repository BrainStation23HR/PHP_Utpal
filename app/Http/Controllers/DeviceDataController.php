<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Services\DeviceDataService;
use App\Http\Requests\StoreDeviceDataRequest;

class DeviceDataController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected DeviceDataService $service)
    {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreDeviceDataRequest $request)
    {
        $record = $this->service->store($request->validated());

        return $this->success($record, 'Device data stored');
    }
}
