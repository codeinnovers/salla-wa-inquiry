<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VoiceWebhook;

class VoiceWebhookIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingVoiceWebhook;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingVoiceWebhook = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(VoiceWebhook $voiceWebhook)
    {
        $voiceWebhook->delete();

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
        return VoiceWebhook::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where(function ($query) {
                $query->where('event', 'like', "%{$this->search}%")
                      ->orWhere('merchant', 'like', "%{$this->search}%");
            });
    }

    public function render()
    {
        return view('livewire.dashboard.voice-webhooks.index', [
            'voiceWebhooks' => $this->rows,
        ]);
    }
}
