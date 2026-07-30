<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VoicePlanConfiguration;

class VoicePlanConfigurationIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingVoicePlanConfiguration;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(int $id)
    {
        $this->deletingVoicePlanConfiguration = $id;
        $this->confirmingDeletion = true;
    }

    public function delete(VoicePlanConfiguration $voicePlanConfiguration)
    {
        $this->authorize('delete', $voicePlanConfiguration);
        $voicePlanConfiguration->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Plan configuration deleted successfully.');
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
        return $this->rowsQuery->paginate(10);
    }

    public function getRowsQueryProperty()
    {
        return VoicePlanConfiguration::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('slug', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
            });
    }

    public function render()
    {
        return view('livewire.dashboard.voice-plan-configurations.index', [
            'planConfigurations' => $this->rows,
        ]);
    }
}
