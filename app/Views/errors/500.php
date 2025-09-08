<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erro Interno - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card text-center">
            <div class="mb-4">
                <i class="fas fa-bug fa-4x text-danger mb-3"></i>
                <h1 class="h2 text-dark mb-3">500 - Erro Interno do Servidor</h1>
                <p class="text-muted mb-4">
                    Ocorreu um erro interno no servidor. Nossa equipe foi notificada automaticamente.
                </p>
            </div>
            
            <div class="d-flex flex-column gap-2">
                <a href="<?= url('/dashboard') ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i> Voltar ao Dashboard
                </a>
                <button onclick="location.reload()" class="btn btn-secondary">
                    <i class="fas fa-refresh"></i> Tentar Novamente
                </button>
            </div>
            
            <hr>
            
            <small class="text-muted">
                Erro ID: <?= uniqid() ?><br>
                Timestamp: <?= date('d/m/Y H:i:s') ?>
            </small>
        </div>
    </div>
</body>
</html>