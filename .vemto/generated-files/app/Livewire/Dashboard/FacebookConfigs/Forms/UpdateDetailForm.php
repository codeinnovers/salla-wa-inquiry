<?php

namespace App\Livewire\Dashboard\FacebookConfigs\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\FacebookConfig;

class UpdateDetailForm extends Form
{
    public ?FacebookConfig $facebookConfig;

    public $merchant_identifier = '';

    public $config_name = '';

    public $config_value = '';

    public function rules(): array
    {
        return [
            'merchant_identifier' => ['nullable', 'string'],
            'config_name' => ['nullable', 'string'],
            'config_value' => ['nullable', 'string'],
        ];
    }

    public function setFacebookConfig(FacebookConfig $facebookConfig)
    {
        $this->facebookConfig = $facebookConfig;

        $this->merchant_identifier = $facebookConfig->merchant_identifier;
        $this->config_name = $facebookConfig->config_name;
        $this->config_value = $facebookConfig->config_value;
    }

    public function save()
    {
        $this->validate();

        $this->facebookConfig->update($this->except(['facebookConfig']));
    }
}
