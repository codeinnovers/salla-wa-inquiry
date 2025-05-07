<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\StoreAndProductWebhook;
use App\Livewire\Dashboard\StoreAndProductWebhooks\Forms\UpdateForm;

class StoreAndProductWebhookEdit extends Component
{
    public ?StoreAndProductWebhook $storeAndProductWebhook = null;

    public UpdateForm $form;

    public function mount(StoreAndProductWebhook $storeAndProductWebhook)
    {
        $this->authorize('view-any', StoreAndProductWebhook::class);

        $this->storeAndProductWebhook = $storeAndProductWebhook;

        $this->form->setStoreAndProductWebhook($storeAndProductWebhook);
    }

    public function save()
    {
        $this->authorize('update', $this->storeAndProductWebhook);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.store-and-product-webhooks.edit', []);
    }
}
