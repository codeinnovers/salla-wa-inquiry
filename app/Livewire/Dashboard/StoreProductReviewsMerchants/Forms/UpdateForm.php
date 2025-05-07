<?php

namespace App\Livewire\Dashboard\StoreProductReviewsMerchants\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use App\Models\StoreProductReviewsMerchant;

class UpdateForm extends Form
{
    public ?StoreProductReviewsMerchant $storeProductReviewsMerchant;

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

    public function setStoreProductReviewsMerchant(
        StoreProductReviewsMerchant $storeProductReviewsMerchant
    ) {
        $this->storeProductReviewsMerchant = $storeProductReviewsMerchant;

        $this->merchant_identifier =
            $storeProductReviewsMerchant->merchant_identifier;
        $this->name = $storeProductReviewsMerchant->name;
        $this->email = $storeProductReviewsMerchant->email;
        $this->store_link = $storeProductReviewsMerchant->store_link;
        $this->store_reference = $storeProductReviewsMerchant->store_reference;
        $this->access_token = $storeProductReviewsMerchant->access_token;
        $this->refresh_token = $storeProductReviewsMerchant->refresh_token;
        $this->token_exp = $storeProductReviewsMerchant->token_exp;
    }

    public function save()
    {
        $this->validate();

        $this->storeProductReviewsMerchant->update(
            $this->except(['storeProductReviewsMerchant'])
        );
    }
}
