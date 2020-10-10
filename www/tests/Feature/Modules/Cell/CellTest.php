<?php

namespace Tests\Feature\Modules\Cell;

use Tests\TestCase;

class CellTest extends TestCase
{

    public function providerTestCellCategoryResponseCode200(): array
    {
        return [
            [
               'supergeroi',
            ],
            [
                'supermen',
            ],
            [
                'koshka',
            ],
        ];
    }

    /**
     * @dataProvider providerTestCellCategoryResponseCode200
     *
     * @param string $slug
     */
    public function testCellCategoryResponseCode200(string $slug): void
    {
        $response = $this->get(route('arts.cell') . '/' . $slug);
        $response->assertStatus(200);
    }

    public function testCellIndexResponseCode200(): void
    {
        $response = $this->get(route('arts.cell'));
        $response->assertStatus(200);
    }
}
