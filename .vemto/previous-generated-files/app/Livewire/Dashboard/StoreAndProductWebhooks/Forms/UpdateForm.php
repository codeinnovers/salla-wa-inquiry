<?php

namespace App\Livewire\Dashboard\StoreAndProductWebhooks\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use App\Models\StoreAndProductWebhook;

class UpdateForm extends Form
{
    public ?StoreAndProductWebhook $storeAndProductWebhook;

    public $event = '';

    public $reference_number = '';

    public $merchant = '';

    public $payload = '';

    public function rules(): array
    {
        return [
            'event' => ['nullable', 'string'],
            'reference_number' => ['nullable', 'string'],
            'merchant' => ['required', 'string'],
            'payload' => ['required'],
        ];
    }

    public function setStoreAndProductWebhook(
        StoreAndProductWebhook $storeAndProductWebhook
    ) {
        $this->storeAndProductWebhook = $storeAndProductWebhook;

        $this->event = $storeAndProductWebhook->event;
        $this->reference_number = $storeAndProductWebhook->reference_number;
        $this->merchant = $storeAndProductWebhook->merchant;
        $this->payload = $storeAndProductWebhook->payload;
    }

    public function save()
    {
        $this->validate();

        $this->storeAndProductWebhook->update(
            $this->except(['storeAndProductWebhook'])
        );
    }
}
