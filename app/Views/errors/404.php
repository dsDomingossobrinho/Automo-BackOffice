<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card text-center">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                <h1 class="h2 text-dark mb-3">404 - Página Não Encontrada</h1>
                <p class="text-muted mb-4">
                    A página que você está procurando não existe ou foi movida.
                </p>
            </div>
            
            <div class="d-flex flex-column gap-2">
                <a href="<?= url('/dashboard') ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i> Voltar ao Dashboard
                </a>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Página Anterior
                </a>
            </div>
            
            <hr>
            
            <small class="text-muted">
                Se você acredita que isto é um erro, entre em contacto com o administrador.
            </small>
        </div>
    </div>
</body>
</html>