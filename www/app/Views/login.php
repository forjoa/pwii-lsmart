<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSmart - Acceso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
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

            <?php if (session('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?= session('error') ?>
                </div>
            <?php endif ?>

            <div id="loginForm" class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-6 text-center">Iniciar Sesión</h3>
                <form action="/signin" method="POST" class="space-y-4">
                    <div>
                        <input type="email" name="email" placeholder="Email" required value="<?= old('email') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <?php if (session('errors.email')): ?>
                            <p class="error-message"><?= session('errors.email') ?></p>
                        <?php endif ?>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Contraseña" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <?php if (session('errors.password')): ?>
                            <p class="error-message"><?= session('errors.password') ?></p>
                        <?php endif ?>
                    </div>
                    <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        Entrar
                    </button>
                </form>
                <p class="text-center text-sm text-gray-600 mt-4">
                    ¿No tienes cuenta?
                    <a href="/register" class="text-primary hover:underline font-medium">Regístrate</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>