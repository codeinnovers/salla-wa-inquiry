<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Webhooks\Forms\CreateForm;

class WebhookCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', Webhook::class);

        $this->validate();

        $webhook = $this->form->save();

        return redirect()->route('dashboard.webhooks.edit', $webhook);
    }

    public function render()
    {
        return view('livewire.dashboard.webhooks.create', []);
    }
}
