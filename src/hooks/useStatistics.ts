import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

/**
 * Custom hooks for Statistics
 * Using TanStack Query for data fetching and caching
 *
 * API Endpoints (Based on Swagger):
 * - GET /statistics/revenue - Get revenue statistics
 * - GET /statistics/revenue/state/{stateId} - Get revenue by state
 * - GET /users/statistics - Get user statistics
 * - GET /admins/statistics - Get admin statistics
 * - GET /subscription-statistics/general - Get subscription statistics
 * - GET /payments/statistics - Get payment statistics
 */

// Revenue Statistics (Based on Swagger RevenueStatisticsResponse)
export interface RevenueStatistics {
  totalRevenue: number;
  dailyRevenue: number;
  monthlyRevenue: number;
  semesterRevenue: number;
  calculatedAt: string;
  currency: string;
}

// User Statistics (Based on Swagger UserStatisticsResponse)
export interface UserStatistics {
  totalUsers: number;
  activeUsers: number;
  inactiveUsers: number;
  eliminatedUsers: number;
}

// Admin Statistics (Based on Swagger AdminStatisticsResponse)
export interface AdminStatistics {
  totalAdmins: number;
  activeAdmins: number;
  inactiveAdmins: number;
  eliminatedAdmins: number;
}

// Subscription Statistics (Based on Swagger SubscriptionStatisticsResponse)
export interface PlanTypeStatistics {
  plan3Days: number;
  plan7Days: number;
  plan14Days: number;
  plan1Month: number;
  plan6Months: number;
  plan1Year: number;
  planAvulsos: number;
}

export interface SubscriptionStatistics {
  totalActiveSubscriptions: number;
  totalUsers: number;
  planTypeStatistics: PlanTypeStatistics;
}

// Payment Statistics (Based on Swagger PaymentStatisticsResponse)
export interface PaymentStatistics {
  totalToday: number;
  totalThisWeek: number;
  totalThisMonth: number;
  totalThisYear: number;
  currency: string;
  generatedAt: string;
}

// Query Keys
export const statisticsKeys = {
  all: ['statistics'] as const,
  revenue: () => [...statisticsKeys.all, 'revenue'] as const,
  revenueByState: (stateId: number) => [...statisticsKeys.revenue(), stateId] as const,
  users: () => [...statisticsKeys.all, 'users'] as const,
  admins: () => [...statisticsKeys.all, 'admins'] as const,
  subscriptions: () => [...statisticsKeys.all, 'subscriptions'] as const,
  payments: () => [...statisticsKeys.all, 'payments'] as const,
};

/**
 * Hook to fetch revenue statistics
 * Uses GET /statistics/revenue
 */
export function useRevenueStatistics() {
  return useQuery<RevenueStatistics>({
    queryKey: ['revenueStatistics'],
    queryFn: async () => {
      const response = await apiClient.get<RevenueStatistics>('/statistics/revenue');
      return response.data;
    },
    staleTime: 5 * 60 * 1000, // 5 minutos
  });
}

/**
 * Hook to fetch revenue statistics by state
 * Uses GET /statistics/revenue/state/{stateId}
 */
export function useRevenueStatisticsByState(stateId: number) {
  return useQuery({
    queryKey: statisticsKeys.revenueByState(stateId),
    queryFn: async () => {
      const response = await apiClient.get<RevenueStatistics>(`/statistics/revenue/state/${stateId}`);
      return response.data;
    },
    enabled: !!stateId,
  });
}

/**
 * Hook to fetch user statistics
 * Uses GET /users/statistics
 */
export function useUserStatistics() {
  return useQuery({
    queryKey: statisticsKeys.users(),
    queryFn: async () => {
      const response = await apiClient.get<UserStatistics>('/users/statistics');
      return response.data;
    },
  });
}

/**
 * Hook to fetch admin statistics
 * Uses GET /admins/statistics
 */
export function useAdminStatistics() {
  return useQuery({
    queryKey: statisticsKeys.admins(),
    queryFn: async () => {
      const response = await apiClient.get<AdminStatistics>('/admins/statistics');
      return response.data;
    },
  });
}

/**
 * Hook to fetch subscription statistics
 * Uses GET /subscription-statistics/general
 */
export function useSubscriptionStatistics() {
  return useQuery({
    queryKey: statisticsKeys.subscriptions(),
    queryFn: async () => {
      const response = await apiClient.get<SubscriptionStatistics>('/subscription-statistics/general');
      return response.data;
    },
  });
}

/**
 * Hook to fetch payment statistics
 * Uses GET /payments/statistics
 */
export function usePaymentStatistics() {
  return useQuery({
    queryKey: statisticsKeys.payments(),
    queryFn: async () => {
      const response = await apiClient.get<PaymentStatistics>('/payments/statistics');
      return response.data;
    },
  });
}
