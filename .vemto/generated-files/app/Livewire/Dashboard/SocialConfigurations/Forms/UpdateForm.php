<?php

namespace App\Livewire\Dashboard\SocialConfigurations\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use App\Models\SocialConfiguration;

class UpdateForm extends Form
{
    public ?SocialConfiguration $socialConfiguration;

    public $config_name = '';

    public $config_value = '';

    public $merchant_id = '';

    public function rules(): array
    {
        return [
            'config_name' => ['nullable', 'string'],
            'config_value' => ['nullable', 'string'],
            'merchant_id' => ['required'],
        ];
    }

    public function setSocialConfiguration(
        SocialConfiguration $socialConfiguration
    ) {
        $this->socialConfiguration = $socialConfiguration;

        $this->config_name = $socialConfiguration->config_name;
        $this->config_value = $socialConfiguration->config_value;
        $this->merchant_id = $socialConfiguration->merchant_id;
    }

    public function save()
    {
        $this->validate();

        $this->socialConfiguration->update(
            $this->except(['socialConfiguration', 'merchant_id'])
        );
    }
}
