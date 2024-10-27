<style>
    .qty-display {
        font-size: 20px;
        /* Tamaño de letra más grande */
        font-weight: bold;
        width: 40px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px;
        margin: 0 10px;
        /* Espacio entre el número y los botones */
    }
</style>
<div class="container mt-5 col-md-8 col-lg-6">
    
    <?php
    if (isset($params['message']) && !empty($params['message'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="autoCloseAlert">';
        echo $params['message'];
        echo '</div>';
    }
    ?>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Resum del carret</h2>
        <a href="/cart/validateCarret" class="btn btn-success">Validar carret</a>
    </div>
    <hr>

    <?php if (isset($params['cart']) && !empty($params['cart'])): ?>
        <div class="list-group">
            <?php foreach ($params['cart'] as $id => $product): ?>
                <?php $subtotal = $product['price'] * $product['qty']; ?>
                <div class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- Imatge del producte -->
                        <img src="../../../Public/Assets/img/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-thumbnail" style="width: 50px; height: 50px;">
                        <!-- Nom del producte -->
                        <div class="ms-3">
                            <h5 class="mb-0"><?= htmlspecialchars($product['name']) ?></h5>
                            <small class="text-muted"><?= number_format($product['price'], 2) ?>€</small>
                        </div>
                    </div>
                    <!-- Quantitat i controls -->
                    <div class="d-flex align-items-center">

                        <form action="/cart/updateCarret" method="post">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input class="btn btn-outline-secondary btn-sm me-2" type="submit" name="add" value="+">
                            <span class="qty-display"> &nbsp<?= $product['qty'] ?> &nbsp</span>
                            <input class="btn btn-outline-secondary btn-sm me-2" type="submit" name="remove" value="-">
                        </form>
                    </div>
                    <!-- Subtotal del producte -->

                    <div class="ms-3">
                        <span><?= number_format($subtotal, 2) ?>€</span>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <hr>
        <h3 class="text-center text-bg-info p-3">
            -- El carret està buit --
        </h3>
    <?php endif; ?>

    <!-- Total del carrito -->
    <div class="mt-4">
        <hr>
        <h4>Total: <?= number_format($params['cart_total'], 2) ?>€</h4>
    </div>




</div>