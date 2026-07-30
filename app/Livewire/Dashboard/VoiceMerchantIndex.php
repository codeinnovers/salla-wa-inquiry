<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VoiceMerchant;

class VoiceMerchantIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingVoiceMerchant;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingVoiceMerchant = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(VoiceMerchant $voiceMerchant)
    {
        $voiceMerchant->delete();

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
        return VoiceMerchant::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('merchant_identifier', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('store_reference', 'like', "%{$this->search}%")
                      ->orWhere('plan', 'like', "%{$this->search}%");
            });
    }

    public function render()
    {
        return view('livewire.dashboard.voice-merchants.index', [
            'voiceMerchants' => $this->rows,
        ]);
    }
}
