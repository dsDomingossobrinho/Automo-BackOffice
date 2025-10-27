// Promotion domain types

export interface Promotion {
  id: number;
  name: string;
  code: string;
  discount: number; // percentage or absolute depending on API (assume percent)
  description?: string;
  stateId?: number;
  stateName?: string;
  createdAt?: string;
  updatedAt?: string;
}

export interface CreatePromotionData {
  name: string;
  code: string;
  discount: number;
  description?: string;
  stateId?: number;
}

export interface UpdatePromotionData {
  name: string;
  code: string;
  discount: number;
  description?: string;
  stateId?: number;
}

export interface PromotionsPaginatedResponse {
  content: Promotion[];
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

export type PromotionResponse = Promotion;
