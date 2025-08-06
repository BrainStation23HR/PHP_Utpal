<?php
namespace App\Http\Services;


use App\Events\DeviceDataReceived;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Http\Repositories\DeviceDataRepository;
use App\Http\Repositories\DeviceRepository;
use App\Models\Device;

class DeviceDataService
{
    protected string $cachePrefix = 'device_status:';
    protected int $cacheTtl = 60; // seconds

    public function __construct(protected DeviceDataRepository $repository, protected DeviceRepository $deviceRepository) {}

    public function store(array $data)
    {
        $record = $this->repository->create($data);

        Cache::put("device:{$record->device_id}:latest", $record, 3600);
        // broadcast(new DeviceDataReceived($record));

        return $record;
    }
    /**
     * Get latest device status
     *
     * @param integer $deviceId
     * @return array|null
     */
    public function getLatestStatus(int $deviceId): ?array
    {
        $cacheKey = $this->cachePrefix . $deviceId;

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($deviceId) {
            $latest = $this->repository->latestStatus($deviceId);
            return $latest ? [
                'device_id' => $latest->device_id,
                'status' => $latest->status,
                'timestamp' => $latest->timestamp,
            ] : null;
        });
    }

    /**
     * Get device status history
     *
     * @param integer $deviceId
     * @param string $from
     * @param string $to
     * @return Collection
     */
    public function getHistory(int $deviceId, string $from, string $to): Collection
    {
        return $this->repository->getHistory($deviceId, $from, $to);
    }

    /**
     * Update device meta data
     *
     * @param string $id
     * @param array $data
     * @return Device
     */
    public function updateDeviceMetaData(string $id, array $data): Device
    {
        return $this->deviceRepository->update($id, $data);
    }
    
}
