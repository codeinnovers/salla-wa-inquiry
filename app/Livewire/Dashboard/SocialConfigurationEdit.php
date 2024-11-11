<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Merchant;
use Illuminate\Support\Collection;
use App\Models\SocialConfiguration;
use App\Livewire\Dashboard\SocialConfigurations\Forms\UpdateForm;

class SocialConfigurationEdit extends Component
{
    public ?SocialConfiguration $socialConfiguration = null;

    public UpdateForm $form;
    public Collection $merchants;

    public function mount(SocialConfiguration $socialConfiguration)
    {
        $this->authorize('view-any', SocialConfiguration::class);

        $this->socialConfiguration = $socialConfiguration;

        $this->form->setSocialConfiguration($socialConfiguration);
        $this->merchants = Merchant::pluck('name', 'id');
    }

    public function save()
    {
        $this->authorize('update', $this->socialConfiguration);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.social-configurations.edit', []);
    }
}
