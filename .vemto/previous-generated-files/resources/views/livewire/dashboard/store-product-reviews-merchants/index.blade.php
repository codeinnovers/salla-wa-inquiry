<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >{{ __('crud.storeProductReviewsMerchants.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="Search {{ __('crud.storeProductReviewsMerchants.collectionTitle') }}..."
        />

        @can('create', App\Models\StoreProductReviewsMerchant::class)
        <a
            wire:navigate
            href="{{ route('dashboard.store-product-reviews-merchants.create') }}"
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
                wire:click="delete({{ $deletingStoreProductReviewsMerchant }})"
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
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.merchant_identifier.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('name')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.name.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('email')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.email.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('store_link')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.store_link.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-crud
                    wire:click="sortBy('store_reference')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.store_reference.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('access_token')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.access_token.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('refresh_token')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.refresh_token.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('token_exp')"
                    >{{
                    __('crud.storeProductReviewsMerchants.inputs.token_exp.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($storeProductReviewsMerchants as
                $storeProductReviewsMerchant)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->merchant_identifier
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->name
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->email
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->store_link
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->store_reference
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->access_token
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->refresh_token
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $storeProductReviewsMerchant->token_exp
                        }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $storeProductReviewsMerchant)
                        <x-ui.action
                            wire:navigate
                            href="{{ route('dashboard.store-product-reviews-merchants.edit', $storeProductReviewsMerchant) }}"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $storeProductReviewsMerchant)
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $storeProductReviewsMerchant->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="9"
                        >No {{ __('crud.storeProductReviewsMerchants.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $storeProductReviewsMerchants->links() }}</div>
    </x-ui.container.table>
</div>
