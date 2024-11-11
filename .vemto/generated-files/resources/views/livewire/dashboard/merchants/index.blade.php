<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >{{ __('crud.merchants.collectionTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="Search {{ __('crud.merchants.collectionTitle') }}..."
        />

        @can('create', App\Models\Merchant::class)
        <a wire:navigate href="{{ route('dashboard.merchants.create') }}">
            <x-ui.button>New</x-ui.button>
        </a>
        @endcan
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="delete({{ $deletingMerchant }})"
                wire:loading.attr="disabled"
            >
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Index Table --}}
    <x-ui.container.table>
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header
                    for-crud
                    wire:click="sortBy('merchant_identifier')"
                    >{{ __('crud.merchants.inputs.merchant_identifier.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('name')"
                    >{{ __('crud.merchants.inputs.name.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('email')"
                    >{{ __('crud.merchants.inputs.email.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('store_link')"
                    >{{ __('crud.merchants.inputs.store_link.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-crud
                    wire:click="sortBy('store_reference')"
                    >{{ __('crud.merchants.inputs.store_reference.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('access_token')"
                    >{{ __('crud.merchants.inputs.access_token.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('refresh_token')"
                    >{{ __('crud.merchants.inputs.refresh_token.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('token_exp')"
                    >{{ __('crud.merchants.inputs.token_exp.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($merchants as $merchant)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $merchant->merchant_identifier }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->name }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->email }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->store_link }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->store_reference }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->access_token }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->refresh_token }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $merchant->token_exp }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $merchant)
                        <x-ui.action
                            wire:navigate
                            href="{{ route('dashboard.merchants.edit', $merchant) }}"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $merchant)
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $merchant->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="9"
                        >No {{ __('crud.merchants.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $merchants->links() }}</div>
    </x-ui.container.table>
</div>
