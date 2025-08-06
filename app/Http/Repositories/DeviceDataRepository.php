<?php 

namespace App\Http\Repositories;

use App\Models\DeviceData;
use App\Http\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class DeviceDataRepository extends BaseRepository
{
    public function __construct(DeviceData $model)
    {
        parent::__construct($model);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function latestStatus(string $deviceId): ?DeviceData
    {
        return $this->model
            ->where('device_id', $deviceId)
            ->latest('event_timestamp')
            ->first();
    }

    public function getHistory(string $deviceId, string $from, string $to): Collection
    {
        return $this->model
            ->where('device_id', $deviceId)
            ->whereBetween('event_timestamp', [$from, $to]) 
            ->orderBy('event_timestamp', 'desc')
            ->get();
    }

}
