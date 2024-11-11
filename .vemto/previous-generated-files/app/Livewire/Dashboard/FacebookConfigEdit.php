<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Merchant;
use App\Models\FacebookConfig;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\FacebookConfigs\Forms\UpdateForm;

class FacebookConfigEdit extends Component
{
    public ?FacebookConfig $facebookConfig = null;

    public UpdateForm $form;
    public Collection $merchants;

    public function mount(FacebookConfig $facebookConfig)
    {
        $this->authorize('view-any', FacebookConfig::class);

        $this->facebookConfig = $facebookConfig;

        $this->form->setFacebookConfig($facebookConfig);
        $this->merchants = Merchant::pluck('name', 'id');
    }

    public function save()
    {
        $this->authorize('update', $this->facebookConfig);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.facebook-configs.edit', []);
    }
}
