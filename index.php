<?php include 'template/header.php'; ?>

<body class="login-page bg-body-secondary">
  <div class="login-box">
    <div class="login-logo">
      <img src="img/logo.jpg" alt="Logo" style="width: 50%;" />
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Dinas DKUKMP Kabupaten Tanah Datar</p>
        <form action="proses-login.php" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required />
            <div class="input-group-text"><span class="bi bi-person-fill"></span></div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required />
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
          </div>
          <div class="row">
            <div class="col-8-center">
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>