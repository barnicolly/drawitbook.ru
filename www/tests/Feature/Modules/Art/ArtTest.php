<?php

namespace Tests\Feature\Modules\Art;

use Tests\TestCase;

class ArtTest extends TestCase
{

    public function providerTestArtPageResponseCode200(): array
    {
        return [
            [
                144,
            ],
            [
                7,
            ],
        ];
    }

    /**
     * @dataProvider providerTestArtPageResponseCode200
     *
     * @param string $id
     */
    public function testArtPageResponseCode200(string $id): void
    {
        $response = $this->get(route('art', ['id' => $id]));
        $response->assertStatus(200);
    }

    public function testArtResponseCode404() : void
    {
        $response = $this->get('/art');
        $response->assertStatus(404);
    }
}
