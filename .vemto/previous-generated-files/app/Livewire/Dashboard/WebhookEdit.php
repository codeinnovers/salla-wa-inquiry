<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Webhook;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Webhooks\Forms\UpdateForm;

class WebhookEdit extends Component
{
    public ?Webhook $webhook = null;

    public UpdateForm $form;

    public function mount(Webhook $webhook)
    {
        $this->authorize('view-any', Webhook::class);

        $this->webhook = $webhook;

        $this->form->setWebhook($webhook);
    }

    public function save()
    {
        $this->authorize('update', $this->webhook);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.webhooks.edit', []);
    }
}
