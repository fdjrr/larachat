<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>

    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">

    @vite(['resources/css/app.css'])
</head>

<body class=" d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="/" class="navbar-brand navbar-brand-autodark"><img src="{{ asset('logo.svg') }}" height="36" alt=""></a>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login to your account</h2>
                    <form id="formLogin" novalidate>
                        <div class="mb-3">
                            <label class="form-label required">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="your@email.com" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"> Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Your password" autocomplete="off" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" checked />
                                <span class="form-check-label">Remember me on this device</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Libs JS -->

    <!-- Tabler Core -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    @vite(['resources/js/app.js'])
</body>

</html>