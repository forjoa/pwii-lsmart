<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSmart - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="bg-primary w-16 h-16 rounded-full mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">LSmart</h2>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-6 text-center">Crear Cuenta</h3>
                
                <?php if(session('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?= session('error') ?>
                    </div>
                <?php endif ?>

                <form action="/sign-up" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto de perfil (opcional)</label>
                        <div class="flex items-center">
                            <img id="profilePreview" src="/default-profile.jpg" class="w-16 h-16 rounded-full object-cover mr-4 border border-gray-300">
                            <input type="file" name="profile_picture" id="profilePicture" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('profilePicture').click()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                                Seleccionar imagen
                            </button>
                        </div>
                    </div>

                    <!-- Username -->
                    <div>
                        <input type="text" name="username" placeholder="Nombre de usuario (opcional)" value="<?= old('username') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <?php if(session('errors.username')): ?>
                            <p class="error-message"><?= session('errors.username') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Email -->
                    <div>
                        <input type="email" name="email" placeholder="Email" required value="<?= old('email') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <?php if(session('errors.email')): ?>
                            <p class="error-message"><?= session('errors.email') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <input type="password" name="password" placeholder="Contraseña" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <?php if(session('errors.password')): ?>
                            <p class="error-message"><?= session('errors.password') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Repeat Password -->
                    <div>
                        <input type="password" name="password_confirm" placeholder="Repetir contraseña" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        <?php if(session('errors.password_confirm')): ?>
                            <p class="error-message"><?= session('errors.password_confirm') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                    <?php if(session('errors.recaptcha')): ?>
                        <p class="error-message"><?= session('errors.recaptcha') ?></p>
                    <?php endif ?>

                    <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        Crear Cuenta
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-4">
                    ¿Ya tienes cuenta?
                    <a href="/sign-in" class="text-primary hover:underline font-medium">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Preview de la imagen de perfil
        document.getElementById('profilePicture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profilePreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>