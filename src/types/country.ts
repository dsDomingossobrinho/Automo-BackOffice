// Country domain types

export interface Country {
  id: number;
  country: string;
  indicative?: string;
  stateId?: number;
  stateName?: string;
  numberDigits?: number;
  createdAt?: string;
  updatedAt?: string;
}

export interface CreateCountryData {
  name: string;
  code?: string;
  description?: string;
}

export interface UpdateCountryData {
  name: string;
  code?: string;
  description?: string;
}

export interface CountriesPaginatedResponse {
  content: Country[];
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

export type CountryResponse = Country;
