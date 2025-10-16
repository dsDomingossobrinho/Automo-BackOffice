import { useState, type FormEvent, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuthStore } from '../../stores/authStore';
import { useVerifyOtp } from '../../hooks/useAuth';

/**
 * OTP Verification Page Component
 * Migrated from PHP app/Views/auth/otp.php
 * Now using React Query mutation for better state management
 */
export default function OTPPage() {
  const navigate = useNavigate();
  const tempLogin = useAuthStore((state) => state.tempLogin);
  const verifyOtpMutation = useVerifyOtp();

  const [otpCode, setOtpCode] = useState('');
  const [validationError, setValidationError] = useState<string | null>(null);

  // Redirect if no temp login (with delay to allow state to load from storage)
  useEffect(() => {
    const timer = setTimeout(() => {
      if (!tempLogin) {
        console.log('No tempLogin found, redirecting to login');
        navigate('/login');
      }
    }, 100); // Small delay to allow Zustand persist to restore state

    return () => clearTimeout(timer);
  }, [tempLogin, navigate]);

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setValidationError(null);

    // Basic validation
    if (!otpCode.trim()) {
      setValidationError('Por favor, digite o código OTP');
      return;
    }

    if (otpCode.length !== 6) {
      setValidationError('O código OTP deve ter 6 dígitos');
      return;
    }

    verifyOtpMutation.mutate(otpCode);
  };

  const handleBackToLogin = () => {
    navigate('/login');
  };

  const errorMessage = validationError || verifyOtpMutation.error?.message;
  const successMessage = verifyOtpMutation.isSuccess ? verifyOtpMutation.data?.message : null;

  return (
    <div className="auth-container">
      <div className="auth-card">
        <div className="auth-header">
          <h1>Verificação OTP</h1>
          <p>Digite o código de 6 dígitos enviado para seu email/SMS</p>
        </div>

        <form onSubmit={handleSubmit} className="auth-form">
          {/* Success Message */}
          {successMessage && (
            <div className="alert alert-success">
              <i className="fas fa-check-circle"></i>
              {successMessage}
            </div>
          )}

          {/* Error Display */}
          {errorMessage && (
            <div className="alert alert-error">
              <i className="fas fa-exclamation-circle"></i>
              {errorMessage}
            </div>
          )}

          {/* Info Message */}
          {!successMessage && (
            <div className="alert alert-info">
              <i className="fas fa-info-circle"></i>
              Um código de verificação foi enviado para <strong>{tempLogin?.emailOrContact}</strong>
            </div>
          )}

          {/* OTP Code Field */}
          <div className="form-group">
            <label htmlFor="otp" className="form-label">
              <i className="fas fa-key"></i> Código OTP
            </label>
            <input
              type="text"
              id="otp"
              className="form-control otp-input"
              placeholder="000000"
              value={otpCode}
              onChange={(e) => setOtpCode(e.target.value.replace(/\D/g, '').slice(0, 6))}
              required
              maxLength={6}
              autoFocus
              disabled={verifyOtpMutation.isPending}
              style={{ textAlign: 'center', fontSize: '24px', letterSpacing: '8px' }}
            />
            <small className="form-text text-muted">
              Digite o código de 6 dígitos
            </small>
          </div>

          {/* Submit Button */}
          <div className="form-group">
            <button
              type="submit"
              className="btn btn-primary btn-lg btn-block"
              disabled={verifyOtpMutation.isPending || otpCode.length !== 6}
            >
              {verifyOtpMutation.isPending ? (
                <>
                  <i className="fas fa-spinner fa-spin"></i> Verificando...
                </>
              ) : (
                <>
                  <i className="fas fa-check-circle"></i> Verificar Código
                </>
              )}
            </button>
          </div>

          {/* Resend OTP */}
          <div className="text-center">
            <p className="text-muted mb-2">Não recebeu o código?</p>
            <button
              type="button"
              className="btn btn-link"
              onClick={handleBackToLogin}
              disabled={verifyOtpMutation.isPending}
            >
              <i className="fas fa-arrow-left"></i> Voltar ao Login
            </button>
          </div>

          {/* Security Notice */}
          <div className="text-center mt-3">
            <small className="text-muted">
              <i className="fas fa-clock"></i>
              O código expira em 5 minutos
            </small>
          </div>
        </form>
      </div>
    </div>
  );
}
