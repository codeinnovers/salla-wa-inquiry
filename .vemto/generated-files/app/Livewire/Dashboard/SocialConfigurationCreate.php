<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Merchant;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\SocialConfigurations\Forms\CreateForm;

class SocialConfigurationCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;
    public Collection $merchants;

    public function mount()
    {
        $this->merchants = Merchant::pluck('name', 'id');
    }

    public function save()
    {
        $this->authorize('create', SocialConfiguration::class);

        $this->validate();

        $socialConfiguration = $this->form->save();

        return redirect()->route(
            'dashboard.social-configurations.edit',
            $socialConfiguration
        );
    }

    public function render()
    {
        return view('livewire.dashboard.social-configurations.create', []);
    }
}
