import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import LoginPage from './pages/auth/LoginPage';
import OTPPage from './pages/auth/OTPPage';
import ForgotPasswordPage from './pages/auth/ForgotPasswordPage';
import ResetPasswordPage from './pages/auth/ResetPasswordPage';
import DashboardPage from './pages/dashboard/DashboardPage';
import ClientsPage from './pages/clients/ClientsPage';
import MessagesPage from './pages/messages/MessagesPage';
import FinancesPage from './pages/finances/FinancesPage';
import InvoicesPage from './pages/invoices/InvoicesPage';
import AccountsPage from './pages/accounts/AccountsPage';
import ProtectedRoute from './components/common/ProtectedRoute';
import { useAuthStore } from './stores/authStore';

// Create TanStack Query client
const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      refetchOnWindowFocus: false,
      retry: 1,
      staleTime: 5 * 60 * 1000, // 5 minutes
    },
  },
});

/**
 * Main App Component
 * Handles routing and navigation
 */
function App() {
  const { isAuthenticated } = useAuthStore();

  return (
    <QueryClientProvider client={queryClient}>
      <Router>
      <Routes>
        {/* Public Routes */}
        <Route
          path="/login"
          element={isAuthenticated ? <Navigate to="/dashboard" replace /> : <LoginPage />}
        />
        <Route
          path="/otp"
          element={<OTPPage />}
        />
        <Route
          path="/forgot-password"
          element={<ForgotPasswordPage />}
        />
        <Route
          path="/reset-password"
          element={<ResetPasswordPage />}
        />

        {/* Protected Routes */}
        <Route element={<ProtectedRoute />}>
          <Route path="/dashboard" element={<DashboardPage />} />
          <Route path="/clients" element={<ClientsPage />} />
          <Route path="/messages" element={<MessagesPage />} />
          <Route path="/finances" element={<FinancesPage />} />
          <Route path="/invoices" element={<InvoicesPage />} />
          <Route path="/accounts" element={<AccountsPage />} />
        </Route>

        {/* Default Route - Redirect to dashboard or login */}
        <Route
          path="/"
          element={<Navigate to={isAuthenticated ? '/dashboard' : '/login'} replace />}
        />

        {/* 404 - Not Found */}
        <Route
          path="*"
          element={
            <div style={{ textAlign: 'center', padding: '50px' }}>
              <h1>404 - Página não encontrada</h1>
              <p>A página que você está procurando não existe.</p>
              <a href="/">Voltar ao início</a>
            </div>
          }
        />
      </Routes>
    </Router>
    </QueryClientProvider>
  );
}

export default App;
