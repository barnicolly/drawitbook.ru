<?php

namespace App\Ship\Parents\Tests;

use App\Containers\Authorization\Enums\RoleEnum;
use App\Containers\Authorization\Models\Role;
use App\Containers\Translation\Data\Seeders\TranslatorLanguagesSeeder;
use App\Containers\User\Models\User;
use App\Ship\Parents\Seeders\DatabaseSeeder;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected RouteService $routeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->routeService = app(RouteService::class);
        $this->artisan('migrate');
        $this->truncateTables();
        $this->seedTranslatorLanguages();
    }

    /**
     * Make ajax POST request
     * @param $uri
     * @param array $data
     * @return TestResponse
     */
    protected function ajaxPost($uri, array $data = []): TestResponse
    {
        \Session::start();
        $data = array_merge($data, [
            "_token" => csrf_token(),
        ]);
        return $this->post($uri, $data, [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
    }

    /**
     * Make ajax GET request
     */
    protected function ajaxGet($uri): TestResponse
    {
        return $this->get(
            $uri,
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]
        );
    }

    public function assertRouteUsesMiddleware(string $routeName, array $middlewares, bool $exact = false): void
    {
        $router = resolve(\Illuminate\Routing\Router::class);

        $route = $router->getRoutes()->getByName($routeName);
        $usedMiddlewares = $route->gatherMiddleware();

        Assert::assertNotNull($route, "Unable to find route for name `$routeName`");

        if ($exact) {
            $unusedMiddlewares = array_diff($middlewares, $usedMiddlewares);
            $extraMiddlewares = array_diff($usedMiddlewares, $middlewares);

            $messages = [];

            if ($extraMiddlewares) {
                $messages[] = "uses unexpected `" . implode(', ', $extraMiddlewares) . "` middlware(s)";
            }

            if ($unusedMiddlewares) {
                $messages[] = "doesn't use expected `" . implode(', ', $unusedMiddlewares) . "` middlware(s)";
            }

            $messages = implode(" and ", $messages);

            Assert::assertSame(
                count($unusedMiddlewares) + count($extraMiddlewares),
                0,
                "Route `$routeName` " . $messages
            );
        } else {
            $unusedMiddlewares = array_diff($middlewares, $usedMiddlewares);

            Assert::assertEmpty(
                $unusedMiddlewares,
                "Route `$routeName` does not use expected `" . implode(
                    ', ',
                    $unusedMiddlewares
                ) . "` middleware(s)"
            );
        }
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

    private function seedTranslatorLanguages(): void
    {
        app(DatabaseSeeder::class)->call(TranslatorLanguagesSeeder::class);
    }

    private function truncateTables(): void
    {
        $excludeTables = [
            'migrations',
        ];
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        if (!empty($tableNames)) {
            $tableNamesForTruncate = array_diff($tableNames, $excludeTables);
            if (!empty($tableNamesForTruncate)) {
                $queries = [];
                foreach ($tableNamesForTruncate as $tableName) {
                    $queries[] = 'TRUNCATE TABLE ' . $tableName . ';';
                }
                Schema::disableForeignKeyConstraints();
                DB::unprepared(implode(' ', $queries));
                Schema::enableForeignKeyConstraints();
            }
        }
    }
}
