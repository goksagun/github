<?php

namespace App\Repositories;

use App\User;

class UserRepository {
    public function findByUserNameOrCreate($userData) {
        $user = User::where('provider_id', '=', $userData->id)->first();
        if(!$user) {
            $user = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'username' => $user->getNickname(),
                'avatar' => $user->getAvatar(),
                'provider_id' => $user->getId(),
            ]);
        }

        $this->checkIfUserNeedsUpdating($userData, $user);
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user) {

        $socialData = [
            'avatar' => $userData->avatar,
            'email' => $userData->email,
            'name' => $userData->name,
            'username' => $userData->nickname,
        ];
        $dbData = [
            'avatar' => $user->avatar,
            'email' => $user->email,
            'name' => $user->name,
            'username' => $user->username,
        ];

        if (!empty(array_diff($socialData, $dbData))) {
            $user->avatar = $userData->avatar;
            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->username = $userData->nickname;
            $user->save();
        }
    }
}