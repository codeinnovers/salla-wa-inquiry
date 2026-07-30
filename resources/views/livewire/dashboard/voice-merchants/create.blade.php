<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.voice-merchants.index') }}">Voice Merchants</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>Add Voice Merchant</x-ui.breadcrumbs.link>
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Add New Voice Merchant & Plan</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white shadow-sm">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="w-full">
                        <x-ui.label for="store_reference" class="font-bold text-gray-700">Store Reference *</x-ui.label>
                        <x-ui.input.text
                            class="w-full mt-1"
                            wire:model="store_reference"
                            name="store_reference"
                            id="store_reference"
                            placeholder="e.g. store_12345"
                        />
                        <x-ui.input.error for="store_reference" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="merchant_identifier" class="font-bold text-gray-700">Merchant Identifier</x-ui.label>
                        <x-ui.input.text
                            class="w-full mt-1"
                            wire:model="merchant_identifier"
                            name="merchant_identifier"
                            id="merchant_identifier"
                            placeholder="e.g. 12345"
                        />
                        <x-ui.input.error for="merchant_identifier" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="w-full">
                        <x-ui.label for="name" class="font-bold text-gray-700">Merchant Name</x-ui.label>
                        <x-ui.input.text
                            class="w-full mt-1"
                            wire:model="name"
                            name="name"
                            id="name"
                            placeholder="e.g. My Online Store"
                        />
                        <x-ui.input.error for="name" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="email" class="font-bold text-gray-700">Merchant Email</x-ui.label>
                        <x-ui.input.email
                            class="w-full mt-1"
                            wire:model="email"
                            name="email"
                            id="email"
                            placeholder="e.g. merchant@example.com"
                        />
                        <x-ui.input.error for="email" />
                    </div>
                </div>

                <div class="w-full">
                    <x-ui.label for="store_link" class="font-bold text-gray-700">Store Link</x-ui.label>
                    <x-ui.input.text
                        class="w-full mt-1"
                        wire:model="store_link"
                        name="store_link"
                        id="store_link"
                        placeholder="https://mystore.salla.sa"
                    />
                    <x-ui.input.error for="store_link" />
                </div>

                <hr class="my-4 border-gray-200" />

                <!-- Subscription Plan Selection -->
                <div class="w-full">
                    <x-ui.label for="plan" class="font-bold text-gray-700">Subscription Plan *</x-ui.label>
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
                </div>

                <!-- Monthly Limit -->
                <div class="w-full">
                    <x-ui.label for="monthly_voice_limit" class="font-bold text-gray-700">Monthly Voice Search Limit *</x-ui.label>
                    <x-ui.input.number
                        class="w-full mt-1"
                        wire:model="monthly_voice_limit"
                        name="monthly_voice_limit"
                        id="monthly_voice_limit"
                        placeholder="e.g. 100, 2000, 10000"
                    />
                    <x-ui.input.error for="monthly_voice_limit" />
                </div>

            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center border-t border-gray-100 p-4 bg-gray-50">
                <a
                    href="{{ route('dashboard.voice-merchants.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-md transition duration-150"
                >
                    Cancel
                </a>
                <x-ui.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2">
                    Create Merchant & Assign Plan
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
