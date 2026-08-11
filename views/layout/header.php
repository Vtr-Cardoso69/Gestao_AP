<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suítes Românticas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff8f2; color: #4b2c20; }
        .navbar { background: #8b5e5a; }
        .navbar-brand, .nav-link, .form-control, .form-select { color: #f5f0ec !important; }
        .form-control, .form-select { background: #fffdf9; color: #4b2c20 !important; border: 1px solid #cdaea4; }
        .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.2rem rgba(182,111,96,0.25); }
        .card { border: 0; border-radius: 20px; box-shadow: 0 10px 30px rgba(139,94,90,0.15); }
        .table thead { background: #f7e6de; }
        .btn-primary { background: #b66f60; border-color: #b66f60; }
        .btn-primary:hover { background: #9d5a4c; }
        .page-title { letter-spacing: 0.05em; }
    </style>
</head>
<body>
<nav class="navbar-expand-lg navbar-dark">
    <div class="container-fluid" style='padding: 30px 30px; width: 100%; display: flex;
align-items: center; justify-content: space-between; background: linear-gradient(135deg, #4d1c46 0%, #7c1234 100%);'>
        <a style="font-weight: bold; font-size: 40px;" class="navbar-brand" href="index.php">Motel: Você ki sabe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Alternar navegação">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav" style="margin-left: 80px;">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="display: flex; gap: 20px;">
                <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=suites">Suítes</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=hospedes">Hóspedes</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=ocorrencias">Ocorrências</a></li>
            </ul>
           
           <!-- busca -->
           
            <form class="d-flex" role="search" action="index.php" method="get">
                <input type="hidden" name="page" value="busca">
                <input type="hidden" name="scope" value="<?php echo htmlspecialchars($_GET['page'] ?? 'all'); ?>">
                <input class="form-control me-2" type="search" name="term" placeholder="Buscar CPF, telefone, suíte ou título" aria-label="Buscar">
                <button class="btn btn-outline-light" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>
<main class="container py-4">
