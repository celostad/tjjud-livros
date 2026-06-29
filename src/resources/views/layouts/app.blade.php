<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cadastro de Livros') | TJJUD</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- CSS customizado -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-book me-2"></i>Cadastro de Livros
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('livros.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('livros.index') }}">
                        <i class="bi bi-journals me-1"></i>Livros
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('autores.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('autores.index') }}">
                        <i class="bi bi-people me-1"></i>Autores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('assuntos.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('assuntos.index') }}">
                        <i class="bi bi-tags me-1"></i>Assuntos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('relatorio.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('relatorio.index') }}">
                        <i class="bi bi-file-earmark-bar-graph me-1"></i>Relatório
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo -->
<main class="container my-4">

    {{-- Alertas flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-light border-top py-3 mt-5">
    <div class="container text-center text-muted small">
        Cadastro de Livros &mdash; Teste Técnico TJJUD &mdash; PHP 8.3 + Laravel + MySQL 8
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
