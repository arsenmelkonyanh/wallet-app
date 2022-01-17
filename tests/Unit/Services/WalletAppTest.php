<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletType;
use Tests\TestCase;

abstract class WalletAppTest extends TestCase
{
    protected function getTestUserId(): int
    {
        return User::where('email', 'test@test.test')->first()->id;
    }

    protected function getTestWallet(string $name): Wallet
    {
        return Wallet::where('name', $name)->first();
    }

    protected function getTestWalletId(string $name): int
    {
        return $this->getTestWallet($name)->id;
    }

    protected function getTestWalletTypeId(string $name): int
    {
        return WalletType::where('name', $name)->first()->id;
    }

}
