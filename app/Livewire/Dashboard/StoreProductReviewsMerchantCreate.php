<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\StoreProductReviewsMerchants\Forms\CreateForm;

class StoreProductReviewsMerchantCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', StoreProductReviewsMerchant::class);

        $this->validate();

        $storeProductReviewsMerchant = $this->form->save();

        return redirect()->route(
            'dashboard.store-product-reviews-merchants.edit',
            $storeProductReviewsMerchant
        );
    }

    public function render()
    {
        return view(
            'livewire.dashboard.store-product-reviews-merchants.create',
            []
        );
    }
}
