<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\StoreAndProductWebhooks\Forms\CreateForm;

class StoreAndProductWebhookCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', StoreAndProductWebhook::class);

        $this->validate();

        $storeAndProductWebhook = $this->form->save();

        return redirect()->route(
            'dashboard.store-and-product-webhooks.edit',
            $storeAndProductWebhook
        );
    }

    public function render()
    {
        return view('livewire.dashboard.store-and-product-webhooks.create', []);
    }
}
