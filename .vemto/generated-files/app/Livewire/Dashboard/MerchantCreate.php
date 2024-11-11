<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Merchants\Forms\CreateForm;

class MerchantCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', Merchant::class);

        $this->validate();

        $merchant = $this->form->save();

        return redirect()->route('dashboard.merchants.edit', $merchant);
    }

    public function render()
    {
        return view('livewire.dashboard.merchants.create', []);
    }
}
