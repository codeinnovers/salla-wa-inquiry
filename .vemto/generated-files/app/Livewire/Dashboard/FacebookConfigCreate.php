<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Merchant;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\FacebookConfigs\Forms\CreateForm;

class FacebookConfigCreate extends Component
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
        $this->authorize('create', FacebookConfig::class);

        $this->validate();

        $facebookConfig = $this->form->save();

        return redirect()->route(
            'dashboard.facebook-configs.edit',
            $facebookConfig
        );
    }

    public function render()
    {
        return view('livewire.dashboard.facebook-configs.create', []);
    }
}
