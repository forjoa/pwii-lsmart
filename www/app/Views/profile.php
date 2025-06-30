<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSmart AI - Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#10b981',
                        accent: '#f59e0b',
                        danger: '#ef4444'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button onclick="location.href='/'" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="bg-primary w-8 h-8 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-gray-900">Mi Perfil</h1>
            </div>
            <div class="flex space-x-3 items-center">
                <!-- <a href="/history" class="px-2 underline">Historial</a> -->
                <button onclick="toggleEdit()" id="editBtn"
                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Editar
                </button>
                <form action="/logout" method="POST" class="inline">
                    <button type="submit"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-secondary p-6 text-white">
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <?php if (!empty($user['profile_pic'])): ?>
                            <img src="<?= esc($user['profile_pic']) ?>" alt="Foto de perfil"
                                class="w-24 h-24 rounded-full object-cover">
                        <?php else: ?>
                            <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        <?php endif; ?>
                        <button onclick="document.getElementById('profile_pic').click()"
                            class="absolute bottom-0 right-0 bg-accent w-8 h-8 rounded-full flex items-center justify-center text-white hover:bg-yellow-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <input type="file" id="profile_pic" name="profile_pic" class="hidden" accept="image/*">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold"><?= esc($user['username']) ?></h2>
                        <p class="text-blue-100">ID: #<?= esc($user['id']) ?></p>
                        <p class="text-blue-100 text-sm">Miembro desde
                            <?= date('F Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div id="viewMode">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de Usuario</label>
                                <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-lg"><?= esc($user['username']) ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-lg"><?= esc($user['email']) ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                                <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-lg">
                                    <?= $user['age'] ? esc($user['age']) . ' años' : 'No especificada' ?>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Registro</label>
                                <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-lg">
                                    <?= date('j F Y, g:i A', strtotime($user['created_at'])) ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Última Actualización</label>
                                <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-lg">
                                    <?= date('j F Y, g:i A', strtotime($user['updated_at'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="editMode" class="hidden">
                    <form action="/profile" method="POST" enctype="multipart/form-data">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de
                                        Usuario</label>
                                    <input type="text" name="username" value="<?= esc($user['username']) ?>"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" value="<?= esc($user['email']) ?>" disabled
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                                    <input type="number" name="age" value="<?= esc($user['age']) ?>"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                                    <input type="password" name="password"
                                        placeholder="Dejar vacío para mantener actual"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar
                                        Contraseña</label>
                                    <input type="password" name="password_confirmation"
                                        placeholder="Confirmar nueva contraseña"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                                    <input type="file" name="profile_pic" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-8">
                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="bg-secondary text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors font-medium">
                                    Guardar Cambios
                                </button>
                                <button type="button" onclick="toggleEdit()"
                                    class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                                    Cancelar
                                </button>
                            </div>
                            <button type="button" onclick="confirmDelete()"
                                class="bg-danger text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium">
                                Eliminar Cuenta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-bold mb-4">Confirmar Eliminación</h3>
            <p class="mb-6">¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </button>
                <form action="/profile" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="bg-danger text-white px-4 py-2 rounded hover:bg-red-700">
                        Eliminar Cuenta
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleEdit() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const editBtn = document.getElementById('editBtn');

            if (viewMode.classList.contains('hidden')) {
                viewMode.classList.remove('hidden');
                editMode.classList.add('hidden');
                editBtn.textContent = 'Editar';
            } else {
                viewMode.classList.add('hidden');
                editMode.classList.remove('hidden');
                editBtn.textContent = 'Ver';
            }
        }

        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        document.getElementById('profile_pic').addEventListener('change', function (event) {
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                const profilePicContainer = event.target.closest('.relative').querySelector('img, div');

                reader.onload = function (e) {
                    if (profilePicContainer.tagName === 'IMG') {
                        profilePicContainer.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-24 h-24 rounded-full object-cover';
                        profilePicContainer.replaceWith(img);
                    }
                };

                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
</body>

</html>