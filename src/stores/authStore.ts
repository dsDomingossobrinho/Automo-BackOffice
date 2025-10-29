import { create } from "zustand";
import { persist } from "zustand/middleware";
import type { Permission, TempLogin, User } from "../types";
import { UserRole } from "../types";

/**
 * Authentication Store - Zustand
 * Simplified store for state management only
 */

interface AuthStore {
  // State
  user: User | null;
  token: string | null;
  isAuthenticated: boolean;
  error: string | null;
  tempLogin: TempLogin | null;
  tempForgotPassword: TempLogin | null;

  // State setters
  setUser: (user: User | null) => void;
  setToken: (token: string | null) => void;
  setAuthenticated: (isAuthenticated: boolean) => void;
  setError: (error: string | null) => void;
  clearError: () => void;
  setTempLogin: (tempLogin: TempLogin | null) => void;
  setTempForgotPassword: (tempForgotPassword: TempLogin | null) => void;

  // Auth actions
  logout: () => void;

  // User info getters
  getUser: () => User | null;
  getToken: () => string | null;
  getUserName: () => string | undefined;
  getUserEmail: () => string | undefined;
  getUserImage: () => string | undefined;

  // Permission methods
  hasRole: (roleId: UserRole) => boolean;
  isAdmin: () => boolean;
  isBackOffice: () => boolean;
  getPermissions: () => Permission[];
  hasPermission: (permission: Permission) => boolean;
}

export const useAuthStore = create<AuthStore>()(
  persist(
    (set, get) => ({
      // Initial State
      user: null,
      token: null,
      isAuthenticated: false,
      error: null,
      tempLogin: null,
      tempForgotPassword: null,

      // State setters
      setUser: (user) => set({ user }),
      setToken: (token) => set({ token }),
      setAuthenticated: (isAuthenticated) => set({ isAuthenticated }),
      setError: (error) => set({ error }),
      clearError: () => set({ error: null }),
      setTempLogin: (tempLogin) => set({ tempLogin }),
      setTempForgotPassword: (tempForgotPassword) =>
        set({ tempForgotPassword }),

      // Logout
      logout: () => {
        set({
          user: null,
          token: null,
          isAuthenticated: false,
          tempLogin: null,
          tempForgotPassword: null,
          error: null,
        });
        localStorage.removeItem("auth-storage");
      },

      // Get User
      getUser: () => {
        return get().user;
      },

      // Get Token
      getToken: () => {
        return get().token;
      },

      // Get User Name
      getUserName: () => {
        return get().user?.name;
      },

      // Get User Email
      getUserEmail: () => {
        return get().user?.email;
      },

      // Get User Image
      getUserImage: () => {
        return get().user?.img;
      },

      // Has Role
      hasRole: (roleId: UserRole) => {
        const user = get().user;
        if (!user || !user.allRoleIds) return false;
        return user.allRoleIds.includes(roleId);
      },

      // Is Admin
      isAdmin: () => {
        return get().hasRole(UserRole.Admin);
      },

      // Is Back Office
      isBackOffice: () => {
        const user = get().user;
        return user?.isBackOffice || false;
      },

      // Get Permissions
      getPermissions: () => {
        const user = get().user;
        if (!user) return [];

        const permissions: Permission[] = [];
        const roles = user.allRoleIds || [];

        roles.forEach((roleId) => {
          switch (roleId) {
            case UserRole.Admin:
              permissions.push(
                "view_all",
                "create_all",
                "edit_all",
                "delete_all",
                "view_accounts",
                "create_accounts",
                "edit_accounts",
                "delete_accounts",
                "manage_users",
                "manage_permissions",
                "view_clients",
                "create_clients",
                "edit_clients",
                "delete_clients",
                "view_messages",
                "create_messages",
                "edit_messages",
                "delete_messages",
                "send_messages",
                "view_finances",
                "create_finances",
                "edit_finances",
                "delete_finances",
                "view_invoices",
                "create_invoices",
                "edit_invoices",
                "delete_invoices",
                "view_reports",
                "view_analytics",
                "export_data",
              );
              break;

            case UserRole.User:
              permissions.push(
                "view_own",
                "create_basic",
                "edit_own",
                "view_clients",
                "view_messages",
              );
              break;

            case UserRole.Agent:
              permissions.push(
                "view_clients",
                "create_clients",
                "edit_clients",
                "view_messages",
                "create_messages",
                "send_messages",
                "view_own",
                "edit_own",
              );
              break;

            case UserRole.Manager:
              permissions.push(
                "view_team",
                "manage_team",
                "view_reports",
                "view_clients",
                "view_messages",
                "view_finances",
                "view_accounts",
                "view_analytics",
              );
              break;
          }
        });

        return Array.from(new Set(permissions));
      },

      // Has Permission
      hasPermission: (permission: Permission) => {
        return get().getPermissions().includes(permission);
      },
    }),
    {
      name: "auth-storage",
      partialize: (state) => ({
        user: state.user,
        token: state.token,
        isAuthenticated: state.isAuthenticated,
        tempLogin: state.tempLogin,
        tempForgotPassword: state.tempForgotPassword,
      }),
    },
  ),
);
