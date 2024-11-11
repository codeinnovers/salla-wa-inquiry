<?php

namespace App\Livewire\Dashboard\SocialConfigurations\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\SocialConfiguration;

class CreateForm extends Form
{
    #[Rule('nullable|string')]
    public $config_name = '';

    #[Rule('nullable|string')]
    public $config_value = '';

    #[Rule('required')]
    public $merchant_id = '';

    public function save()
    {
        $this->validate();

        $socialConfiguration = SocialConfiguration::create($this->except([]));

        $this->reset();

        return $socialConfiguration;
    }
}
