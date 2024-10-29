<div class="signin col-11 col-md-9 col-lg-7 col-xl-5 mx-auto border p-4 bg-light mt-4">
  <form action="/admin/updateUser" method="post" enctype="multipart/form-data">
    <h2 class="text-success">Estàs editant l'usuari <?=$params['user']['name'];?></h2>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text"
        class="form-control" name="name" id="name" aria-describedby="helpId" value="<?= $params['user']['name'] ?>">
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Nom usuari</label>
      <input type="text"
        class="form-control" name="username" id="username" aria-describedby="helpId" value="<?= $params['user']['username'] ?>">
    </div>
    <div class="mb-3">
      <label for="pass" class="form-label">Contrasenya</label>
      <input type="password"
        class="form-control" name="pass" id="pass" aria-describedby="helpId" value="<?= $params['user']['password'] ?>">
      <small id="helpId" class="form-text text-muted">Com a mínim una minuscula, una majuscula, un nombre i un simbol</small>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Correu electrònic</label>
      <input type="mail"
        class="form-control" name="mail" id="mail" aria-describedby="helpId" value="<?= $params['user']['mail'] ?>">
    </div>
    <input type="hidden"
       name="id"  value="<?= $params['user']['id'] ?>">
    <div class="mb-3">
      <label for="name" class="form-label">Imatge de perfil: </label>
      <img src="../../../Public/Assets/user/<?= $params['user']['img_profile'];  ?>"
        class="rounded-circle mx-auto" style="width: 100px; height: 100px;" alt="imatge usuari">
      <p></p>
      <label for="name" class="form-label">Actualitzar imatge: </label>
      <input type="file"
        class="form-control" value="Actualitzar iamtge" name="img_profile" id="name" aria-describedby="helpId" placeholder="">
    </div>
    <div class="mb-3">
      <button type="submit" class="btn btn-primary">Actualitzar usuari</button>
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