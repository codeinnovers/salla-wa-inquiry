<?php

namespace App\Livewire\Dashboard;

use Livewire\Form;
use Livewire\Component;
use App\Models\Webhook;
use App\Models\Merchant;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Dashboard\Webhooks\Forms\CreateDetailForm;
use App\Livewire\Dashboard\Webhooks\Forms\UpdateDetailForm;

class MerchantWebhooksDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?Webhook $webhook;
    public Merchant $merchant;

    public $showingModal = false;

    public $detailWebhooksSearch = '';
    public $detailWebhooksSortField = 'updated_at';
    public $detailWebhooksSortDirection = 'desc';

    public $queryString = [
        'detailWebhooksSearch',
        'detailWebhooksSortField',
        'detailWebhooksSortDirection',
    ];

    public $confirmingWebhookDeletion = false;
    public string $deletingWebhook;

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');
    }

    public function newWebhook()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->webhook = null;

        $this->showModal();
    }

    public function editWebhook(Webhook $webhook)
    {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setWebhook($webhook);
        $this->webhook = $webhook;

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

    public function confirmWebhookDeletion(string $id)
    {
        $this->deletingWebhook = $id;

        $this->confirmingWebhookDeletion = true;
    }

    public function deleteWebhook(Webhook $webhook)
    {
        $this->authorize('delete', $webhook);

        $webhook->delete();

        $this->confirmingWebhookDeletion = false;
    }

    public function save()
    {
        if (empty($this->webhook)) {
            $this->authorize('create', Webhook::class);
        } else {
            $this->authorize('update', $this->webhook);
        }

        $this->form->merchant_id = $this->merchant->id;
        $this->form->save();

        $this->closeModal();
    }

    public function sortBy($field)
    {
        if ($this->detailWebhooksSortField === $field) {
            $this->detailWebhooksSortDirection =
                $this->detailWebhooksSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->detailWebhooksSortDirection = 'asc';
        }

        $this->detailWebhooksSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return $this->merchant
            ->webhooks()
            ->orderBy(
                $this->detailWebhooksSortField,
                $this->detailWebhooksSortDirection
            )
            ->where('event', 'like', "%{$this->detailWebhooksSearch}%");
    }

    public function render()
    {
        return view('livewire.dashboard.merchants.webhooks-detail', [
            'detailWebhooks' => $this->rows,
        ]);
    }
}
