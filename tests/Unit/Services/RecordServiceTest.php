<?php

namespace Tests\Unit\Services;

use App\Models\Record;
use App\Services\RecordService;
use Illuminate\Support\Facades\App;

class RecordServiceTest extends WalletAppTest
{

    /**
     *
     */
    public function test_transfer(): void
    {
        $recordService = App::make(RecordService::class);

        $fromWalletId = $this->getTestWalletId('Test Wallet 1');
        $toWalletId = $this->getTestWalletId('Test Wallet 2');

        $params = [
            'from' => $fromWalletId,
            'to' => $toWalletId,
            'amount' => 10,
            'description' => 'Test'
        ];

        $success = $recordService->transfer($params, $this->getTestUserId());

        $this->assertTrue($success);
    }

    /**
     *
     */
    public function test_create()
    {
        $recordService = App::make(RecordService::class);

        $wallet = $this->getTestWallet('Test Wallet 1');

        // test with only passing id of wallet
        $params = [
            'from' => $wallet->id,
            'type' => Record::TYPE_DEBIT,
            'amount' => 10,
            'description' => 'Test'
        ];

        $success = $recordService->create($params, $this->getTestUserId());

        $this->assertTrue($success);

        // test with only passing wallet model
        $params = [
            'type' => Record::TYPE_CREDIT,
            'amount' => 10,
            'description' => 'Test'
        ];

        $success = $recordService->create($params, $this->getTestUserId(), $wallet);

        $this->assertTrue($success);
    }

}
