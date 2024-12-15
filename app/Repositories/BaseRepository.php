<?php
namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });
    }

    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $record = $this->model->findOrFail($id);
            $record->update($data);
            return $record;
        });
    }

    public function delete($id)
    {
        /** @var TYPE_NAME $data */
        return DB::transaction(function () use ($id, $data) {
            $record = $this->model->findOrFail($id);
            return $record->delete();
        });
    }

    public function findActive()
    {
        return $this->model->where('status', true)->get();
    }
}
