<div>
    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="detailFacebookConfigsSearch"
            type="text"
            placeholder="Search {{ __('crud.facebookConfigs.collectionTitle') }}..."
        />

        @can('create', App\Models\FacebookConfig::class)
        <a wire:click="newFacebookConfig()">
            <x-ui.button>New</x-ui.button>
        </a>
        @endcan
    </div>

    {{-- Modal --}}
    <x-ui.modal wire:model="showingModal">
        <div class="overflow-hidden border rounded-lg bg-white">
            <form class="w-full mb-0" wire:submit.prevent="save">
                <div class="p-6 space-y-3">
                    <div class="w-full">
                        <x-ui.label for="merchant_identifier"
                            >{{
                            __('crud.facebookConfigs.inputs.merchant_identifier.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.text
                            class="w-full"
                            wire:model="form.merchant_identifier"
                            name="merchant_identifier"
                            id="merchant_identifier"
                            placeholder="{{ __('crud.facebookConfigs.inputs.merchant_identifier.placeholder') }}"
                        />
                        <x-ui.input.error for="form.merchant_identifier" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="config_name"
                            >{{
                            __('crud.facebookConfigs.inputs.config_name.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.textarea
                            class="w-full"
                            wire:model="form.config_name"
                            rows="6"
                            name="config_name"
                            id="config_name"
                            placeholder="{{ __('crud.facebookConfigs.inputs.config_name.placeholder') }}"
                        />
                        <x-ui.input.error for="form.config_name" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="config_value"
                            >{{
                            __('crud.facebookConfigs.inputs.config_value.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.textarea
                            class="w-full"
                            wire:model="form.config_value"
                            rows="6"
                            name="config_value"
                            id="config_value"
                            placeholder="{{ __('crud.facebookConfigs.inputs.config_value.placeholder') }}"
                        />
                        <x-ui.input.error for="form.config_value" />
                    </div>
                </div>

                <div
                    class="flex justify-between mt-4 border-t border-gray-50 bg-gray-50 p-4"
                >
                    <div>
                        <!-- Other buttons here -->
                    </div>
                    <div>
                        <x-ui.button type="submit">Save</x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingFacebookConfigDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingFacebookConfigDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="deleteFacebookConfig({{ $deletingFacebookConfig }})"
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
                    for-detailCrud
                    wire:click="sortBy('merchant_identifier')"
                    >{{
                    __('crud.facebookConfigs.inputs.merchant_identifier.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-detailCrud
                    wire:click="sortBy('config_name')"
                    >{{ __('crud.facebookConfigs.inputs.config_name.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-detailCrud
                    wire:click="sortBy('config_value')"
                    >{{ __('crud.facebookConfigs.inputs.config_value.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($detailFacebookConfigs as $facebookConfig)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-detailCrud
                        >{{ $facebookConfig->merchant_identifier
                        }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $facebookConfig->config_name }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $facebookConfig->config_value }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $facebookConfig)
                        <x-ui.action
                            wire:click="editFacebookConfig({{ $facebookConfig->id }})"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $facebookConfig)
                        <x-ui.action.danger
                            wire:click="confirmFacebookConfigDeletion({{ $facebookConfig->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="4"
                        >No {{ __('crud.facebookConfigs.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $detailFacebookConfigs->links() }}</div>
    </x-ui.container.table>
</div>
