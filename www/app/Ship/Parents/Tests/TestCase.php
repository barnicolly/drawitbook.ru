<?php

namespace App\Ship\Parents\Tests;

use App\Containers\Translation\Data\Seeders\TranslatorLanguagesSeeder;
use App\Ship\Parents\Seeders\DatabaseSeeder;
use App\Ship\Parents\Tests\Optimization\ClearTestPropertiesAfterTestTrait;
use App\Ship\Parents\Tests\Optimization\PrepareDbBeforeTestTrait;
use App\Ship\Parents\Tests\Traits\RequestsTrait;
use App\Ship\Services\Route\RouteService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use ReflectionClass;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use ClearTestPropertiesAfterTestTrait;
    use PrepareDbBeforeTestTrait;
    use ResponseAssertionsTrait;
    use RequestsTrait;

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

    private function seedTranslatorLanguages(): void
    {
        app(DatabaseSeeder::class)->call(TranslatorLanguagesSeeder::class);
    }

    final protected function getProtectedProperty(object|string $object, string $property): mixed
    {
        $reflection = new ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty->getValue($object);
    }

}
