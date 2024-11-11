<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SocialConfiguration;

class SocialConfigurationIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingSocialConfiguration;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingSocialConfiguration = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(SocialConfiguration $socialConfiguration)
    {
        $socialConfiguration->delete();

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
        return SocialConfiguration::query()->with('merchant');

    }

    public function render()
    {
        return view('livewire.dashboard.social-configurations.index', [
            'socialConfigurations' => $this->rows,
        ]);
    }
}
