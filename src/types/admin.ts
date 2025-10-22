// Admin related types (Based on Swagger AdminResponse and AdminDto)

export interface Admin {
  id: number;
  email: string;
  name: string;
  img?: string;
  authId?: number;
  username?: string;
  stateId?: number;
  state?: string;
  createdAt?: string;
  updatedAt?: string;
}

// Admin DTO for create/update (Based on Swagger AdminDto)
export interface AdminDto {
  email: string;
  name: string;
  img?: string;
  password?: string;
  contact?: string;
  accountTypeId: number;
  stateId: number;
}

// Admin Statistics (Based on Swagger AdminStatisticsResponse)
export interface AdminStatistics {
  totalAdmins: number;
  activeAdmins: number;
  inactiveAdmins: number;
  eliminatedAdmins: number;
}

// Admin Filters for pagination
export interface AdminFilters extends Record<string, string | number | undefined> {
  search?: string;
  page?: number;
  size?: number;
  sortBy?: 'id' | 'name' | 'email' | 'createdAt';
  sortDirection?: 'ASC' | 'DESC';
  stateId?: number;
}

export interface CreateAdminData extends AdminDto { }

export interface UpdateAdminData extends Partial<AdminDto> {
  id: number;
}
