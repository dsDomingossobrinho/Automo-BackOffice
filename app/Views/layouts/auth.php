<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $csrf_token ?>">
    <title><?= $title ?? APP_NAME ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-car"></i> Automo</h1>
                <p>BackOffice - Sistema de Gestão</p>
            </div>
            
            <!-- Flash Messages -->
            <?php if (!empty($flash_messages)): ?>
                <?php foreach ($flash_messages as $type => $messages): ?>
                    <?php if (is_array($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="alert alert-<?= $type === 'errors' ? 'danger' : $type ?>">
                                <?= e($message) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-<?= $type === 'errors' ? 'danger' : $type ?>">
                            <?= e($messages) ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <!-- Page Content -->
            <?= $content ?>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>