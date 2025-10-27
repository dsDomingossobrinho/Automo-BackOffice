import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ThemeProvider } from "next-themes";
import {
  Navigate,
  Route,
  BrowserRouter as Router,
  Routes,
} from "react-router-dom";
import { NotFoundError } from "./components/common/not-found-error";
import ProtectedRoute from "./components/common/protected-route";
import MainLayout from "./components/layout";
import { Toaster } from "./components/ui/sonner";
import AccountsPage from "./pages/accounts";
import AgentPage from "./pages/agent";
import ForgotPasswordPage from "./pages/auth/forgot-password";
import LoginPage from "./pages/auth/login";
import OTPPage from "./pages/auth/otp";
import ResetPasswordPage from "./pages/auth/reset-password";
import ClientsPage from "./pages/clients";
import DashboardPage from "./pages/dashboard";
import FinancesPage from "./pages/finances";
import AccountTypesPage from "./pages/parameters/account-types";
import CountriesPage from "./pages/parameters/countries";
import PlansPage from "./pages/parameters/plans";
import PromotionsPage from "./pages/parameters/promotions";
import ProvincesPage from "./pages/parameters/provinces";
import RolesPage from "./pages/parameters/roles";
import StatesPage from "./pages/parameters/states";
import { useAuthStore } from "./stores/authStore";

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

function App() {
  const { isAuthenticated } = useAuthStore();

  return (
    <ThemeProvider attribute="class" defaultTheme="system" enableSystem>
      <QueryClientProvider client={queryClient}>
        <Router>
          <Routes>
            {/* Public Routes */}
            <Route
              path="/login"
              element={
                isAuthenticated ? (
                  <Navigate to="/dashboard" replace />
                ) : (
                  <LoginPage />
                )
              }
            />
            <Route path="/otp" element={<OTPPage />} />
            <Route path="/forgot-password" element={<ForgotPasswordPage />} />
            <Route path="/reset-password" element={<ResetPasswordPage />} />

            {/* Protected Routes */}
            <Route
              element={
                <ProtectedRoute>
                  <MainLayout />
                </ProtectedRoute>
              }
            >
              <Route path="/dashboard" element={<DashboardPage />} />
              <Route path="/clients" element={<ClientsPage />} />
              <Route path="/agent" element={<AgentPage />} />
              <Route path="/finances" element={<FinancesPage />} />
              <Route path="/accounts" element={<AccountsPage />} />
              <Route path="/parameters">
                <Route path="roles" element={<RolesPage />} />
                <Route path="accounts-type" element={<AccountTypesPage />} />
                <Route path="countries" element={<CountriesPage />} />
                <Route path="provinces" element={<ProvincesPage />} />
                <Route path="states" element={<StatesPage />} />
                <Route path="plans" element={<PlansPage />} />
                <Route path="promotions" element={<PromotionsPage />} />
              </Route>
            </Route>

            {/* Default Route - Redirect to dashboard or login */}
            <Route
              path="/"
              element={
                <Navigate
                  to={isAuthenticated ? "/dashboard" : "/login"}
                  replace
                />
              }
            />

            <Route path="*" element={<NotFoundError />} />
          </Routes>
        </Router>
        <Toaster richColors />
      </QueryClientProvider>
    </ThemeProvider>
  );
}

export default App;
