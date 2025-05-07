<?php

namespace App\Livewire\Dashboard\StoreAndProductWebhooks\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\StoreAndProductWebhook;

class CreateForm extends Form
{
    #[Rule('nullable|string')]
    public $event = '';

    #[Rule('nullable|string')]
    public $reference_number = '';

    #[Rule('required|string')]
    public $merchant = '';

    #[Rule('required')]
    public $payload = '';

    public function save()
    {
        $this->validate();

        $storeAndProductWebhook = StoreAndProductWebhook::create(
            $this->except([])
        );

        $this->reset();

        return $storeAndProductWebhook;
    }
}
