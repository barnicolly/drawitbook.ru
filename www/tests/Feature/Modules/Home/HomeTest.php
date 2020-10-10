<?php

namespace Tests\Feature\Modules\Home;

use Tests\TestCase;

class HomeTest extends TestCase
{

    public function testHomePageResponseCode200(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }
}
