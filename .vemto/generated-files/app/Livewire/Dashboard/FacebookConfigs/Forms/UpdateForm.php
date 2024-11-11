<?php

namespace App\Livewire\Dashboard\FacebookConfigs\Forms;

use Livewire\Form;
use App\Models\FacebookConfig;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?FacebookConfig $facebookConfig;

    public $merchant_identifier = '';

    public $config_name = '';

    public $config_value = '';

    public $merchant_id = '';

    public function rules(): array
    {
        return [
            'merchant_identifier' => ['nullable', 'string'],
            'config_name' => ['nullable', 'string'],
            'config_value' => ['nullable', 'string'],
            'merchant_id' => ['required'],
        ];
    }

    public function setFacebookConfig(FacebookConfig $facebookConfig)
    {
        $this->facebookConfig = $facebookConfig;

        $this->merchant_identifier = $facebookConfig->merchant_identifier;
        $this->config_name = $facebookConfig->config_name;
        $this->config_value = $facebookConfig->config_value;
        $this->merchant_id = $facebookConfig->merchant_id;
    }

    public function save()
    {
        $this->validate();

        $this->facebookConfig->update(
            $this->except(['facebookConfig', 'merchant_id'])
        );
    }
}
