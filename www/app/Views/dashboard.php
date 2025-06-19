<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('content') ?>
<div class="flex-1 flex flex-col">
    <button id="toggleBtn" onclick="toggleSidebar()"
        class="absolute top-4 left-4 z-10 bg-gray-900 text-white p-2 rounded-lg hidden">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div class="flex-1 overflow-y-auto p-6">
        <div class="max-w-3xl mx-auto h-full flex items-center justify-center">
            <div class="text-center text-gray-500">
                <div class="bg-primary w-16 h-16 rounded-full mx-auto flex items-center justify-center mb-4 opacity-50">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">¡Comienza una conversación!</h3>
                <p>Escribe tu mensaje para empezar a chatear con la IA</p>
            </div>
        </div>
    </div>

    <div class="border-t bg-white p-4">
        <div class="max-w-3xl mx-auto">
            <div class="mb-3">
                <select
                    class="bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
                    <option>GPT-4</option>
                    <option>GPT-3.5 Turbo</option>
                    <option>Claude</option>
                    <option>Gemini</option>
                </select>
            </div>

            <div class="flex space-x-3">
                <div class="flex-1 relative">
                    <textarea placeholder="Escribe tu mensaje aquí..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:border-primary"
                        rows="1" onkeydown="handleKeyDown(event)"></textarea>
                </div>
                <button
                    class="bg-primary hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>