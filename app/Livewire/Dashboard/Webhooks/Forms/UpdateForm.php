<?php

namespace App\Livewire\Dashboard\Webhooks\Forms;

use Livewire\Form;
use App\Models\Webhook;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Webhook $webhook;

    public $event = '';

    public $reference_number = '';

    public $status = '';

    public $payload = '';

    public $merchant = '';

    public function rules(): array
    {
        return [
            'event' => ['required', 'string'],
            'reference_number' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'payload' => ['nullable'],
            'merchant' => ['required', 'string'],
        ];
    }

    public function setWebhook(Webhook $webhook)
    {
        $this->webhook = $webhook;

        $this->event = $webhook->event;
        $this->reference_number = $webhook->reference_number;
        $this->status = $webhook->status;
        $this->payload = $webhook->payload;
        $this->merchant = $webhook->merchant;
    }

    public function save()
    {
        $this->validate();

        $this->webhook->update($this->except(['webhook']));
    }
}
