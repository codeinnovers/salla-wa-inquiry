<?php

namespace App\Livewire\Dashboard;

use Livewire\Form;
use Livewire\Component;
use App\Models\Merchant;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\FacebookConfig;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Dashboard\FacebookConfigs\Forms\CreateDetailForm;
use App\Livewire\Dashboard\FacebookConfigs\Forms\UpdateDetailForm;

class MerchantFacebookConfigsDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?FacebookConfig $facebookConfig;
    public Merchant $merchant;

    public $showingModal = false;

    public $detailFacebookConfigsSearch = '';
    public $detailFacebookConfigsSortField = 'updated_at';
    public $detailFacebookConfigsSortDirection = 'desc';

    public $queryString = [
        'detailFacebookConfigsSearch',
        'detailFacebookConfigsSortField',
        'detailFacebookConfigsSortDirection',
    ];

    public $confirmingFacebookConfigDeletion = false;
    public string $deletingFacebookConfig;

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');
    }

    public function newFacebookConfig()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->facebookConfig = null;

        $this->showModal();
    }

    public function editFacebookConfig(FacebookConfig $facebookConfig)
    {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setFacebookConfig($facebookConfig);
        $this->facebookConfig = $facebookConfig;

        $this->showModal();
    }

    public function showModal()
    {
        $this->showingModal = true;
    }

    public function closeModal()
    {
        $this->showingModal = false;
    }

    public function confirmFacebookConfigDeletion(string $id)
    {
        $this->deletingFacebookConfig = $id;

        $this->confirmingFacebookConfigDeletion = true;
    }

    public function deleteFacebookConfig(FacebookConfig $facebookConfig)
    {
        $this->authorize('delete', $facebookConfig);

        $facebookConfig->delete();

        $this->confirmingFacebookConfigDeletion = false;
    }

    public function save()
    {
        if (empty($this->facebookConfig)) {
            $this->authorize('create', FacebookConfig::class);
        } else {
            $this->authorize('update', $this->facebookConfig);
        }

        $this->form->merchant_id = $this->merchant->id;
        $this->form->save();

        $this->closeModal();
    }

    public function sortBy($field)
    {
        if ($this->detailFacebookConfigsSortField === $field) {
            $this->detailFacebookConfigsSortDirection =
                $this->detailFacebookConfigsSortDirection === 'asc'
                    ? 'desc'
                    : 'asc';
        } else {
            $this->detailFacebookConfigsSortDirection = 'asc';
        }

        $this->detailFacebookConfigsSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return $this->merchant
            ->facebookConfigs()
            ->orderBy(
                $this->detailFacebookConfigsSortField,
                $this->detailFacebookConfigsSortDirection
            )
            ->where(
                'merchant_identifier',
                'like',
                "%{$this->detailFacebookConfigsSearch}%"
            );
    }

    public function render()
    {
        return view('livewire.dashboard.merchants.facebook-configs-detail', [
            'detailFacebookConfigs' => $this->rows,
        ]);
    }
}
