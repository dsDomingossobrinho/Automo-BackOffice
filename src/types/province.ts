// Province domain types

export interface Province {
  id: number;
  province: string;
  countryId?: number;
  countryName?: string;
  stateId?: number;
  stateName?: string;
  createdAt?: string;
  updatedAt?: string;
}

export interface CreateProvinceData {
  name: string;
  description?: string;
  countryId?: number;
  stateId?: number;
}

export interface UpdateProvinceData {
  name: string;
  description?: string;
  countryId?: number;
  stateId?: number;
}

export interface ProvincesPaginatedResponse {
  content: Province[];
  pageable: {
    pageNumber: number;
    pageSize: number;
    offset: number;
    paged: boolean;
    unpaged: boolean;
  };
  totalElements: number;
  totalPages: number;
  last: boolean;
  size: number;
  number: number;
  sort: unknown[];
  first: boolean;
  numberOfElements: number;
  empty: boolean;
}

export type ProvinceResponse = Province;
