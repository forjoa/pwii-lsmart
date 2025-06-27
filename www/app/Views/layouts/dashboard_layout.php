<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSmart AI</title>
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
    <style>
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1.2em;
            padding-right: 2.5rem;
        }

        .markdown-content h1,
        .markdown-content h2,
        .markdown-content h3 {
            font-weight: bold;
            margin: 1em 0 0.5em;
        }

        .markdown-content h1 {
            font-size: 1.5em;
        }

        .markdown-content h2 {
            font-size: 1.3em;
        }

        .markdown-content h3 {
            font-size: 1.1em;
        }

        .markdown-content p {
            margin-bottom: 1em;
        }

        .markdown-content ul,
        .markdown-content ol {
            margin-bottom: 1em;
            padding-left: 1.5em;
        }

        .markdown-content ul {
            list-style-type: disc;
        }

        .markdown-content ol {
            list-style-type: decimal;
        }

        .markdown-content code {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 0.2em 0.4em;
            border-radius: 0.25em;
            font-family: monospace;
        }

        .markdown-content pre {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 1em;
            border-radius: 0.5em;
            overflow-x: auto;
            margin-bottom: 1em;
        }

        .markdown-content blockquote {
            border-left: 4px solid #ddd;
            padding-left: 1em;
            color: #777;
            margin-bottom: 1em;
        }
    </style>
</head>

<body class="bg-gray-50 h-screen overflow-hidden">
    <div class="flex h-full">
        <div id="sidebar" class="bg-gray-900 text-white w-80 flex flex-col transition-all duration-300">
            <div class="p-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-primary w-8 h-8 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                        </svg>
                    </div>
                    <span class="font-semibold">LSmart AI</span>
                </div>
                <button onclick="toggleSidebar()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="p-4">
                <button onclick="location.href='/'"
                    class="w-full bg-primary hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Nuevo Chat</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-2">
                <?= $this->renderSection('conversations') ?>
            </div>

            <?= $this->renderSection('user') ?>
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