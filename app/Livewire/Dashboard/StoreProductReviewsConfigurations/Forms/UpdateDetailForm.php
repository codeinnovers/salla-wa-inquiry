<?php

namespace App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\StoreProductReviewsConfiguration;

class UpdateDetailForm extends Form
{
    public ?StoreProductReviewsConfiguration $storeProductReviewsConfiguration;

    public $config_name = '';

    public $config_value = '';

    public function rules(): array
    {
        return [
            'config_name' => ['nullable', 'string'],
            'config_value' => ['nullable', 'string'],
        ];
    }

    public function setStoreProductReviewsConfiguration(
        StoreProductReviewsConfiguration $storeProductReviewsConfiguration
    ) {
        $this->storeProductReviewsConfiguration = $storeProductReviewsConfiguration;

        $this->config_name = $storeProductReviewsConfiguration->config_name;
        $this->config_value = $storeProductReviewsConfiguration->config_value;
    }

    public function save()
    {
        $this->validate();

        $this->storeProductReviewsConfiguration->update(
            $this->except(['storeProductReviewsConfiguration'])
        );
    }
}
