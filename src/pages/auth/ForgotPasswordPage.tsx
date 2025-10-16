import { useState, type FormEvent } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuthStore } from '../../stores/authStore';

/**
 * Forgot Password Page Component
 * Request password reset OTP
 */
export default function ForgotPasswordPage() {
  const navigate = useNavigate();
  const { forgotPassword, isLoading, error, clearError } = useAuthStore();

  const [emailOrContact, setEmailOrContact] = useState('');
  const [localError, setLocalError] = useState<string | null>(null);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setLocalError(null);
    setSuccessMessage(null);
    clearError();

    // Basic validation
    if (!emailOrContact.trim()) {
      setLocalError('Por favor, digite seu email ou contacto');
      return;
    }

    try {
      const response = await forgotPassword(emailOrContact);

      if (response.success) {
        setSuccessMessage(response.message);
        // Navigate to reset password page after 2 seconds
        setTimeout(() => {
          navigate('/reset-password');
        }, 2000);
      } else {
        setLocalError(response.message);
      }
    } catch (err: any) {
      setLocalError(err.message || 'Erro ao solicitar recuperação de senha');
    }
  };

  return (
    <div className="auth-container">
      <div className="auth-card">
        <div className="auth-header">
          <h1>Recuperar Senha</h1>
          <p>Digite seu email ou contacto para receber o código de recuperação</p>
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

          {/* Email/Contact Field */}
          <div className="form-group">
            <label htmlFor="email" className="form-label">
              <i className="fas fa-envelope"></i> Email ou Contacto
            </label>
            <input
              type="text"
              id="email"
              className="form-control"
              placeholder="Digite seu email ou contacto"
              value={emailOrContact}
              onChange={(e) => setEmailOrContact(e.target.value)}
              required
              autoComplete="email"
              autoFocus
              disabled={isLoading || !!successMessage}
            />
          </div>

          {/* Submit Button */}
          <div className="form-group">
            <button
              type="submit"
              className="btn btn-primary btn-lg btn-block"
              disabled={isLoading || !!successMessage}
            >
              {isLoading ? (
                <>
                  <i className="fas fa-spinner fa-spin"></i> Enviando...
                </>
              ) : successMessage ? (
                <>
                  <i className="fas fa-check-circle"></i> Código Enviado
                </>
              ) : (
                <>
                  <i className="fas fa-paper-plane"></i> Enviar Código
                </>
              )}
            </button>
          </div>

          {/* Back to Login */}
          <div className="text-center">
            <a href="/login" className="link-secondary">
              <i className="fas fa-arrow-left"></i> Voltar ao login
            </a>
          </div>

          {/* Info Notice */}
          <div className="text-center mt-3">
            <small className="text-muted">
              <i className="fas fa-info-circle"></i>
              Você receberá um código de 6 dígitos por email ou SMS
            </small>
          </div>
        </form>
      </div>
    </div>
  );
}
