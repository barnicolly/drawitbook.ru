<?php

namespace App\Ship\Parents\Tests\Traits;

use Session;
use App\Containers\Authorization\Enums\RoleEnum;
use App\Containers\Authorization\Models\Role;
use App\Containers\User\Models\User;
use Illuminate\Testing\TestResponse;

trait RequestsTrait
{
    protected function ajaxPost(string $uri, array $data = []): TestResponse
    {
        Session::start();
        $data = array_merge($data, [
            '_token' => csrf_token(),
        ]);
        return $this->post($uri, $data, [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
    }

    protected function ajaxGet(string $uri): TestResponse
    {
        return $this->get(
            $uri,
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]
        );
    }

    protected function actingAsAdmin(): User
    {
        $user = User::factory()->create();
        $adminRole = Role::factory()->create(['name' => RoleEnum::ADMIN]);
        $user->roles()->attach($adminRole);
        $this->actingAs($user);
        return $user;
    }

    protected function actingAsUser(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }
}
