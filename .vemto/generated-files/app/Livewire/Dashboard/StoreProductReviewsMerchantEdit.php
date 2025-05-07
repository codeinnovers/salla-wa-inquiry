<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\StoreProductReviewsMerchant;
use App\Livewire\Dashboard\StoreProductReviewsMerchants\Forms\UpdateForm;

class StoreProductReviewsMerchantEdit extends Component
{
    public ?StoreProductReviewsMerchant $storeProductReviewsMerchant = null;

    public UpdateForm $form;

    public function mount(
        StoreProductReviewsMerchant $storeProductReviewsMerchant
    ) {
        $this->authorize('view-any', StoreProductReviewsMerchant::class);

        $this->storeProductReviewsMerchant = $storeProductReviewsMerchant;

        $this->form->setStoreProductReviewsMerchant(
            $storeProductReviewsMerchant
        );
    }

    public function save()
    {
        $this->authorize('update', $this->storeProductReviewsMerchant);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view(
            'livewire.dashboard.store-product-reviews-merchants.edit',
            []
        );
    }
}
