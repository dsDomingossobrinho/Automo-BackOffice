// State domain types

export interface State {
  id: number;
  state: string;
  description?: string;
  createdAt?: string;
  updatedAt?: string;
}

export interface CreateStateData {
  state: string;
  description?: string;
}

export interface UpdateStateData {
  state: string;
  description?: string;
}

export interface StatesPaginatedResponse {
  content: State[];
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

export type StateResponse = State;
