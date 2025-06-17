<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSmart - Acceso</title>
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
        <div class="max-w-md w-full space-y-8">

            <div class="text-center">
                <div class="bg-primary w-16 h-16 rounded-full mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">LSmart</h2>
            </div>

            <div id="loginForm" class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-6 text-center">Iniciar Sesión</h3>
                <form class="space-y-4">
                    <div>
                        <input type="email" name="email" placeholder="Email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Contraseña"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        Entrar
                    </button>
                </form>
                <p class="text-center text-sm text-gray-600 mt-4">
                    ¿No tienes cuenta?
                    <button onclick="toggleForm()" class="text-primary hover:underline font-medium">Regístrate</button>
                </p>
            </div>

            <div id="registerForm" class="bg-white p-8 rounded-lg shadow-md hidden">
                <h3 class="text-xl font-semibold mb-6 text-center">Crear Cuenta</h3>
                <form class="space-y-4">
                    <div>
                        <input type="text" name="username" placeholder="Nombre de usuario"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Contraseña"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <div>
                        <input type="number" name="age" placeholder="Edad (opcional)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        Crear Cuenta
                    </button>
                </form>
                <p class="text-center text-sm text-gray-600 mt-4">
                    ¿Ya tienes cuenta?
                    <button onclick="toggleForm()" class="text-primary hover:underline font-medium">Inicia
                        sesión</button>
                </p>
            </div>

        </div>
    </div>

    <script>
        function toggleForm() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            loginForm.classList.toggle('hidden');
            registerForm.classList.toggle('hidden');
        }
    </script>
</body>

</html>