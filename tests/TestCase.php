<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\Resource\Seeders\WalletAppTestSeeder;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @throws \Throwable
     */
    public function setUp(): void
    {
        parent::setUp();
        DB::connection(env('DB_DRIVER'))->beginTransaction();
        $this->seed(WalletAppTestSeeder::class);
    }

    /**
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        DB::connection(env('DB_DRIVER'))->rollBack();
    }
}
