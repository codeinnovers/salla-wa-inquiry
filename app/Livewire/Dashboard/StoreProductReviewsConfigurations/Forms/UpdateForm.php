<?php

namespace App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use App\Models\StoreProductReviewsConfiguration;

class UpdateForm extends Form
{
    public ?StoreProductReviewsConfiguration $storeProductReviewsConfiguration;

    public $config_name = '';

    public $config_value = '';

    public $store_product_reviews_merchant_id = '';

    public function rules(): array
    {
        return [
            'config_name' => ['nullable', 'string'],
            'config_value' => ['nullable', 'string'],
            'store_product_reviews_merchant_id' => ['required'],
        ];
    }

    public function setStoreProductReviewsConfiguration(
        StoreProductReviewsConfiguration $storeProductReviewsConfiguration
    ) {
        $this->storeProductReviewsConfiguration = $storeProductReviewsConfiguration;

        $this->config_name = $storeProductReviewsConfiguration->config_name;
        $this->config_value = $storeProductReviewsConfiguration->config_value;
        $this->store_product_reviews_merchant_id =
            $storeProductReviewsConfiguration->store_product_reviews_merchant_id;
    }

    public function save()
    {
        $this->validate();

        $this->storeProductReviewsConfiguration->update(
            $this->except([
                'storeProductReviewsConfiguration',
                'store_product_reviews_merchant_id',
            ])
        );
    }
}
