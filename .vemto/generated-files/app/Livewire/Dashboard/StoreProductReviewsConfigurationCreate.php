<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Models\StoreProductReviewsMerchant;
use App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms\CreateForm;

class StoreProductReviewsConfigurationCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;
    public Collection $storeProductReviewsMerchants;

    public function mount()
    {
        $this->storeProductReviewsMerchants = StoreProductReviewsMerchant::pluck(
            'name',
            'id'
        );
    }

    public function save()
    {
        $this->authorize('create', StoreProductReviewsConfiguration::class);

        $this->validate();

        $storeProductReviewsConfiguration = $this->form->save();

        return redirect()->route(
            'dashboard.store-product-reviews-configurations.edit',
            $storeProductReviewsConfiguration
        );
    }

    public function render()
    {
        return view(
            'livewire.dashboard.store-product-reviews-configurations.create',
            []
        );
    }
}
