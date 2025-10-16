// User related types (Based on Swagger UserResponse)
export interface User {
  id: number;
  email: string;
  name: string;
  img?: string;
  authId?: number;
  authUsername?: string;
  countryId?: number;
  countryName?: string;
  organizationTypeId?: number;
  organizationTypeName?: string;
  provinceId?: number;
  provinceName?: string;
  stateId?: number;
  stateName?: string;
  createdAt?: string;
  updatedAt?: string;
}

// User DTO for create/update (Based on Swagger UserDto)
export interface UserDto {
  email: string;
  name: string;
  img?: string;
  contacto?: string;
  password?: string;
  accountTypeId: number;
  countryId: number;
  organizationTypeId: number;
  provinceId?: number;
  stateId: number;
}

// Complete User Response (Based on Swagger CompleteUserResponse)
export interface CompleteUserResponse {
  id: number;
  name: string;
  email: string;
  contact?: string;
  username?: string;
  accountTypeId?: number;
  accountTypeName?: string;
  primaryRoleId?: number;
  primaryRoleName?: string;
  allRoles?: RoleInfo[];
  stateId?: number;
  stateName?: string;
  createdAt?: string;
  updatedAt?: string;
  isAdmin?: boolean;
  isBackOffice?: boolean;
  isCorporate?: boolean;
  isAgent?: boolean;
  isManager?: boolean;
}

export interface RoleInfo {
  id: number;
  name: string;
  description?: string;
}

// User Profile (Based on Swagger UserProfileResponse)
export interface UserProfile {
  name?: string;
  identificadorId?: number;
  img?: string;
}

// User Statistics (Based on Swagger UserStatisticsResponse)
export interface UserStatistics {
  totalUsers?: number;
  activeUsers?: number;
  inactiveUsers?: number;
  eliminatedUsers?: number;
}

export const UserRole = {
  Admin: 1,
  User: 2,
  Agent: 3,
  Manager: 4,
} as const;

export type UserRole = typeof UserRole[keyof typeof UserRole];

export type Permission =
  | 'view_all' | 'create_all' | 'edit_all' | 'delete_all'
  | 'view_accounts' | 'create_accounts' | 'edit_accounts' | 'delete_accounts'
  | 'manage_users' | 'manage_permissions'
  | 'view_clients' | 'create_clients' | 'edit_clients' | 'delete_clients'
  | 'view_messages' | 'create_messages' | 'edit_messages' | 'delete_messages' | 'send_messages'
  | 'view_finances' | 'create_finances' | 'edit_finances' | 'delete_finances'
  | 'view_invoices' | 'create_invoices' | 'edit_invoices' | 'delete_invoices'
  | 'view_reports' | 'view_analytics' | 'export_data'
  | 'view_own' | 'create_basic' | 'edit_own'
  | 'view_team' | 'manage_team';
