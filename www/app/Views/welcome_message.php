<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSmart</title>
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
<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full space-y-8 text-center">
            <div class="bg-primary w-16 h-16 rounded-full mx-auto flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"/>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900">LSmart</h1>
            <p class="text-gray-600">Conversaciones inteligentes al instante</p>
            
            <div class="space-y-4">
                <a href="/login" class="w-full bg-primary text-white py-3 px-6 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                    Comenzar Chat
                </a>
            </div>
            
            <div class="grid grid-cols-3 gap-4 text-center text-sm text-gray-500 pt-8">
                <div>
                    <div class="text-secondary font-bold text-lg">24/7</div>
                    <div>Disponible</div>
                </div>
                <div>
                    <div class="text-secondary font-bold text-lg">∞</div>
                    <div>Respuestas</div>
                </div>
                <div>
                    <div class="text-secondary font-bold text-lg">0s</div>
                    <div>Latencia</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>