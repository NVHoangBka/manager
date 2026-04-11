<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <div class="d-flex align-items-center justify-content-center bg-img">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card login-card rounded bg-light shadow">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h2 class="text-primary"><strong>Login Form</strong></h2>
                            </div>

                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?= $error ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?= base_url('login') ?>">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label>Username</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="user_name" class="form-control input-group-lg" required 
                                               value="<?= old('user_name') ?>">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group input-group-lg position-relative">
                                        <input type="password" name="password" class="form-control pr-5" id="password" required>

                                        <div class="position-absolute" id="togglePassword" style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer; z-index: 99;">
                                            <i class="bi bi-eye"></i>
                                        </div>  
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-lg btn-primary btn-block mt-5">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {

            let password = document.getElementById("password");

            if (password.type === "password") {
                password.type = "text";
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                password.type = "password";
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }

        });
</script>
</body>
</html>