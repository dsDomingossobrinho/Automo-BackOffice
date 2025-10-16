import { useState, type FormEvent, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuthStore } from '../../stores/authStore';

/**
 * Reset Password Page Component
 * Verify OTP and set new password
 */
export default function ResetPasswordPage() {
  const navigate = useNavigate();
  const { resetPassword, tempForgotPassword, isLoading, error, clearError } = useAuthStore();

  const [otpCode, setOtpCode] = useState('');
  const [newPassword, setNewPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [localError, setLocalError] = useState<string | null>(null);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);

  // Redirect if no temp forgot password
  useEffect(() => {
    if (!tempForgotPassword) {
      navigate('/forgot-password');
    }
  }, [tempForgotPassword, navigate]);

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setLocalError(null);
    setSuccessMessage(null);
    clearError();

    // Basic validation
    if (!otpCode.trim()) {
      setLocalError('Por favor, digite o código OTP');
      return;
    }

    if (otpCode.length !== 6) {
      setLocalError('O código OTP deve ter 6 dígitos');
      return;
    }

    if (!newPassword.trim()) {
      setLocalError('Por favor, digite a nova senha');
      return;
    }

    if (newPassword.length < 6) {
      setLocalError('A senha deve ter pelo menos 6 caracteres');
      return;
    }

    if (newPassword !== confirmPassword) {
      setLocalError('As senhas não coincidem');
      return;
    }

    try {
      const response = await resetPassword(otpCode, newPassword, confirmPassword);

      if (response.success) {
        setSuccessMessage(response.message);
        // Navigate to login after 2 seconds
        setTimeout(() => {
          navigate('/login');
        }, 2000);
      } else {
        setLocalError(response.message);
      }
    } catch (err: any) {
      setLocalError(err.message || 'Erro ao redefinir senha');
    }
  };

  return (
    <div className="auth-container">
      <div className="auth-card">
        <div className="auth-header">
          <h1>Redefinir Senha</h1>
          <p>Digite o código recebido e sua nova senha</p>
        </div>

        <form onSubmit={handleSubmit} className="auth-form">
          {/* Error Display */}
          {(localError || error) && (
            <div className="alert alert-error">
              <i className="fas fa-exclamation-circle"></i>
              {localError || error}
            </div>
          )}

          {/* Success Message */}
          {successMessage && (
            <div className="alert alert-success">
              <i className="fas fa-check-circle"></i>
              {successMessage}
            </div>
          )}

          {/* Info Message */}
          <div className="alert alert-info">
            <i className="fas fa-info-circle"></i>
            Código enviado para <strong>{tempForgotPassword?.emailOrContact}</strong>
          </div>

          {/* OTP Code Field */}
          <div className="form-group">
            <label htmlFor="otp" className="form-label">
              <i className="fas fa-key"></i> Código OTP
            </label>
            <input
              type="text"
              id="otp"
              className="form-control"
              placeholder="000000"
              value={otpCode}
              onChange={(e) => setOtpCode(e.target.value.replace(/\D/g, '').slice(0, 6))}
              required
              maxLength={6}
              autoFocus
              disabled={isLoading || !!successMessage}
              style={{ textAlign: 'center', fontSize: '20px', letterSpacing: '6px' }}
            />
          </div>

          {/* New Password Field */}
          <div className="form-group">
            <label htmlFor="newPassword" className="form-label">
              <i className="fas fa-lock"></i> Nova Senha
            </label>
            <div style={{ position: 'relative' }}>
              <input
                type={showPassword ? 'text' : 'password'}
                id="newPassword"
                className="form-control"
                placeholder="Digite sua nova senha"
                value={newPassword}
                onChange={(e) => setNewPassword(e.target.value)}
                required
                disabled={isLoading || !!successMessage}
                style={{ paddingRight: '45px' }}
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                style={{
                  position: 'absolute',
                  right: '12px',
                  top: '50%',
                  transform: 'translateY(-50%)',
                  background: 'none',
                  border: 'none',
                  cursor: 'pointer',
                  color: '#6c757d',
                }}
                disabled={isLoading || !!successMessage}
              >
                <i className={showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'}></i>
              </button>
            </div>
            <small className="form-text text-muted">
              Mínimo de 6 caracteres
            </small>
          </div>

          {/* Confirm Password Field */}
          <div className="form-group">
            <label htmlFor="confirmPassword" className="form-label">
              <i className="fas fa-lock"></i> Confirmar Senha
            </label>
            <input
              type={showPassword ? 'text' : 'password'}
              id="confirmPassword"
              className="form-control"
              placeholder="Confirme sua nova senha"
              value={confirmPassword}
              onChange={(e) => setConfirmPassword(e.target.value)}
              required
              disabled={isLoading || !!successMessage}
            />
          </div>

          {/* Submit Button */}
          <div className="form-group">
            <button
              type="submit"
              className="btn btn-primary btn-lg btn-block"
              disabled={isLoading || !!successMessage || otpCode.length !== 6}
            >
              {isLoading ? (
                <>
                  <i className="fas fa-spinner fa-spin"></i> Redefinindo...
                </>
              ) : successMessage ? (
                <>
                  <i className="fas fa-check-circle"></i> Senha Redefinida
                </>
              ) : (
                <>
                  <i className="fas fa-check"></i> Redefinir Senha
                </>
              )}
            </button>
          </div>

          {/* Back Link */}
          <div className="text-center">
            <a href="/forgot-password" className="link-secondary">
              <i className="fas fa-arrow-left"></i> Voltar
            </a>
          </div>

          {/* Security Notice */}
          <div className="text-center mt-3">
            <small className="text-muted">
              <i className="fas fa-clock"></i>
              O código expira em 15 minutos
            </small>
          </div>
        </form>
      </div>
    </div>
  );
}
