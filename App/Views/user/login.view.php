<div class="signin col-11 col-md-9 col-lg-7 col-xl-5 mx-auto border p-4 bg-light mt-4">
    <form action="/user/login" method="post">
        <h2 class="text-success">Login</h2>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="helpId" placeholder="">
            <small id="helpId" class="form-text text-muted">Help text</small>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Password</label>
            <input type="text" class="form-control" name="pass" id="pass" aria-describedby="helpId" placeholder="">
            <small id="helpId" class="form-text text-muted">Help text</small>
        </div>

        <button type="submit" class="btn btn-primary">Entra</button>
        <div class="mb-3">
            <p>
                No tens compte?
                <a href="/user/create" class="btn btn-outline-primary">Crea nou usuari</a>
            </p>
        </div>
        <div class="mb-3">
            <?php if (isset($params['error']) && !empty($params['error'])): ?>
                <div class="alert alert-danger text-center  w-auto mx-auto" role="alert">
                    <?php echo $params['error']; ?>
                </div>
            <?php endif; ?>
        </div>

    </form>
</div>