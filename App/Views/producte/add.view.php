<div class="signin col-11 col-md-9 col-lg-7 col-xl-5 mx-auto border p-4 bg-light mt-4">
  <form action="/producte/addProducte" method="post" enctype="multipart/form-data">
    <h2 class="text-success">Afegir producte</h2>
    <div class="mb-3">
      <label for="name" class="form-label">Nom</label>
      <input type="text"
        class="form-control" name="name" id="name" aria-describedby="helpId" >
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Descripció</label>
      <input type="text"
        class="form-control" name="description" id="username" aria-describedby="helpId" >
    </div>
    <div class="mb-3">
      <label for="pass" class="form-label">Preu</label>
      <input type="number"
        class="form-control" name="price" id="pass" aria-describedby="helpId" >
      <small id="helpId" class="form-text text-muted">Els decimals s'introdueixen amb el punt</small>
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Imatge de producte: </label>
      <input type="file"
        class="form-control" value="Actualitzar iamtge" name="img_product" id="name" aria-describedby="helpId" required>
    </div>
    <div class="mb-3">
      <button type="submit" class="btn btn-primary">Afegir</button>
    </div>
    <div class="mb-3">
      <?php if (isset($params['error']) && !empty($params['error'])): ?>
        <div class="alert alert-danger text-center  w-auto mx-auto" role="alert">
          <?php echo $params['error']; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <?php if (isset($params['message']) && !empty($params['message'])): ?>
        <div class="alert alert-success text-center  w-auto mx-auto" role="success">
          <?php echo $params['message']; ?>
        </div>
      <?php endif; ?>
    </div>

  </form>
</div>