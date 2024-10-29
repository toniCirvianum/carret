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
        <h2 class="mb-4">Administració d'usuaris</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Imatge de perfil</th>
                    <th>Nom</th>
                    <th>Usuari</th>
                    <th>Password</th>
                    <th>Mail</th>
                    <th>Admin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($params['users'] as $user): ?>

                    <tr>
                        <td><img src="../../../Public/Assets/user/<?= $user['img_profile'] ?>" alt="Imagen de Perfil" class="img-thumbnail" width="50"></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['password'] ?></td>
                        <td><?= $user['mail'] ?></td>
                        <td>
                            <span class="badge bg-success"><?= $user['admin'] ? 'Admin' : '' ?></span> <!-- O bg-secondary para usuario normal -->
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <form action="/admin/changeRol" method="post">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <?php echo $user['admin'] ? "Convertir en User" : "Convertir en Admin" ?> 
                                    </button>
                                </form>
                                <form action="/admin/editUser" method="post">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Editar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
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