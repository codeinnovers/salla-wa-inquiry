<?php

namespace App\Livewire\Dashboard\StoreProductReviewsMerchants\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\StoreProductReviewsMerchant;

class CreateForm extends Form
{
    #[Rule('nullable|string')]
    public $merchant_identifier = '';

    #[Rule('nullable|string')]
    public $name = '';

    #[Rule('nullable|string')]
    public $email = '';

    #[Rule('nullable|string')]
    public $store_link = '';

    #[Rule('nullable|string')]
    public $store_reference = '';

    #[Rule('nullable')]
    public $access_token = '';

    #[Rule('nullable')]
    public $refresh_token = '';

    #[Rule('nullable|date')]
    public $token_exp = '';

    public function save()
    {
        $this->validate();

        $storeProductReviewsMerchant = StoreProductReviewsMerchant::create(
            $this->except([])
        );

        $this->reset();

        return $storeProductReviewsMerchant;
    }
}
