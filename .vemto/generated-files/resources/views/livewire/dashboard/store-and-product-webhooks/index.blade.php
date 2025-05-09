<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >{{ __('crud.storeAndProductWebhooks.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="Search {{ __('crud.storeAndProductWebhooks.collectionTitle') }}..."
        />

        @can('create', App\Models\StoreAndProductWebhook::class)
        <a
            wire:navigate
            href="{{ route('dashboard.store-and-product-webhooks.create') }}"
        >
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
                wire:click="delete({{ $deletingStoreAndProductWebhook }})"
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
                <x-ui.table.header for-crud wire:click="sortBy('event')"
                    >{{ __('crud.storeAndProductWebhooks.inputs.event.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-crud
                    wire:click="sortBy('reference_number')"
                    >{{
                    __('crud.storeAndProductWebhooks.inputs.reference_number.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('merchant')"
                    >{{ __('crud.storeAndProductWebhooks.inputs.merchant.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('payload')"
                    >{{ __('crud.storeAndProductWebhooks.inputs.payload.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($storeAndProductWebhooks as $storeAndProductWebhook)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $storeAndProductWebhook->event }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeAndProductWebhook->reference_number
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeAndProductWebhook->merchant
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeAndProductWebhook->payload
                        }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $storeAndProductWebhook)
                        <x-ui.action
                            wire:navigate
                            href="{{ route('dashboard.store-and-product-webhooks.edit', $storeAndProductWebhook) }}"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $storeAndProductWebhook)
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $storeAndProductWebhook->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="5"
                        >No {{ __('crud.storeAndProductWebhooks.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $storeAndProductWebhooks->links() }}</div>
    </x-ui.container.table>
</div>
