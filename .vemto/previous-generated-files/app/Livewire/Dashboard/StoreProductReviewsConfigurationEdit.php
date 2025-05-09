<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\StoreProductReviewsMerchant;
use App\Models\StoreProductReviewsConfiguration;
use App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms\UpdateForm;

class StoreProductReviewsConfigurationEdit extends Component
{
    public ?StoreProductReviewsConfiguration $storeProductReviewsConfiguration = null;

    public UpdateForm $form;
    public Collection $storeProductReviewsMerchants;

    public function mount(
        StoreProductReviewsConfiguration $storeProductReviewsConfiguration
    ) {
        $this->authorize('view-any', StoreProductReviewsConfiguration::class);

        $this->storeProductReviewsConfiguration = $storeProductReviewsConfiguration;

        $this->form->setStoreProductReviewsConfiguration(
            $storeProductReviewsConfiguration
        );
        $this->storeProductReviewsMerchants = StoreProductReviewsMerchant::pluck(
            'name',
            'id'
        );
    }

    public function save()
    {
        $this->authorize('update', $this->storeProductReviewsConfiguration);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view(
            'livewire.dashboard.store-product-reviews-configurations.edit',
            []
        );
    }
}
