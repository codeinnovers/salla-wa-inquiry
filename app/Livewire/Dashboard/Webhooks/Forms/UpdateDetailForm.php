<?php

namespace App\Livewire\Dashboard\Webhooks\Forms;

use Livewire\Form;
use App\Models\Webhook;
use Livewire\Attributes\Rule;

class UpdateDetailForm extends Form
{
    public ?Webhook $webhook;

    public $event = '';

    public $reference_number = '';

    public $status = '';

    public $payload = '';

    public function rules(): array
    {
        return [
            'event' => ['required', 'string'],
            'reference_number' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'payload' => ['nullable'],
        ];
    }

    public function setWebhook(Webhook $webhook)
    {
        $this->webhook = $webhook;

        $this->event = $webhook->event;
        $this->reference_number = $webhook->reference_number;
        $this->status = $webhook->status;
        $this->payload = $webhook->payload;
    }

    public function save()
    {
        $this->validate();

        $this->webhook->update($this->except(['webhook']));
    }
}
