<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.4.0
* @link https://tabler.io
* Copyright 2018-2026 The Tabler Authors
* Copyright 2018-2026 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Login — Kerjao</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" rel="stylesheet"/>
    <style>@import url('https://rsms.me/inter/inter.css');</style>
</head>
<body class="d-flex flex-column">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler-theme.min.js"></script>

    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <span class="navbar-brand navbar-brand-autodark">
                    <span class="fw-bold fs-2 text-primary">Kerjao</span>
                </span>
            </div>

            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Masuk ke akun Anda</h2>

                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@email.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" id="password" name="password" required
                                    class="form-control" placeholder="Password">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input"/>
                                <span class="form-check-label">Ingat saya</span>
                            </label>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center text-secondary mt-3">
                <small>Work Program Management System</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js" defer></script>
</body>
</html>
