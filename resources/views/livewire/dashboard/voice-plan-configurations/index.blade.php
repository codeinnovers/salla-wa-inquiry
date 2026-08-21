<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>Plan Configurations</x-ui.breadcrumbs.link>
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
            placeholder="Search Plan Configurations..."
        />
        @can('create', App\Models\VoicePlanConfiguration::class)
        <a
            href="{{ route('dashboard.voice-plan-configurations.create') }}"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition duration-150 flex items-center gap-1"
        >
            ➕ Create Plan Configuration
        </a>
        @endcan
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete Plan Configuration') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure you want to delete this subscription plan configuration?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="delete({{ $deletingVoicePlanConfiguration }})"
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
                <x-ui.table.header for-crud wire:click="sortBy('name')">Plan Name</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('slug')">Key / Slug</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('monthly_search_limit')">Search Limit</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('days')">Duration (Days)</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('price')">Cost / Price</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('is_active')">Status</x-ui.table.header>
                <x-ui.table.header for-crud>Description</x-ui.table.header>
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($planConfigurations as $config)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud>
                        <span class="font-bold text-gray-900">{{ $config->name }}</span>
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        <code class="px-2 py-0.5 bg-gray-100 text-xs rounded text-gray-700 font-mono">{{ $config->slug }}</code>
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            🔍 {{ number_format($config->monthly_search_limit) }} searches
                        </span>
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                            📅 {{ $config->days ?? 30 }} days
                        </span>
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        <span class="font-semibold text-emerald-700">
                            {{ number_format($config->price, 2) }} {{ $config->currency }}
                        </span>
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        @if($config->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                Inactive
                            </span>
                        @endif
                    </x-ui.table.column>
                    <x-ui.table.column for-crud>
                        <span class="text-xs text-gray-500 max-w-xs truncate block">{{ $config->description ?? '—' }}</span>
                    </x-ui.table.column>
                    <x-ui.table.action-column>
                        @can('update', $config)
                        <a
                            href="{{ route('dashboard.voice-plan-configurations.edit', $config) }}"
                            class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md border border-indigo-300 text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition ease-in-out duration-150 me-2"
                        >
                            ✏️ Edit
                        </a>
                        @endcan
                        @can('delete', $config)
                        <x-ui.action.danger wire:click="confirmDeletion({{ $config->id }})">Delete</x-ui.action.danger>
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="8">No Plan Configurations found.</x-ui.table.column>
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $planConfigurations->links() }}</div>
    </x-ui.container.table>
</div>
