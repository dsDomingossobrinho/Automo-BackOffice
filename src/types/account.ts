// Account related types
import type { Permission } from './user';

export interface Account {
  id: string;
  email: string;
  username?: string;
  name: string;
  contact?: string;
  img?: string;
  accountTypeId?: number;
  status: AccountStatus;
  lastLogin?: string;
  createdAt: string;
  updatedAt?: string;
}

export const AccountStatus = {
  Active: 'active',
  Inactive: 'inactive',
  Suspended: 'suspended',
  Pending: 'pending',
} as const;

export type AccountStatus = typeof AccountStatus[keyof typeof AccountStatus];

export const AccountRole = {
  Admin: 1,
  User: 2,
  Agent: 3,
  Manager: 4,
} as const;

export type AccountRole = typeof AccountRole[keyof typeof AccountRole];

export const RoleLabels: Record<number, string> = {
  1: 'Administrador',
  2: 'Utilizador',
  3: 'Agente',
  4: 'Gestor',
};

export interface CreateAccountData {
  email: string;
  username: string;
  password: string;
  name: string;
  contact?: string;
  accountTypeId?: number;
}

export interface UpdateAccountData extends Partial<Omit<CreateAccountData, 'password'>> {
  id: string;
  status?: AccountStatus;
  password?: string; // Optional for password change
}

export interface AccountFilters {
  search?: string;
  roleId?: number;
  status?: AccountStatus;
  isBackOffice?: boolean;
  sortBy?: 'name' | 'email' | 'createdAt' | 'lastLogin';
  sortOrder?: 'asc' | 'desc';
  page?: number;
  limit?: number;
}

export interface AccountSummary {
  totalAccounts: number;
  activeAccounts: number;
  inactiveAccounts: number;
  pendingAccounts: number;
  byRole: {
    roleId: number;
    roleName: string;
    count: number;
  }[];
}

// Permission groups for better UI organization
export interface PermissionGroup {
  name: string;
  label: string;
  permissions: Permission[];
}

export const PermissionGroups: PermissionGroup[] = [
  {
    name: 'global',
    label: 'Permissões Globais',
    permissions: ['view_all', 'create_all', 'edit_all', 'delete_all'],
  },
  {
    name: 'accounts',
    label: 'Contas & Permissões',
    permissions: ['view_accounts', 'create_accounts', 'edit_accounts', 'delete_accounts', 'manage_users', 'manage_permissions'],
  },
  {
    name: 'clients',
    label: 'Clientes',
    permissions: ['view_clients', 'create_clients', 'edit_clients', 'delete_clients'],
  },
  {
    name: 'messages',
    label: 'Mensagens',
    permissions: ['view_messages', 'create_messages', 'edit_messages', 'delete_messages', 'send_messages'],
  },
  {
    name: 'finances',
    label: 'Finanças',
    permissions: ['view_finances', 'create_finances', 'edit_finances', 'delete_finances'],
  },
  {
    name: 'invoices',
    label: 'Faturas',
    permissions: ['view_invoices', 'create_invoices', 'edit_invoices', 'delete_invoices'],
  },
  {
    name: 'reports',
    label: 'Relatórios & Analytics',
    permissions: ['view_reports', 'view_analytics', 'export_data'],
  },
  {
    name: 'team',
    label: 'Equipa',
    permissions: ['view_own', 'edit_own', 'view_team', 'manage_team', 'create_basic'],
  },
];

// Permission labels for display
export const PermissionLabels: Record<Permission, string> = {
  // Global
  view_all: 'Ver Tudo',
  create_all: 'Criar Tudo',
  edit_all: 'Editar Tudo',
  delete_all: 'Eliminar Tudo',

  // Accounts
  view_accounts: 'Ver Contas',
  create_accounts: 'Criar Contas',
  edit_accounts: 'Editar Contas',
  delete_accounts: 'Eliminar Contas',
  manage_users: 'Gerir Utilizadores',
  manage_permissions: 'Gerir Permissões',

  // Clients
  view_clients: 'Ver Clientes',
  create_clients: 'Criar Clientes',
  edit_clients: 'Editar Clientes',
  delete_clients: 'Eliminar Clientes',

  // Messages
  view_messages: 'Ver Mensagens',
  create_messages: 'Criar Mensagens',
  edit_messages: 'Editar Mensagens',
  delete_messages: 'Eliminar Mensagens',
  send_messages: 'Enviar Mensagens',

  // Finances
  view_finances: 'Ver Finanças',
  create_finances: 'Criar Transações',
  edit_finances: 'Editar Transações',
  delete_finances: 'Eliminar Transações',

  // Invoices
  view_invoices: 'Ver Faturas',
  create_invoices: 'Criar Faturas',
  edit_invoices: 'Editar Faturas',
  delete_invoices: 'Eliminar Faturas',

  // Reports
  view_reports: 'Ver Relatórios',
  view_analytics: 'Ver Analytics',
  export_data: 'Exportar Dados',

  // Team
  view_own: 'Ver Próprios',
  create_basic: 'Criar Básico',
  edit_own: 'Editar Próprios',
  view_team: 'Ver Equipa',
  manage_team: 'Gerir Equipa',
};
