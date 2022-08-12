<?php


namespace App\Repositories;

use App\Models\UserResponse;

class UserResponseRepository
{

    /**
     * @param int $userId
     * @param string $uuid
     */
    public function saveForm(int $userId,string $uuid)
    {
         UserResponse::create([
            'user_id' => $userId,
            'uuid' => $uuid,
        ]);
    }
}
