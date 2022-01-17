<?php

namespace App\Http\Requests\Records;

use App\Models\Record;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Returns store record request rules.
     *
     * In case if request is transfer rule will contain {to} wallet rule.
     * Otherwise rules will contain {type} rule.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'from' => ['required', 'exists:App\Models\Wallet,id'],
            'description' => ['string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0']
        ];

        if ($this->get('isTransfer')) {
            $rules['to'] = ['required', 'exists:App\Models\Wallet,id', 'different:from'];
        } else {
            $rules['type'] = ['required', Rule::in(Record::TYPES)];
        }

        try {
            // in case if there is transfer or debit type we need to validate amount of wallet
            // from which we will decrease given amount from request
            if ($this->get('isTransfer') || $this->get('type') === Record::TYPE_DEBIT) {
                // get amount of wallet from which need to decrease amount
                $fromWallet = Wallet::findOrFail($this->get('from'));

                $fromWalletAmount = $fromWallet->amount;
                $rules['amount'] = ['required', 'numeric', "between:0,$fromWalletAmount"];
            }
        } catch (ModelNotFoundException $ex) {

        }

        return $rules;
    }
}
