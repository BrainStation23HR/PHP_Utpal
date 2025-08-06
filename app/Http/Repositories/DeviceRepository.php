<?php 

namespace App\Http\Repositories;

use App\Models\Device;
use App\Http\Repositories\BaseRepository;

class DeviceRepository extends BaseRepository
{
    public function __construct(Device $model)
    {
        parent::__construct($model);
    }

}
