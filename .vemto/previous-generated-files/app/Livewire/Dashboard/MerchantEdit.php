<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Merchant;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Merchants\Forms\UpdateForm;

class MerchantEdit extends Component
{
    public ?Merchant $merchant = null;

    public UpdateForm $form;

    public function mount(Merchant $merchant)
    {
        $this->authorize('view-any', Merchant::class);

        $this->merchant = $merchant;

        $this->form->setMerchant($merchant);
    }

    public function save()
    {
        $this->authorize('update', $this->merchant);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.merchants.edit', []);
    }
}
