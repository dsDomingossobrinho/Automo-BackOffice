// Client related types (Clients are Users in the API - based on Swagger)

export interface Client {
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

export const ClientStatus = {
  Active: 'active',
  Inactive: 'inactive',
  Pending: 'pending',
  Blocked: 'blocked',
} as const;

export type ClientStatus = typeof ClientStatus[keyof typeof ClientStatus];

// Create Client Data (Based on Swagger UserDto)
export interface CreateClientData {
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

// Update Client Data (Based on Swagger UserDto)
export interface UpdateClientData extends Partial<CreateClientData> {
  id: number;
}

// Client Filters (Based on Swagger paginated users endpoint)
export interface ClientFilters {
  search?: string;
  page?: number;
  size?: number;
  sortBy?: 'id' | 'name' | 'email' | 'createdAt';
  sortDirection?: 'ASC' | 'DESC';
  stateId?: number;
}
