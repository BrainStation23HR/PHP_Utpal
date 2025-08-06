<?php

namespace App\Http\Repositories;


use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\Contracts\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record?->update($data);
        return $record;
    }

    public function delete($id)
    {
        return $this->find($id)?->delete();
    }
}
