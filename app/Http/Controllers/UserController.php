<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class UserController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Kullanıcıları getirir.
     * @throws \Exception
     */
    public function index(): JsonResponse
    {
        try {
            $users = Cache::remember('users', 60, function () {
                return $this->userService->getAll();
            });
            return $this->jsonResponse($users, 200);
        } catch (\Exception $e) {
            return $this->jsonError(
                'Kullanıcılar getirilirken bir hata oluştu.',
                500,
                [$e->getMessage()]
            );
        }
    }

    /**
     * Yeni kullanıcı oluşturur.
     * @throws \Exception
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create($request->validated());
            Cache::forget('users'); // Cache'i güncellemek için temizle
            return $this->jsonResponse($user, 201);
        } catch (\Exception $e) {
            return $this->jsonError(
                'Kullanıcı oluşturulurken bir hata oluştu.',
                500,
                [$e->getMessage()]
            );
        }
    }

    /**
     * Belirli bir kullanıcıyı gösterir.
     * @throws \Exception
     */
    public function show($id): JsonResponse
    {
        try {
            $user = Cache::remember("user_{$id}", 60, function () use ($id) {
                return $this->userService->findById($id);
            });
            return $this->jsonResponse($user, 200);
        } catch (\Exception $e) {
            return $this->jsonError(
                "ID'si {$id} olan kullanıcı getirilirken hata oluştu.",
                500,
                [$e->getMessage()]
            );
        }
    }

    /**
     * Belirli bir kullanıcıyı günceller.
     * @throws \Exception
     */
    public function update(UserRequest $request, $id): JsonResponse
    {
        try {
            $updatedUser = $this->userService->update($id, $request->validated());
            Cache::forget('users'); // Genel cache temizlenir
            Cache::forget("user_{$id}"); // Spesifik kullanıcı cache'i temizlenir
            return $this->jsonResponse($updatedUser, 200);
        } catch (\Exception $e) {
            return $this->jsonError(
                "ID'si {$id} olan kullanıcı güncellenirken bir hata oluştu.",
                500,
                [$e->getMessage()]
            );
        }
    }

    /**
     * Belirli bir kullanıcıyı siler.
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->userService->delete($id);
            Cache::forget('users'); // Genel cache temizlenir
            Cache::forget("user_{$id}"); // Spesifik kullanıcı cache'i temizlenir
            return $this->jsonResponse($result, 200);
        } catch (\Exception $e) {
            return $this->jsonError(
                "ID'si {$id} olan kullanıcı silinirken bir hata oluştu.",
                500,
                [$e->getMessage()]
            );
        }
    }

    /**
     * Aktif kullanıcıları getirir.
     * @throws \Exception
     */
    public function activeUsers(): JsonResponse
    {
        try {
            $activeUsers = Cache::remember('active_users', 60, function () {
                return $this->userService->findActive();
            });
            return $this->jsonResponse($activeUsers, 200);
        } catch (\Exception $e) {
            return $this->jsonError(
                'Aktif kullanıcılar getirilirken bir hata oluştu.',
                500,
                [$e->getMessage()]
            );
        }
    }
}
