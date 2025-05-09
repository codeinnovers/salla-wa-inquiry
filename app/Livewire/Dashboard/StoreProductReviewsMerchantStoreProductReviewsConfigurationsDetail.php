<?php

namespace App\Livewire\Dashboard;

use Livewire\Form;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\StoreProductReviewsMerchant;
use App\Models\StoreProductReviewsConfiguration;
use App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms\CreateDetailForm;
use App\Livewire\Dashboard\StoreProductReviewsConfigurations\Forms\UpdateDetailForm;

class StoreProductReviewsMerchantStoreProductReviewsConfigurationsDetail extends
    Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?StoreProductReviewsConfiguration $storeProductReviewsConfiguration;
    public StoreProductReviewsMerchant $storeProductReviewsMerchant;

    public $showingModal = false;

    public $detailStoreProductReviewsConfigurationsSearch = '';
    public $detailStoreProductReviewsConfigurationsSortField = 'updated_at';
    public $detailStoreProductReviewsConfigurationsSortDirection = 'desc';

    public $queryString = [
        'detailStoreProductReviewsConfigurationsSearch',
        'detailStoreProductReviewsConfigurationsSortField',
        'detailStoreProductReviewsConfigurationsSortDirection',
    ];

    public $confirmingStoreProductReviewsConfigurationDeletion = false;
    public string $deletingStoreProductReviewsConfiguration;

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');
    }

    public function newStoreProductReviewsConfiguration()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->storeProductReviewsConfiguration = null;

        $this->showModal();
    }

    public function editStoreProductReviewsConfiguration(
        StoreProductReviewsConfiguration $storeProductReviewsConfiguration
    ) {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setStoreProductReviewsConfiguration(
            $storeProductReviewsConfiguration
        );
        $this->storeProductReviewsConfiguration = $storeProductReviewsConfiguration;

        $this->showModal();
    }

    public function showModal()
    {
        $this->showingModal = true;
    }

    public function closeModal()
    {
        $this->showingModal = false;
    }

    public function confirmStoreProductReviewsConfigurationDeletion(string $id)
    {
        $this->deletingStoreProductReviewsConfiguration = $id;

        $this->confirmingStoreProductReviewsConfigurationDeletion = true;
    }

    public function deleteStoreProductReviewsConfiguration(
        StoreProductReviewsConfiguration $storeProductReviewsConfiguration
    ) {
        $this->authorize('delete', $storeProductReviewsConfiguration);

        $storeProductReviewsConfiguration->delete();

        $this->confirmingStoreProductReviewsConfigurationDeletion = false;
    }

    public function save()
    {
        if (empty($this->storeProductReviewsConfiguration)) {
            $this->authorize('create', StoreProductReviewsConfiguration::class);
        } else {
            $this->authorize('update', $this->storeProductReviewsConfiguration);
        }

        $this->form->store_product_reviews_merchant_id =
            $this->storeProductReviewsMerchant->id;
        $this->form->save();

        $this->closeModal();
    }

    public function sortBy($field)
    {
        if (
            $this->detailStoreProductReviewsConfigurationsSortField === $field
        ) {
            $this->detailStoreProductReviewsConfigurationsSortDirection =
                $this->detailStoreProductReviewsConfigurationsSortDirection ===
                'asc'
                    ? 'desc'
                    : 'asc';
        } else {
            $this->detailStoreProductReviewsConfigurationsSortDirection = 'asc';
        }

        $this->detailStoreProductReviewsConfigurationsSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return $this->storeProductReviewsMerchant
            ->storeProductReviewsConfigurations()
            ->orderBy(
                $this->detailStoreProductReviewsConfigurationsSortField,
                $this->detailStoreProductReviewsConfigurationsSortDirection
            )
            ->where(
                'config_name',
                'like',
                "%{$this->detailStoreProductReviewsConfigurationsSearch}%"
            );
    }

    public function render()
    {
        return view(
            'livewire.dashboard.store-product-reviews-merchants.store-product-reviews-configurations-detail',
            [
                'detailStoreProductReviewsConfigurations' => $this->rows,
            ]
        );
    }
}
