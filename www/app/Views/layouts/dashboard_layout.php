<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBot AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#10b981',
                        accent: '#f59e0b'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 h-screen overflow-hidden">
    <div class="flex h-full">

        <!-- Sidebar -->
        <div id="sidebar" class="bg-gray-900 text-white w-80 flex flex-col transition-all duration-300">
            <!-- Header -->
            <div class="p-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-primary w-8 h-8 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                        </svg>
                    </div>
                    <span class="font-semibold">ChatBot AI</span>
                </div>
                <button onclick="toggleSidebar()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="p-4">
                <button
                    class="w-full bg-primary hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Nuevo Chat</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-2">
                <div class="bg-gray-800 hover:bg-gray-700 p-3 rounded-lg cursor-pointer transition-colors">
                    <div class="font-medium truncate">Chat sobre JavaScript</div>
                    <div class="text-xs text-gray-400 mt-1">Hace 2 horas</div>
                </div>
                <div class="bg-gray-800 hover:bg-gray-700 p-3 rounded-lg cursor-pointer transition-colors">
                    <div class="font-medium truncate">Explicación de React Hooks</div>
                    <div class="text-xs text-gray-400 mt-1">Ayer</div>
                </div>
                <div class="bg-gray-800 hover:bg-gray-700 p-3 rounded-lg cursor-pointer transition-colors">
                    <div class="font-medium truncate">Diseño de base de datos</div>
                    <div class="text-xs text-gray-400 mt-1">Hace 3 días</div>
                </div>
                <div class="bg-gray-800 hover:bg-gray-700 p-3 rounded-lg cursor-pointer transition-colors">
                    <div class="font-medium truncate">Algoritmos de ordenamiento</div>
                    <div class="text-xs text-gray-400 mt-1">Hace 1 semana</div>
                </div>
            </div>

            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="bg-secondary w-8 h-8 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium">U</span>
                    </div>
                    <div class="flex-1 truncate">
                        <div class="font-medium">Usuario</div>
                        <div class="text-xs text-gray-400">Cuenta Premium</div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->renderSection('content') ?>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleBtn');

            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('z-20');

            if (sidebar.classList.contains('-translate-x-full')) {
                toggleBtn.classList.remove('hidden');
            } else {
                toggleBtn.classList.add('hidden');
            }
        }

        function handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                
                console.log('Enviar mensaje');
            }
        }

        document.querySelector('textarea').addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        });
    </script>
</body>

</html>