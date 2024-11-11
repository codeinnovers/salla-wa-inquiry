<?php

namespace App\Livewire\Dashboard\Webhooks\Forms;

use Livewire\Form;
use App\Models\Webhook;
use Livewire\Attributes\Rule;

class CreateDetailForm extends Form
{
    public $merchant_id = null;

    #[Rule('required|string')]
    public $event = '';

    #[Rule('nullable|string')]
    public $reference_number = '';

    #[Rule('nullable|string')]
    public $status = '';

    #[Rule('nullable')]
    public $payload = '';

    public function save()
    {
        $this->validate();

        $webhook = Webhook::create($this->except([]));

        $this->reset();

        return $webhook;
    }
}
