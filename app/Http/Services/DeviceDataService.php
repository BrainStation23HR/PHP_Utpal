<?php
namespace App\Http\Services;


use App\Events\DeviceDataReceived;
use Illuminate\Support\Facades\Cache;
use App\Http\Repositories\DeviceDataRepository;

class DeviceDataService
{
    public function __construct(protected DeviceDataRepository $repository) {}

    public function store(array $data)
    {
        $record = $this->repository->create($data);

        Cache::put("device:{$record->device_id}:latest", $record, 3600);
        // broadcast(new DeviceDataReceived($record));

        return $record;
    }
}
