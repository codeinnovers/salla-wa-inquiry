<?php

namespace App\Livewire\Dashboard\FacebookConfigs\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\FacebookConfig;

class CreateForm extends Form
{
    #[Rule('nullable|string')]
    public $merchant_identifier = '';

    #[Rule('nullable|string')]
    public $config_name = '';

    #[Rule('nullable|string')]
    public $config_value = '';

    #[Rule('required')]
    public $merchant_id = '';

    public function save()
    {
        $this->validate();

        $facebookConfig = FacebookConfig::create($this->except([]));

        $this->reset();

        return $facebookConfig;
    }
}
