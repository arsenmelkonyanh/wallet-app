<?php

namespace App\Http\Controllers\WalletApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\CreateRecordRequest;
use App\Services\RecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RecordsController extends Controller
{
    /**
     * Records list view.
     *
     * In case if user doesn't have any record redirects to wallets list.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $records = Auth::user()->getRecords();

        if ($records->isEmpty()) {
            return Redirect::route('wallets.index');
        }

        return view('wallet-app/records/records')->with('records', $records);
    }

    /**
     * Create record view.
     *
     * In case if user doesn't have any wallet redirects to create wallet.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $wallets = Auth::user()->getWallets();

        if ($wallets->isEmpty()) {
            return Redirect::route('wallets.create');
        }

        $walletsCount = count($wallets);

        return view('wallet-app/records/create')->with('wallets', $wallets)->with('walletsCount', $walletsCount);
    }

    /**
     * Stores record.
     *
     * @param CreateRecordRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRecordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        /** @var RecordService $recordService */
        $recordService = App::make(RecordService::class);

        $response = [];

        $userId = Auth::user()->getAuthIdentifier();

        if ($request->get('isTransfer')) {
            $response['success'] = $recordService->transfer($validated, $userId);
        } else {
            $response['success'] = $recordService->create($validated, $userId);
        }

        if ($response['success']) {
            $response['redirectTo'] = route('wallets.index');
        }

        return response()->json($response);
    }
}
