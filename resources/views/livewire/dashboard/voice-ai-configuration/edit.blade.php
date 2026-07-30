<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard">Dashboard</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>ElevenLabs & AI Settings</x-ui.breadcrumbs.link>
    </x-ui.breadcrumbs>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>ElevenLabs API Key & Voice AI Configuration</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white shadow-sm">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-6">

                <!-- ElevenLabs API Key -->
                <div class="w-full">
                    <x-ui.label for="elevenlabs_api_key" class="font-bold text-gray-700">ElevenLabs API Key *</x-ui.label>
                    <div class="flex gap-2 mt-1">
                        <input
                            type="password"
                            wire:model="elevenlabs_api_key"
                            name="elevenlabs_api_key"
                            id="elevenlabs_api_key"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-700 font-mono text-sm"
                            placeholder="sk_..."
                        />
                        <button
                            type="button"
                            wire:click="testElevenLabsKey"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-md shadow-sm whitespace-nowrap transition duration-150"
                        >
                            ⚡ Test API Key
                        </button>
                    </div>
                    <x-ui.input.error for="elevenlabs_api_key" />
                    <p class="text-xs text-gray-500 mt-1">Enter your ElevenLabs secret API Key used for Speech-to-Text (STT) and Voice AI features.</p>
                </div>

                @if ($testStatus === 'success')
                    <div class="bg-green-50 border border-green-300 text-green-800 text-xs p-3 rounded-md flex items-center gap-2">
                        <span>✅</span>
                        <span>{{ $testMessage }}</span>
                    </div>
                @elseif ($testStatus === 'error')
                    <div class="bg-red-50 border border-red-300 text-red-800 text-xs p-3 rounded-md flex items-center gap-2">
                        <span>❌</span>
                        <span>{{ $testMessage }}</span>
                    </div>
                @endif

                <!-- Model Selection -->
                <div class="w-full">
                    <x-ui.label for="default_model" class="font-bold text-gray-700">Speech-to-Text Model ID</x-ui.label>
                    <x-ui.input
                        type="text"
                        class="w-full mt-1 font-mono"
                        wire:model="default_model"
                        name="default_model"
                        id="default_model"
                        placeholder="scribe_v2"
                    />
                    <x-ui.input.error for="default_model" />
                    <p class="text-xs text-gray-500 mt-1">Default ElevenLabs Speech-to-Text model ID (e.g., <code>scribe_v2</code>).</p>
                </div>

                <!-- OpenAI Key (Optional) -->
                <div class="w-full">
                    <x-ui.label for="openai_api_key" class="font-bold text-gray-700">OpenAI API Key (Optional)</x-ui.label>
                    <input
                        type="password"
                        wire:model="openai_api_key"
                        name="openai_api_key"
                        id="openai_api_key"
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-700 font-mono text-sm"
                        placeholder="sk-proj-..."
                    />
                    <x-ui.input.error for="openai_api_key" />
                    <p class="text-xs text-gray-500 mt-1">Optional OpenAI Key for secondary AI query processing.</p>
                </div>

                <!-- Is Active -->
                <div class="flex items-center space-x-2">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        id="is_active"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    />
                    <x-ui.label for="is_active" class="font-semibold text-gray-700 cursor-pointer">Enable Voice AI API Configurations</x-ui.label>
                </div>

            </div>

            <!-- Footer -->
            <div class="flex justify-end items-center border-t border-gray-100 p-4 bg-gray-50">
                <x-ui.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2">
                    Save API Configuration
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
