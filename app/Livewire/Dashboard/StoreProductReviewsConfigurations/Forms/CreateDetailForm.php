<?php

namespace App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\StoreProductReviewsConfiguration;

class CreateDetailForm extends Form
{
    public $store_product_reviews_merchant_id = null;

    #[Rule('nullable|string')]
    public $config_name = '';

    #[Rule('nullable|string')]
    public $config_value = '';

    public function save()
    {
        $this->validate();

        $storeProductReviewsConfiguration = StoreProductReviewsConfiguration::create(
            $this->except([])
        );

        $this->reset();

        return $storeProductReviewsConfiguration;
    }
}
