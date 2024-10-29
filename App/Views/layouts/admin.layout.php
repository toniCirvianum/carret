<!doctype html>
<html lang="en">

<head>
    <title><?php echo $params['title'] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-image: url('../../../Public/Assets/home/fons.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
    <script>
        // Per amagar l'alerta passats 5 segons
        setTimeout(function() {
            var alertElement = document.getElementById('autoCloseAlert');
            if (alertElement) {
                var alert = new bootstrap.Alert(alertElement);
                alert.close(); // Tanca l'alerta
            }
        }, 5000); // 5000 ms = 5 segons
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="btn btn-primary me-2" href="/cart/index">Inici</a> </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary me-2" href="/cart/showCarret"> Veure Carret &nbsp
                                <!-- Mostrar el número de items en el carrito -->
                                <span class="badge bg-warning">
                                    <?php echo isset($params['cart_items']) && !empty($params['cart_items']) ? $params['cart_items'] : 0; ?></span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="btn btn-outline-primary me-2" href="/cart/history">Veure Historic</a></li>
                        <li class="nav-item"><a class="btn btn-outline-primary me-2" href="/producte/index">Afegir Productes</a></li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="btn btn-outline-info me-2" href="/admin/list"> Editar Usuaris</a>
                        </li>

                        <li class="nav-item"><a class="btn btn-primary mx.-auto" href="/user/logout">Logout</a></li>
                        <li class="nav-item ms-2">
                            <a href="/user/edit">
                                <img src="../../../Public/Assets/user/<?= $params['user_image'];  ?>"
                                    class="rounded-circle" style="width: 40px; height: 40px;" alt="imatge usuari">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main style="padding-top: 70px; ">
        <div class="container mt-5">
            <?php echo $params['content'] ?>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>