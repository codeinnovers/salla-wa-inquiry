<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link
            href="{{ route('dashboard.store-and-product-webhooks.index') }}"
            >{{ __('crud.storeAndProductWebhooks.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Edit {{ __('crud.storeAndProductWebhooks.itemTitle')
            }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <x-ui.toast on="saved">
        StoreAndProductWebhook saved successfully.
    </x-ui.toast>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Edit {{ __('crud.storeAndProductWebhooks.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="event"
                        >{{
                        __('crud.storeAndProductWebhooks.inputs.event.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.event"
                        name="event"
                        id="event"
                        placeholder="{{ __('crud.storeAndProductWebhooks.inputs.event.placeholder') }}"
                    />
                    <x-ui.input.error for="form.event" />
                </div>

                <div class="w-full">
                    <x-ui.label for="reference_number"
                        >{{
                        __('crud.storeAndProductWebhooks.inputs.reference_number.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.reference_number"
                        name="reference_number"
                        id="reference_number"
                        placeholder="{{ __('crud.storeAndProductWebhooks.inputs.reference_number.placeholder') }}"
                    />
                    <x-ui.input.error for="form.reference_number" />
                </div>

                <div class="w-full">
                    <x-ui.label for="merchant"
                        >{{
                        __('crud.storeAndProductWebhooks.inputs.merchant.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.merchant"
                        name="merchant"
                        id="merchant"
                        placeholder="{{ __('crud.storeAndProductWebhooks.inputs.merchant.placeholder') }}"
                    />
                    <x-ui.input.error for="form.merchant" />
                </div>

                <div class="w-full">
                    <x-ui.label for="payload"
                        >{{
                        __('crud.storeAndProductWebhooks.inputs.payload.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.payload"
                        rows="6"
                        name="payload"
                        id="payload"
                        placeholder="{{ __('crud.storeAndProductWebhooks.inputs.payload.placeholder') }}"
                    />
                    <x-ui.input.error for="form.payload" />
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
