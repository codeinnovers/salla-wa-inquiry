<div>
    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="detailWebhooksSearch"
            type="text"
            placeholder="Search {{ __('crud.webhooks.collectionTitle') }}..."
        />

        @can('create', App\Models\Webhook::class)
        <a wire:click="newWebhook()">
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
                        <x-ui.label for="event"
                            >{{ __('crud.webhooks.inputs.event.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.text
                            class="w-full"
                            wire:model="form.event"
                            name="event"
                            id="event"
                            placeholder="{{ __('crud.webhooks.inputs.event.placeholder') }}"
                        />
                        <x-ui.input.error for="form.event" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="reference_number"
                            >{{
                            __('crud.webhooks.inputs.reference_number.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.text
                            class="w-full"
                            wire:model="form.reference_number"
                            name="reference_number"
                            id="reference_number"
                            placeholder="{{ __('crud.webhooks.inputs.reference_number.placeholder') }}"
                        />
                        <x-ui.input.error for="form.reference_number" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="status"
                            >{{ __('crud.webhooks.inputs.status.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.text
                            class="w-full"
                            wire:model="form.status"
                            name="status"
                            id="status"
                            placeholder="{{ __('crud.webhooks.inputs.status.placeholder') }}"
                        />
                        <x-ui.input.error for="form.status" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="payload"
                            >{{ __('crud.webhooks.inputs.payload.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.textarea
                            class="w-full"
                            wire:model="form.payload"
                            rows="6"
                            name="payload"
                            id="payload"
                            placeholder="{{ __('crud.webhooks.inputs.payload.placeholder') }}"
                        />
                        <x-ui.input.error for="form.payload" />
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
    <x-ui.modal.confirm wire:model="confirmingWebhookDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingWebhookDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="deleteWebhook({{ $deletingWebhook }})"
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
                <x-ui.table.header for-detailCrud wire:click="sortBy('event')"
                    >{{ __('crud.webhooks.inputs.event.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-detailCrud
                    wire:click="sortBy('reference_number')"
                    >{{ __('crud.webhooks.inputs.reference_number.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-detailCrud wire:click="sortBy('status')"
                    >{{ __('crud.webhooks.inputs.status.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-detailCrud wire:click="sortBy('payload')"
                    >{{ __('crud.webhooks.inputs.payload.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($detailWebhooks as $webhook)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-detailCrud
                        >{{ $webhook->event }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $webhook->reference_number }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $webhook->status }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $webhook->payload }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $webhook)
                        <x-ui.action
                            wire:click="editWebhook({{ $webhook->id }})"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $webhook)
                        <x-ui.action.danger
                            wire:click="confirmWebhookDeletion({{ $webhook->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="5"
                        >No {{ __('crud.webhooks.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $detailWebhooks->links() }}</div>
    </x-ui.container.table>
</div>
