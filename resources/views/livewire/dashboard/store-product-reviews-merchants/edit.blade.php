<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link
            href="{{ route('dashboard.store-product-reviews-merchants.index') }}"
            >{{ __('crud.storeProductReviewsMerchants.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Edit {{ __('crud.storeProductReviewsMerchants.itemTitle')
            }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <x-ui.toast on="saved">
        StoreProductReviewsMerchant saved successfully.
    </x-ui.toast>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Edit {{ __('crud.storeProductReviewsMerchants.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="merchant_identifier"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.merchant_identifier.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.merchant_identifier"
                        name="merchant_identifier"
                        id="merchant_identifier"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.merchant_identifier.placeholder') }}"
                    />
                    <x-ui.input.error for="form.merchant_identifier" />
                </div>

                <div class="w-full">
                    <x-ui.label for="name"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.name.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.name"
                        name="name"
                        id="name"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.name.placeholder') }}"
                    />
                    <x-ui.input.error for="form.name" />
                </div>

                <div class="w-full">
                    <x-ui.label for="email"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.email.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.email
                        class="w-full"
                        wire:model="form.email"
                        name="email"
                        id="email"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.email.placeholder') }}"
                    />
                    <x-ui.input.error for="form.email" />
                </div>

                <div class="w-full">
                    <x-ui.label for="store_link"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.store_link.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.store_link"
                        name="store_link"
                        id="store_link"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.store_link.placeholder') }}"
                    />
                    <x-ui.input.error for="form.store_link" />
                </div>

                <div class="w-full">
                    <x-ui.label for="store_reference"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.store_reference.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.store_reference"
                        name="store_reference"
                        id="store_reference"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.store_reference.placeholder') }}"
                    />
                    <x-ui.input.error for="form.store_reference" />
                </div>

                <div class="w-full">
                    <x-ui.label for="access_token"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.access_token.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.access_token"
                        rows="6"
                        name="access_token"
                        id="access_token"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.access_token.placeholder') }}"
                    />
                    <x-ui.input.error for="form.access_token" />
                </div>

                <div class="w-full">
                    <x-ui.label for="refresh_token"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.refresh_token.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.refresh_token"
                        rows="6"
                        name="refresh_token"
                        id="refresh_token"
                        placeholder="{{ __('crud.storeProductReviewsMerchants.inputs.refresh_token.placeholder') }}"
                    />
                    <x-ui.input.error for="form.refresh_token" />
                </div>

                <div class="w-full">
                    <x-ui.label for="token_exp"
                        >{{
                        __('crud.storeProductReviewsMerchants.inputs.token_exp.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.date
                        class="w-full"
                        wire:model="form.token_exp"
                        name="token_exp"
                        id="token_exp"
                    />
                    <x-ui.input.error for="form.token_exp" />
                </div>
            </div>

            <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
                <div>
                    <!-- Other buttons here -->
                </div>
                <div>
                    <x-ui.button type="submit">Save</x-ui.button>
                </div>
            </div>
        </form>
    </div>

    @can('view-any', App\Models\StoreProductReviewsConfiguration::class)
    <div class="overflow-hidden border rounded-lg bg-white">
        <div class="w-full mb-0">
            <div class="p-6 space-y-3">
                <div
                    class="w-full text-gray-500 text-lg font-semibold py-4 uppercase"
                >
                    <h2>
                        {{
                        __('crud.storeProductReviewsConfigurations.collectionTitle')
                        }}
                    </h2>
                </div>

                <livewire:dashboard.store-product-reviews-merchant-store-product-reviews-configurations-detail
                    :store-product-reviews-merchant="$storeProductReviewsMerchant"
                />
            </div>
        </div>
    </div>
    @endcan
</div>
