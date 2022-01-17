<?php

namespace Tests\Unit\Services;

use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\App;

class WalletServiceTest extends WalletAppTest
{

    /**
     *
     */
    public function test_create(): void
    {
        $walletService = App::make(WalletService::class);

        $testWalletTypeId = $this->getTestWalletTypeId('Cash');

        $params = [
            'name' => 'Test Wallet 3',
            'type' => $testWalletTypeId,
            'amount' => 10,
            'color' => Wallet::DEFAULT_COLOR
        ];

        $success = $walletService->create($params, $this->getTestUserId());

        $this->assertTrue($success);
    }

    /**
     *
     */
    public function test_delete(): void
    {
        $walletService = App::make(WalletService::class);

        $testWalletId = $this->getTestWalletId('Test Wallet 1');

        $success = $walletService->delete($testWalletId, $this->getTestUserId());

        $this->assertTrue($success);
    }

    /**
     *
     */
    public function test_increase_amount(): void
    {
        $walletService = App::make(WalletService::class);

        $testWallet = $this->getTestWallet('Test Wallet 1');

        $testWalletAmountBefore = (float)$testWallet->amount;

        $walletService->increaseAmount($testWallet, 50);

        $testWallet = $this->getTestWallet('Test Wallet 1');

        $testWalletAmountAfter = (float)$testWallet->amount;

        $this->assertSame($testWalletAmountBefore + 50, $testWalletAmountAfter);
    }

    /**
     *
     */
    public function test_decrease_amount(): void
    {
        $walletService = App::make(WalletService::class);

        $testWallet = $this->getTestWallet('Test Wallet 1');

        $testWalletAmountBefore = (float)$testWallet->amount;

        $walletService->decreaseAmount($testWallet, 50);

        $testWallet = $this->getTestWallet('Test Wallet 1');

        $testWalletAmountAfter = (float)$testWallet->amount;

        $this->assertSame($testWalletAmountBefore - 50, $testWalletAmountAfter);
    }
}
