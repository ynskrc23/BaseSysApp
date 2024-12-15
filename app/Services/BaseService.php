<?php

namespace App\Services;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class BaseService
{
    protected BaseRepositoryInterface $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function getAll()
    {
        try {
            return $this->repository->getAll();
        } catch (Exception $e) {
            throw new Exception('Records could not be retrieved.');
        }
    }

    /**
     * @throws Exception
     */
    public function findById($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (Exception $e) {
            throw new Exception("Record with ID $id could not be found.");
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->repository->create($data);
            });
        } catch (Exception $e) {
            throw new Exception('Record could not be created.');
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, array $data)
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                return $this->repository->update($id, $data);
            });
        } catch (Exception $e) {
            throw new Exception("Record with ID $id could not be updated.");
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->repository->delete($id);
            });
        } catch (Exception $e) {
            throw new Exception("Record with ID $id could not be deleted.");
        }
    }

    public function findActive()
    {
        try {
            return $this->repository->findActive();
        } catch (Exception $e) {
            throw new Exception('Records could not be retrieved.');
        }
    }
}
