<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acesso Negado - <?= APP_NAME ?? 'Automo BackOffice' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= ASSETS_URL ?? '/assets' ?>/images/automo-logo.png">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?? '/assets' ?>/css/modern-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            font-family: 'Inter', sans-serif;
        }
        
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            text-align: center;
            max-width: 500px;
            margin: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .error-icon {
            font-size: 4rem;
            color: #dc2626;
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        
        .error-subtitle {
            font-size: 1.125rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .error-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .btn-error {
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #1e3a8a);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: rgba(107, 114, 128, 0.1);
            color: #374151;
            border: 1px solid rgba(107, 114, 128, 0.3);
        }
        
        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2);
            transform: translateY(-1px);
        }
        
        .error-footer {
            padding-top: 1.5rem;
            border-top: 1px solid rgba(107, 114, 128, 0.2);
            font-size: 0.875rem;
            color: #9ca3af;
        }
        
        .logo-container {
            margin-bottom: 2rem;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        @media (max-width: 768px) {
            .error-card {
                margin: 1rem;
                padding: 2rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="logo-container">
                <img src="<?= ASSETS_URL ?? '/assets' ?>/images/automo-logo.png" alt="Automo Logo" class="logo">
            </div>
            
            <div class="error-icon">
                <i class="fas fa-ban"></i>
            </div>
            
            <h1 class="error-title">403</h1>
            <p class="error-subtitle">
                Acesso Negado
            </p>
            <p class="error-subtitle" style="font-size: 1rem; margin-bottom: 2.5rem;">
                Você não tem permissão para acessar esta página ou recurso. Contacte o administrador se necessário.
            </p>
            
            <div class="error-buttons">
                <a href="<?= BASE_URL ?? '' ?>/dashboard" class="btn-error btn-primary">
                    <i class="fas fa-home"></i>
                    Voltar ao Dashboard
                </a>
                <a href="<?= BASE_URL ?? '' ?>/login" class="btn-error btn-secondary">
                    <i class="fas fa-sign-in-alt"></i>
                    Fazer Login
                </a>
            </div>
            
            <div class="error-footer">
                <p>Verifique suas credenciais ou contacte o administrador do sistema.</p>
                <p style="margin-top: 0.5rem;">
                    <strong>Código:</strong> 403 | <strong>Timestamp:</strong> <?= date('d/m/Y H:i:s') ?>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const icon = document.querySelector('.error-icon');
            if (icon) {
                icon.addEventListener('mouseenter', function() {
                    this.style.animation = 'none';
                    this.style.transform = 'scale(1.3) rotate(-5deg)';
                    this.style.color = '#991b1b';
                });
                
                icon.addEventListener('mouseleave', function() {
                    this.style.animation = 'bounce 2s infinite';
                    this.style.transform = 'scale(1)';
                    this.style.color = '#dc2626';
                });
            }
            
            const primaryBtn = document.querySelector('.btn-primary');
            if (primaryBtn) {
                primaryBtn.focus();
            }
        });
    </script>
</body>
</html>