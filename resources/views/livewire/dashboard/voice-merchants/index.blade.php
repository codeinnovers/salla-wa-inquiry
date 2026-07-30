<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>Voice Merchants</x-ui.breadcrumbs.link>
    </x-ui.breadcrumbs>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center py-4">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="Search Voice Merchants..."
        />
        @can('create', App\Models\VoiceMerchant::class)
        <a
            href="{{ route('dashboard.voice-merchants.create') }}"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition duration-150 flex items-center gap-1"
        >
            ➕ Add Voice Merchant
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
                wire:click="delete({{ $deletingVoiceMerchant }})"
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
                <x-ui.table.header for-crud wire:click="sortBy('merchant_identifier')">Merchant Identifier</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('name')">Name</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('email')">Email</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('store_reference')">Store Reference</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('plan')">Plan</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('voice_usage_count')">Monthly Usage</x-ui.table.header>
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($voiceMerchants as $voiceMerchant)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud>{{ $voiceMerchant->merchant_identifier }}</x-ui.table.column>
                    <x-ui.table.column for-crud>{{ $voiceMerchant->name }}</x-ui.table.column>
                    <x-ui.table.column for-crud>{{ $voiceMerchant->email }}</x-ui.table.column>
                    <x-ui.table.column for-crud>{{ $voiceMerchant->store_reference }}</x-ui.table.column>
                    <x-ui.table.column for-crud>
                        @php
                            $planName = strtolower($voiceMerchant->plan ?? 'free');
                            $badgeColors = [
                                'free' => 'bg-gray-100 text-gray-800 border-gray-300',
                                'basic' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'pro' => 'bg-purple-100 text-purple-800 border-purple-300',
                            ];
                            $color = $badgeColors[$planName] ?? 'bg-indigo-100 text-indigo-800 border-indigo-300';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $color }}">
                            {{ ucfirst($planName) }}
                        </span>
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        @php
                            $used = $voiceMerchant->voice_usage_count ?? 0;
                            $limit = $voiceMerchant->getMonthlyLimit();
                            $remaining = max(0, $limit - $used);
                            $pct = $limit > 0 ? min(100, round(($used / $limit) * 100)) : 0;
                        @endphp
                        <div class="space-y-1 min-w-[140px]">
                            <div class="flex justify-between text-xs font-semibold text-gray-800">
                                <span>🔍 <span class="text-indigo-600 font-bold">{{ number_format($used) }}</span> / {{ number_format($limit) }}</span>
                                <span class="text-gray-500 font-normal">({{ $pct }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                            <div class="text-[11px] text-emerald-600 font-medium">
                                {{ number_format($remaining) }} searches left
                            </div>
                        </div>
                    </x-ui.table.column>
                    <x-ui.table.action-column>
                        @can('update', $voiceMerchant)
                        <a
                            href="{{ route('dashboard.voice-merchants.edit', $voiceMerchant) }}"
                            class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md border border-indigo-300 text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition ease-in-out duration-150 me-2"
                        >
                            ✏️ Edit Plan
                        </a>
                        @endcan
                        @can('delete', $voiceMerchant)
                        <x-ui.action.danger wire:click="confirmDeletion({{ $voiceMerchant->id }})">Delete</x-ui.action.danger>
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="7">No Voice Merchants found.</x-ui.table.column>
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $voiceMerchants->links() }}</div>
    </x-ui.container.table>
</div>
