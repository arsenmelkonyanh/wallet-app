<?php

namespace App\Http\Controllers\WalletApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallets\CreateWalletRequest;
use App\Models\WalletType;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WalletsController extends Controller
{
    /**
     * Wallets list view.
     *
     * In case if user doesn't have any wallet redirects to create wallet view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $wallets = Auth::user()->getWallets();

        if ($wallets->isEmpty()) {
            return Redirect::route('wallets.create');
        }

        $walletsTotal = 0;

        foreach ($wallets as $wallet) {
            $walletsTotal += $wallet->amount;
        }

        return view('wallet-app/index')
            ->with('wallets', $wallets)
            ->with('walletsTotal', $walletsTotal);
    }

    /**
     * Wallet create view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('wallet-app/wallets/create')->with('walletTypes', WalletType::all());
    }

    /**
     * Stores wallet.
     *
     * @param CreateWalletRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateWalletRequest $request): JsonResponse
    {
        /** @var WalletService $walletService */
        $walletService = App::make(WalletService::class);

        $userId = Auth::user()->getAuthIdentifier();

        $response = [];
        $response['success'] = $walletService->create($request->validated(), $userId);

        if ($response['success']) {
            $response['redirectTo'] = route('wallets.index');
        }

        return response()->json($response);
    }

    /**
     * Deletes wallet by given id.
     *
     * @param int $walletId
     *
     * @return JsonResponse
     */
    public function destroy(int $walletId): JsonResponse
    {
        /** @var WalletService $walletService */
        $walletService = App::make(WalletService::class);

        $userId = Auth::user()->getAuthIdentifier();

        try {
            $success = $walletService->delete($walletId, $userId);
            if (!$success) {
                Log::error('Unable to delete wallet', ['walletId' => $walletId]);
            }

            return response()->json(['success' => $success]);
        } catch (ModelNotFoundException $ex) {
            Log::error('Wallet not found', ['walletId' => $walletId]);

            return response()->json(['success' => false], 404);
        }
    }
}
