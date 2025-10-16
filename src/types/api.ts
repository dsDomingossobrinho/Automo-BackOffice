// API related types
export interface ApiResponse<T = any> {
  success: boolean;
  message?: string;
  data?: T;
  errors?: string[];
}

export interface PaginatedResponse<T> {
  success: boolean;
  data: T[];
  pagination: {
    page: number;
    limit: number;
    total: number;
    totalPages: number;
  };
}

export interface ApiError {
  message: string;
  status?: number;
  errors?: string[];
}

export const HttpMethod = {
  GET: 'GET',
  POST: 'POST',
  PUT: 'PUT',
  DELETE: 'DELETE',
  PATCH: 'PATCH',
} as const;

export type HttpMethod = typeof HttpMethod[keyof typeof HttpMethod];

export interface RequestConfig {
  headers?: Record<string, string>;
  params?: Record<string, any>;
  timeout?: number;
}
