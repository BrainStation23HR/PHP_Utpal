<?php 

namespace App\Http\Repositories;

use App\Models\DeviceData;
use App\Http\Repositories\BaseRepository;

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
}
