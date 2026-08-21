<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.voice-plan-configurations.index') }}">Plan Configurations</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>Create Plan Configuration</x-ui.breadcrumbs.link>
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Create Plan Search & Cost Configuration</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white shadow-sm">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-6">

                <!-- Plan Name -->
                <div class="w-full">
                    <x-ui.label for="name" class="font-bold text-gray-700">Plan Display Name</x-ui.label>
                    <x-ui.input
                        type="text"
                        class="w-full mt-1"
                        wire:model.live="name"
                        name="name"
                        id="name"
                        placeholder="e.g. Free Plan, Premium Tier, Enterprise Plan"
                    />
                    <x-ui.input.error for="name" />
                </div>

                <!-- Slug / Key -->
                <div class="w-full">
                    <x-ui.label for="slug" class="font-bold text-gray-700">Plan Slug / Identifier</x-ui.label>
                    <x-ui.input
                        type="text"
                        class="w-full mt-1 font-mono"
                        wire:model="slug"
                        name="slug"
                        id="slug"
                        placeholder="e.g. free, basic, pro, enterprise"
                    />
                    <x-ui.input.error for="slug" />
                    <p class="text-xs text-gray-500 mt-1">Unique key used internally to associate merchants with this plan configuration.</p>
                </div>

                <!-- Monthly Search Limit -->
                <div class="w-full">
                    <x-ui.label for="monthly_search_limit" class="font-bold text-gray-700">Search Limit</x-ui.label>
                    <x-ui.input.number
                        class="w-full mt-1"
                        wire:model="monthly_search_limit"
                        name="monthly_search_limit"
                        id="monthly_search_limit"
                        placeholder="e.g. 1000, 5000, 10000"
                    />
                    <x-ui.input.error for="monthly_search_limit" />
                    <p class="text-xs text-gray-500 mt-1">Maximum search requests allowed per merchant per subscription cycle on this plan.</p>
                </div>

                <!-- Plan Duration in Days -->
                <div class="w-full">
                    <x-ui.label for="days" class="font-bold text-gray-700">Plan Duration (Days)</x-ui.label>
                    <x-ui.input.number
                        class="w-full mt-1"
                        wire:model="days"
                        name="days"
                        id="days"
                        placeholder="e.g. 3, 30, 360"
                    />
                    <x-ui.input.error for="days" />
                    <p class="text-xs text-gray-500 mt-1">Duration of the subscription cycle in days (Free = 3 days, Basic = 30 days, Pro = 360 days / 1 year).</p>
                </div>

                <!-- Price / Cost -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-ui.label for="price" class="font-bold text-gray-700">Plan Cost / Price</x-ui.label>
                        <x-ui.input
                            type="number"
                            step="0.01"
                            class="w-full mt-1"
                            wire:model="price"
                            name="price"
                            id="price"
                            placeholder="0.00"
                        />
                        <x-ui.input.error for="price" />
                    </div>

                    <div>
                        <x-ui.label for="currency" class="font-bold text-gray-700">Currency</x-ui.label>
                        <x-ui.input
                            type="text"
                            class="w-full mt-1"
                            wire:model="currency"
                            name="currency"
                            id="currency"
                            placeholder="SAR"
                        />
                        <x-ui.input.error for="currency" />
                    </div>
                </div>

                <!-- Description -->
                <div class="w-full">
                    <x-ui.label for="description" class="font-bold text-gray-700">Description</x-ui.label>
                    <textarea
                        wire:model="description"
                        name="description"
                        id="description"
                        rows="3"
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-700 text-sm"
                        placeholder="Brief summary of plan limits and pricing details..."
                    ></textarea>
                    <x-ui.input.error for="description" />
                </div>

                <!-- Is Active -->
                <div class="flex items-center space-x-2">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        id="is_active"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    />
                    <x-ui.label for="is_active" class="font-semibold text-gray-700 cursor-pointer">Active (Available for Merchant assignment)</x-ui.label>
                </div>

            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center border-t border-gray-100 p-4 bg-gray-50">
                <a
                    href="{{ route('dashboard.voice-plan-configurations.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-md transition duration-150"
                >
                    Cancel
                </a>
                <x-ui.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2">
                    Create Plan Configuration
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
