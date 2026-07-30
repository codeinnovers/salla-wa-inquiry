<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.voice-merchants.index') }}">Voice Merchants</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>Edit Subscription Plan</x-ui.breadcrumbs.link>
    </x-ui.breadcrumbs>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase flex justify-between items-center">
        <h1>Edit Subscription Plan: {{ $voiceMerchant->name ?? $voiceMerchant->merchant_identifier ?? 'Merchant #' . $voiceMerchant->id }}</h1>
        <span class="text-sm font-normal text-gray-600 bg-gray-100 px-3 py-1 rounded-full">Store Ref: {{ $voiceMerchant->store_reference ?? 'N/A' }}</span>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white shadow-sm">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-6">

                <!-- Plan Selection -->
                <div class="w-full">
                    <x-ui.label for="plan" class="font-bold text-gray-700">Select Subscription Plan</x-ui.label>
                    <select
                        wire:model.live="plan"
                        name="plan"
                        id="plan"
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-700"
                    >
                        @foreach($availablePlans as $p)
                            <option value="{{ $p->slug }}">
                                {{ $p->name }} ({{ number_format($p->monthly_search_limit) }} searches / month - {{ number_format($p->price, 2) }} {{ $p->currency }})
                            </option>
                        @endforeach
                        <option value="custom">Custom Plan (Manual Limit Entry)</option>
                    </select>
                    <x-ui.input.error for="plan" />
                    <p class="text-xs text-gray-500 mt-1">Select one of the configured subscription tiers or choose Custom to manually set limits.</p>
                </div>

                <!-- Monthly Limit -->
                <div class="w-full">
                    <x-ui.label for="monthly_voice_limit" class="font-bold text-gray-700">Monthly Voice Search Limit</x-ui.label>
                    <x-ui.input.number
                        class="w-full mt-1"
                        wire:model="monthly_voice_limit"
                        name="monthly_voice_limit"
                        id="monthly_voice_limit"
                        placeholder="e.g. 100, 2000, 10000"
                    />
                    <x-ui.input.error for="monthly_voice_limit" />
                    <p class="text-xs text-gray-500 mt-1">Maximum number of voice search API requests allowed per monthly billing cycle.</p>
                </div>

                <!-- Current Usage & Reset -->
                <div class="w-full bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <x-ui.label for="voice_usage_count" class="font-bold text-gray-700">Current Month Usage Count</x-ui.label>
                            <p class="text-xs text-gray-500">Number of searches consumed in the current billing cycle.</p>
                        </div>
                        <button
                            type="button"
                            wire:click="resetUsage"
                            wire:confirm="Are you sure you want to reset this merchant's voice usage to 0?"
                            class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-md shadow-sm transition duration-150"
                        >
                            🔄 Reset Usage to 0
                        </button>
                    </div>

                    <x-ui.input.number
                        class="w-full bg-white"
                        wire:model="voice_usage_count"
                        name="voice_usage_count"
                        id="voice_usage_count"
                    />
                    <x-ui.input.error for="voice_usage_count" />

                    @if ($voiceMerchant->usage_reset_at)
                        <p class="text-xs text-gray-500">
                            <strong>Billing Reset Date:</strong> {{ $voiceMerchant->usage_reset_at->format('M d, Y H:i:s') }} (Resets automatically every month).
                        </p>
                    @endif
                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-between items-center border-t border-gray-100 p-4 bg-gray-50">
                <a
                    href="{{ route('dashboard.voice-merchants.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-md transition duration-150"
                >
                    Back to Voice Merchants
                </a>
                <x-ui.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2">
                    Save Plan Settings
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
