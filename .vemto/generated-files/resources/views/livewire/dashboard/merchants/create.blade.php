<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.merchants.index') }}"
            >{{ __('crud.merchants.collectionTitle') }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Create {{ __('crud.merchants.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Create {{ __('crud.merchants.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="merchant_identifier"
                        >{{
                        __('crud.merchants.inputs.merchant_identifier.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.merchant_identifier"
                        name="merchant_identifier"
                        id="merchant_identifier"
                        placeholder="{{ __('crud.merchants.inputs.merchant_identifier.placeholder') }}"
                    />
                    <x-ui.input.error for="form.merchant_identifier" />
                </div>

                <div class="w-full">
                    <x-ui.label for="name"
                        >{{ __('crud.merchants.inputs.name.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.name"
                        name="name"
                        id="name"
                        placeholder="{{ __('crud.merchants.inputs.name.placeholder') }}"
                    />
                    <x-ui.input.error for="form.name" />
                </div>

                <div class="w-full">
                    <x-ui.label for="email"
                        >{{ __('crud.merchants.inputs.email.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.email
                        class="w-full"
                        wire:model="form.email"
                        name="email"
                        id="email"
                        placeholder="{{ __('crud.merchants.inputs.email.placeholder') }}"
                    />
                    <x-ui.input.error for="form.email" />
                </div>

                <div class="w-full">
                    <x-ui.label for="store_link"
                        >{{ __('crud.merchants.inputs.store_link.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.store_link"
                        name="store_link"
                        id="store_link"
                        placeholder="{{ __('crud.merchants.inputs.store_link.placeholder') }}"
                    />
                    <x-ui.input.error for="form.store_link" />
                </div>

                <div class="w-full">
                    <x-ui.label for="store_reference"
                        >{{ __('crud.merchants.inputs.store_reference.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.store_reference"
                        name="store_reference"
                        id="store_reference"
                        placeholder="{{ __('crud.merchants.inputs.store_reference.placeholder') }}"
                    />
                    <x-ui.input.error for="form.store_reference" />
                </div>

                <div class="w-full">
                    <x-ui.label for="access_token"
                        >{{ __('crud.merchants.inputs.access_token.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.access_token"
                        rows="6"
                        name="access_token"
                        id="access_token"
                        placeholder="{{ __('crud.merchants.inputs.access_token.placeholder') }}"
                    />
                    <x-ui.input.error for="form.access_token" />
                </div>

                <div class="w-full">
                    <x-ui.label for="refresh_token"
                        >{{ __('crud.merchants.inputs.refresh_token.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.refresh_token"
                        rows="6"
                        name="refresh_token"
                        id="refresh_token"
                        placeholder="{{ __('crud.merchants.inputs.refresh_token.placeholder') }}"
                    />
                    <x-ui.input.error for="form.refresh_token" />
                </div>

                <div class="w-full">
                    <x-ui.label for="token_exp"
                        >{{ __('crud.merchants.inputs.token_exp.label')
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
</div>
