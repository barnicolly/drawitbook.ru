<?php

namespace App\Ship\Parents\Tests;

use App\Containers\Authorization\Enums\RoleEnum;
use App\Containers\Authorization\Models\Role;
use App\Containers\Translation\Data\Seeders\TranslatorLanguagesSeeder;
use App\Containers\User\Models\User;
use App\Ship\Parents\Seeders\DatabaseSeeder;
use App\Ship\Parents\Tests\Optimization\ClearTestPropertiesAfterTestTrait;
use App\Ship\Parents\Tests\Optimization\PrepareDbBeforeTestTrait;
use App\Ship\Services\Route\RouteService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use ClearTestPropertiesAfterTestTrait;
    use PrepareDbBeforeTestTrait;

    protected RouteService $routeService;
    protected bool $useTransactionsForTruncateTables;

    protected function setUp(): void
    {
        parent::setUp();
        $this->routeService = app(RouteService::class);
        if ($this->useTransactionsForTruncateTables) {
            $this->beginDatabaseTransaction();
        } else {
            $this->truncateTables();
        }
        $this->seedTranslatorLanguages();
        Cache::clear();
    }

    public function tearDown(): void
    {
        if ($this->useTransactionsForTruncateTables) {
            DB::rollBack();
        }
        parent::tearDown();
        $this->clearProperties();
    }

    public function refreshTestDatabase(): void
    {
        if (!RefreshDatabaseState::$migrated) {
            $this->artisan('migrate');
            RefreshDatabaseState::$migrated = true;
        }

        $this->useTransactionsForTruncateTables = config('testing.use_transactions_for_truncate_tables');
        if (!TruncateDatabaseState::$truncated && $this->useTransactionsForTruncateTables) {
            $this->truncateTables();
            TruncateDatabaseState::$truncated = true;
        }

        $this->app[Kernel::class]->setArtisan(null);
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

}
