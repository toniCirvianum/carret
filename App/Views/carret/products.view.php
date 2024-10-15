
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Producto 1 -->
            <?php foreach ($params['products'] as $product): ?>
                <div class="col-md-4 flex-shrink-0">

                    <div class="card">
                        <img src="<?php echo '/Public/Assets/img/'.$product['image'] ?>" class="card-img-top img-fluid w-50 d-block mx-auto" alt="Nombre del Producto">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <p class="card-text"><?php echo number_format($product['price'], 2); ?>€</p>
                            <a href="/cart/addItemsToCart" class="btn btn-primary">Afegir</a>

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