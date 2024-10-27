<div class="container mt-5">
    <h2 class="text-center mb-4">Historial de Compra</h2>
    <?php foreach ($params['history'] as $date => $products) : ?>

        <div class='card mb-3'>
            <div class='card-header bg-primary text-white'>
                Data de compra: <?= $date ?>
            </div>
            <div class='card-body'>
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Imatge</th>
                            <th>Producte</th>
                            <th>Quantitat</th>
                            <th>Preu</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalCompra = 0;
                        foreach ($products as $product) :
                            $totalItem = $product['qty'] * $product['price'];
                            $totalCompra += $totalItem; ?>

                            <tr>
                                <td><img src="../../../Public/Assets/img/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                        class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['qty'] ?></td>
                                <td><?= number_format($product['price'], 2) ?>€</td>
                                <td><?= number_format($totalItem, 2) ?>€</td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th  class='text-left'>TOTAL: <?= $totalCompra ?>€</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>