// Subscription Plan domain types

export interface SubscriptionPlan {
  id: number;
  name: string;
  price: number;
  description?: string;
  messageCount?: number;
  planTypeId?: number;
  planTypeName?: string;
  stateId?: number;
  stateName?: string;
  createdAt?: string;
  updatedAt?: string;
}

export interface CreateSubscriptionPlanData {
  name: string;
  price: number;
  description?: string;
  messageCount?: number;
  planTypeId?: number;
  stateId?: number;
}

export interface UpdateSubscriptionPlanData {
  name: string;
  price: number;
  description?: string;
  messageCount?: number;
  planTypeId?: number;
  stateId?: number;
}

export interface SubscriptionPlansPaginatedResponse {
  content: SubscriptionPlan[];
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

export type SubscriptionPlanResponse = SubscriptionPlan;
