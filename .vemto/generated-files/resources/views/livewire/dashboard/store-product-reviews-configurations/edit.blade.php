<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link
            href="{{ route('dashboard.store-product-reviews-configurations.index') }}"
            >{{ __('crud.storeProductReviewsConfigurations.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Edit {{ __('crud.storeProductReviewsConfigurations.itemTitle')
            }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <x-ui.toast on="saved">
        StoreProductReviewsConfiguration saved successfully.
    </x-ui.toast>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>
            Edit {{ __('crud.storeProductReviewsConfigurations.itemTitle') }}
        </h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="config_name"
                        >{{
                        __('crud.storeProductReviewsConfigurations.inputs.config_name.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.config_name"
                        rows="6"
                        name="config_name"
                        id="config_name"
                        placeholder="{{ __('crud.storeProductReviewsConfigurations.inputs.config_name.placeholder') }}"
                    />
                    <x-ui.input.error for="form.config_name" />
                </div>

                <div class="w-full">
                    <x-ui.label for="config_value"
                        >{{
                        __('crud.storeProductReviewsConfigurations.inputs.config_value.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.config_value"
                        rows="6"
                        name="config_value"
                        id="config_value"
                        placeholder="{{ __('crud.storeProductReviewsConfigurations.inputs.config_value.placeholder') }}"
                    />
                    <x-ui.input.error for="form.config_value" />
                </div>

                <div class="w-full">
                    <x-ui.label for="store_product_reviews_merchant_id"
                        >{{
                        __('crud.storeProductReviewsConfigurations.inputs.store_product_reviews_merchant_id.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.store_product_reviews_merchant_id"
                        name="store_product_reviews_merchant_id"
                        id="store_product_reviews_merchant_id"
                        class="w-full"
                    >
                        <option value="">Select data</option>
                        @foreach ($storeProductReviewsMerchants as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error
                        for="form.store_product_reviews_merchant_id"
                    />
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
</div>
