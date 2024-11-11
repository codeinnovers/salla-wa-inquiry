<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FacebookConfig;

class FacebookConfigIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingFacebookConfig;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingFacebookConfig = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(FacebookConfig $facebookConfig)
    {
        $facebookConfig->delete();

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
        return FacebookConfig::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('merchant_identifier', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view('livewire.dashboard.facebook-configs.index', [
            'facebookConfigs' => $this->rows,
        ]);
    }
}
