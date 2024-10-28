<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administració d'usuaris</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="mb-4">Administración de Usuarios</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Imagen de Perfil</th>
                    <th>Nombre</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Mail</th>
                    <th>Admin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de usuario en la tabla -->
                <tr>
                    <td><img src="ruta/de/imagen_perfil.jpg" alt="Imagen de Perfil" class="img-thumbnail" width="50"></td>
                    <td>Juan Pérez</td>
                    <td>juanperez</td>
                    <td>********</td>
                    <td>juan.perez@example.com</td>
                    <td>
                        <span class="badge bg-success">Admin</span> <!-- O bg-secondary para usuario normal -->
                    </td>
                    <td>
                        <!-- Botón para alternar entre Admin y Usuario -->
                        <button class="btn btn-sm btn-warning" onclick="toggleAdmin('juanperez')">
                            Convertir en Usuario
                        </button>
                        <!-- Botón para editar el usuario -->
                        <button class="btn btn-sm btn-primary" onclick="editUser('juanperez')">
                            Editar
                        </button>
                    </td>
                </tr>
                <!-- Más usuarios -->
            </tbody>
        </table>
    </div>

    <script>
        // Función para alternar entre Admin y Usuario
        function toggleAdmin(username) {
            // Aquí podrías hacer una llamada AJAX o redireccionar a una ruta PHP para cambiar el rol del usuario
            alert("Cambiar rol de usuario: " + username);
        }

        // Función para editar el usuario
        function editUser(username) {
            // Aquí podrías abrir un modal o redireccionar a una vista para editar los datos del usuario
            alert("Editar usuario: " + username);
        }
    </script>
</body>
</html>
