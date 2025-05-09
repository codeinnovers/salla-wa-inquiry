<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StoreProductReviewsConfiguration;

class StoreProductReviewsConfigurationIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingStoreProductReviewsConfiguration;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingStoreProductReviewsConfiguration = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(
        StoreProductReviewsConfiguration $storeProductReviewsConfiguration
    ) {
        $storeProductReviewsConfiguration->delete();

        $this->confirmingDeletion = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection =
                $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return StoreProductReviewsConfiguration::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('config_name', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view(
            'livewire.dashboard.store-product-reviews-configurations.index',
            [
                'storeProductReviewsConfigurations' => $this->rows,
            ]
        );
    }
}
