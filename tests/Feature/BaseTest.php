<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    public function login() : User
    {
        $user = factory(User::class)->create();

        $this->be($user);

        return $user;
    }
}