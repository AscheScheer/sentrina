<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Selector</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .login-image {
            background-size: cover;
            background-position: center;
            min-height: 300px;
        }
        .login-button {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row login-box">
        <!-- Left side (Login Form) -->
        <div class="col-md-6 p-5 bg-white">
            <div class="text-center mb-4">
                <!-- Placeholder Icon -->
                <div class="mb-3">
                    <div style="width: 60px; height: 60px; background: #ccc;" class="mx-auto mb-2 rounded"></div>
                </div>
                <h2 class="mb-3">Selamat datang!</h2>

                <a href="/login" class="btn btn-outline-dark login-button mb-3">Masuk</a>

            </div>
        </div>

        <!-- Right side (Image) -->
        <div class="col-md-6 d-none d-md-block login-image" style="background: #ccc;">
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
