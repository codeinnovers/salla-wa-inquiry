<?php

namespace App\Livewire\Dashboard\Merchants\Forms;

use Livewire\Form;
use App\Models\Merchant;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('nullable|string')]
    public $merchant_identifier = '';

    #[Rule('nullable|string')]
    public $name = '';

    #[Rule('nullable|string')]
    public $email = '';

    #[Rule('nullable|string')]
    public $store_link = '';

    #[Rule('nullable|string')]
    public $store_reference = '';

    #[Rule('nullable')]
    public $access_token = '';

    #[Rule('nullable')]
    public $refresh_token = '';

    #[Rule('nullable|date')]
    public $token_exp = '';

    public function save()
    {
        $this->validate();

        $merchant = Merchant::create($this->except([]));

        $this->reset();

        return $merchant;
    }
}
