<?php

namespace App\Livewire\Dashboard\Merchants\Forms;

use Livewire\Form;
use App\Models\Merchant;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Merchant $merchant;

    public $merchant_identifier = '';

    public $name = '';

    public $email = '';

    public $store_link = '';

    public $store_reference = '';

    public $access_token = '';

    public $refresh_token = '';

    public $token_exp = '';

    public function rules(): array
    {
        return [
            'merchant_identifier' => ['nullable', 'string'],
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'store_link' => ['nullable', 'string'],
            'store_reference' => ['nullable', 'string'],
            'access_token' => ['nullable'],
            'refresh_token' => ['nullable'],
            'token_exp' => ['nullable', 'date'],
        ];
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;

        $this->merchant_identifier = $merchant->merchant_identifier;
        $this->name = $merchant->name;
        $this->email = $merchant->email;
        $this->store_link = $merchant->store_link;
        $this->store_reference = $merchant->store_reference;
        $this->access_token = $merchant->access_token;
        $this->refresh_token = $merchant->refresh_token;
        $this->token_exp = $merchant->token_exp;
    }

    public function save()
    {
        $this->validate();

        $this->merchant->update($this->except(['merchant']));
    }
}
