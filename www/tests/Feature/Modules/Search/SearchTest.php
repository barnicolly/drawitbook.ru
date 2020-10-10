<?php

namespace Tests\Feature\Modules\Search;

use Tests\TestCase;

class SearchTest extends TestCase
{

    public function testSearchPageResponseCode200(): void
    {
        $response = $this->get(route('search'));
        $response->assertStatus(200);
    }
}
