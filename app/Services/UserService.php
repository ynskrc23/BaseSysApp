<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected UserRepository $userRepository; // Özelliği tanımlama

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository; // Atama
    }

    // User'a özgü ek iş mantığı metotları buraya eklenebilir
}
