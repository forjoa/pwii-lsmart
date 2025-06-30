<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('conversations') ?>
<?php if (sizeof($conversations) > 0) { ?>
    <?php foreach ($conversations as $conversation) { ?>
        <div class="relative conversation-item">
            <button onclick="location.href='/chat/<?= $conversation['id'] ?>'"
                class="bg-gray-800 w-full hover:bg-gray-700 p-3 rounded-lg cursor-pointer transition-colors">
                <div class="font-medium truncate"><?= $conversation['title'] ?></div>
                <div class="text-xs text-gray-400 mt-1"><?= $conversation['date'] ?></div>
            </button>

            <!-- Menu Button -->
            <button onclick="toggleMenu(event, <?= $conversation['id'] ?>)"
                class="menu-btn absolute top-2 right-2 opacity-0 hover:opacity-100 transition-opacity bg-gray-700 hover:bg-gray-600 p-1 rounded text-gray-300 hover:text-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="menu-<?= $conversation['id'] ?>"
                class="menu-dropdown absolute top-8 right-2 bg-gray-800 border border-gray-600 rounded-lg shadow-lg z-10 hidden">
                <button onclick="deleteConversation(<?= $conversation['id'] ?>)"
                    class="w-full px-4 py-2 text-left text-red-400 hover:text-red-300 hover:bg-gray-700 rounded-lg transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Eliminar</span>
                </button>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="p-3 rounded-lg">
        <div class="font-medium truncate">No tienes chats</div>
    </div>
<?php } ?>

<style>
    .conversation-item:hover .menu-btn {
        opacity: 1;
    }
</style>

<script>
    function toggleMenu(event, conversationId) {
        event.stopPropagation();

        document.querySelectorAll('.menu-dropdown').forEach(menu => {
            if (menu.id !== `menu-${conversationId}`) {
                menu.classList.add('hidden');
            }
        });

        const menu = document.getElementById(`menu-${conversationId}`);
        menu.classList.toggle('hidden');
    }

    function deleteConversation(conversationId) {
        if (confirm('¿Estás seguro de que quieres eliminar esta conversación?')) {
            fetch(`/history/${conversationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (response.ok) {
                        const conversationElement = document.querySelector(`#menu-${conversationId}`).closest('.conversation-item');
                        conversationElement.remove();

                        const remainingConversations = document.querySelectorAll('.conversation-item');
                        if (remainingConversations.length === 0) {
                            const container = document.querySelector('.conversation-item').parentNode;
                            container.innerHTML = '<div class="p-3 rounded-lg"><div class="font-medium truncate">No tienes chats</div></div>';
                        }
                    } else {
                        alert('Error al eliminar la conversación');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar la conversación');
                });
        }
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.menu-btn') && !event.target.closest('.menu-dropdown')) {
            document.querySelectorAll('.menu-dropdown').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>

<?= $this->endSection() ?>

<?= $this->section('user') ?>
<button onclick="location.href='/profile'" class="p-4 border-t border-gray-700">
    <div class="flex items-center space-x-3">
        <div class="bg-secondary w-8 h-8 rounded-full flex items-center justify-center">
            <?php if (!empty($profile_pic)) { ?>
                <img src="<?= base_url($profile_pic) ?>" alt="Foto de perfil" class="w-8 h-8 rounded-full object-cover">
            <?php } else { ?>
                <span class="text-sm font-medium"><?= strtoupper(str_split($username)[0] ?? '') ?></span>
            <?php } ?>
        </div>
        <div class="flex-1 truncate">
            <div class="font-medium"><?= $username ?></div>
            <div class="text-xs text-gray-400"><?= $email ?></div>
        </div>
    </div>
</button>
<button onclick="location.href='/logout'"
    class="hover:bg-red-900 text-red-600 py-2 rounded-lg transition-colors flex items-center justify-center space-x-2 m-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 8H5a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2h-1" />
    </svg>
    <span>Salir</span>
</button>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex-1 flex flex-col min-h-screen">
    <button id="toggleBtn" onclick="toggleSidebar()"
        class="absolute top-4 left-4 z-10 bg-gray-900 text-white p-2 rounded-lg hidden">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <?php if (!isset($conversation_id)) { ?>
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
    <?php } else { ?>
        <div class="flex-1 overflow-y-auto p-6" id="chat-messages">
            <div class="max-w-3xl mx-auto space-y-4">
                <?php
                $parsedown = new Parsedown();
                $parsedown->setSafeMode(true);
                ?>

                <?php foreach ($messages as $message): ?>
                    <?php if ($message['is_user_message']): ?>
                        <div class="flex justify-end">
                            <div class="max-w-[85%] lg:max-w-[75%]">
                                <div class="bg-primary text-white rounded-lg py-2 px-4">
                                    <div class="bg-primary text-white rounded-lg markdown-content">
                                        <?= $parsedown->text($message['content']) ?>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 text-right">
                                    <?= date('H:i', strtotime($message['created_at'])) ?>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="flex justify-start">
                            <div class="max-w-[85%] lg:max-w-[75%]">
                                <div class="bg-gray-100 rounded-lg py-2 px-4">
                                    <div class="rounded-lg markdown-content">
                                        <?= $parsedown->text($message['content']) ?>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?= date('H:i', strtotime($message['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php } ?>

    <div class="border-t bg-white p-4">
        <div class="max-w-3xl mx-auto">
            <form action="/send-message" method="POST" id="messageForm">
                <input type="hidden" name="conversation_id" value="<?= $conversation_id ?? '' ?>">
                <div class="mb-3">
                    <div class="mb-3">
                        <select name="model"
                            class="bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary"
                            required>
                            <?php foreach ($groq_models as $modelId): ?>
                                <option value="<?= htmlspecialchars($modelId) ?>" <?= ($modelId === 'llama-3.3-70b-versatile') ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($modelId) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <div class="flex-1 relative">
                        <textarea name="message" placeholder="Escribe tu mensaje aquí..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:border-primary"
                            rows="1" required onkeydown="handleKeyDown(event)"></textarea>
                    </div>
                    <button type="submit"
                        class="bg-primary hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>