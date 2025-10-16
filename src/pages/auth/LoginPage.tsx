import { useState, type FormEvent } from 'react';
import { useLogin } from '../../hooks/useAuth';

export default function LoginPage() {
  const loginMutation = useLogin();

  const [emailOrContact, setEmailOrContact] = useState('');
  const [password, setPassword] = useState('');
  const [validationError, setValidationError] = useState<string | null>(null);

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setValidationError(null);

    if (!emailOrContact.trim() || !password.trim()) {
      setValidationError('Por favor, preencha todos os campos');
      return;
    }

    loginMutation.mutate({ emailOrContact, password });
  };

  const errorMessage = validationError || loginMutation.error?.message;
  const successMessage = loginMutation.isSuccess ? loginMutation.data?.message : null;

  return (
    <div className="auth-container">
      <div className="auth-card">
        <div className="auth-header">
          <h1>Automo BackOffice</h1>
          <p>Faça login para acessar o sistema</p>
        </div>

        <form onSubmit={handleSubmit} className="auth-form">
          {/* Success Display */}
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
              disabled={loginMutation.isPending}
            />
          </div>

          {/* Password Field */}
          <div className="form-group">
            <label htmlFor="password" className="form-label">
              <i className="fas fa-lock"></i> Senha
            </label>
            <input
              type="password"
              id="password"
              className="form-control"
              placeholder="Digite sua senha"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              autoComplete="current-password"
              disabled={loginMutation.isPending}
            />
          </div>

          {/* Submit Button */}
          <div className="form-group">
            <button
              type="submit"
              className="btn btn-primary btn-lg btn-block"
              disabled={loginMutation.isPending}
            >
              {loginMutation.isPending ? (
                <>
                  <i className="fas fa-spinner fa-spin"></i> Autenticando...
                </>
              ) : (
                <>
                  <i className="fas fa-sign-in-alt"></i> Entrar
                </>
              )}
            </button>
          </div>

          {/* Forgot Password Link */}
          <div className="text-center">
            <a href="/forgot-password" className="link-secondary">
              <i className="fas fa-question-circle"></i> Esqueceu sua senha?
            </a>
          </div>

          {/* Security Notice */}
          <div className="text-center mt-3">
            <small className="text-muted">
              <i className="fas fa-shield-alt"></i> Acesso seguro ao sistema BackOffice
            </small>
          </div>
        </form>
      </div>
    </div>
  );
}
