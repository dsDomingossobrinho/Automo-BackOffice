import { Navigate, Outlet } from 'react-router-dom';
import { useAuthStore } from '../../stores/authStore';
import type { Permission } from '../../types';

interface ProtectedRouteProps {
  requiredPermission?: Permission;
  requireAdmin?: boolean;
  children?: React.ReactNode;
}

/**
 * Protected Route Component
 * Handles authentication and authorization checks
 */
export default function ProtectedRoute({
  requiredPermission,
  requireAdmin = false,
  children,
}: Readonly<ProtectedRouteProps>) {
  const { isAuthenticated, hasPermission, isAdmin } = useAuthStore();

  // Check if user is authenticated
  if (!isAuthenticated) {
    return <Navigate to="/login" replace />;
  }

  // Check admin requirement
  if (requireAdmin && !isAdmin()) {
    return <Navigate to="/dashboard" replace />;
  }

  // Check specific permission
  if (requiredPermission && !hasPermission(requiredPermission)) {
    return <Navigate to="/dashboard" replace />;
  }

  // Render children or nested routes
  return children ? <>{children}</> : <Outlet />;
}
