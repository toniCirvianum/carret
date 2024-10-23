<body>
    <style>
        .card-img-top {
            height: 200px;
            width: 200px;
            /* object-fit: cover; */
        }

        .error-message {
            position: absolute;
            /* Flota sobre el contenido de la tarjeta */
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            /* Asegura que el mensaje esté por encima de otros elementos */
            width: 80%;
            /* Ajusta el ancho según el diseño */
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <!-- Tarjeta de producte -->
            <?php foreach ($params['products'] as $product): ?>
                <div class="col-md-4 flex-shrink-0">
                    <div class="card">
                        <img src="<?php echo '/Public/Assets/img/' . $product['image'] ?>" class="card-img-top img-fluid w-50 d-block mx-auto" alt="Nombre del Producto">
                        <div class="card-body">
                            <form action="/cart/addItemsToCart" method="post">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text"><?php echo $product['description']; ?></p>
                                <p class="card-text"><?php echo number_format($product['price'], 2); ?>€</p>
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <input type="submit" value="Afegir" class="btn btn-primary">
                                <div class="mb-3">
                                    <p> </p>
                                    <?php
                                    if (isset($params['prod_id']) && $params['prod_id'] == $product['id'])
                                        if (isset($params['error']) && !empty($params['error'])) {
                                            echo '<div class="alert alert-danger alert-dismissible fade show error-message">';
                                            echo $params['error'];
                                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>

                            </form>


                        </div>
                    </div>
                    <p> </p>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>