<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Webhook;
use Livewire\WithPagination;

class WebhookIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingWebhook;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingWebhook = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Webhook $webhook)
    {
        $webhook->delete();

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
        return Webhook::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('event', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view('livewire.dashboard.webhooks.index', [
            'webhooks' => $this->rows,
        ]);
    }
}
