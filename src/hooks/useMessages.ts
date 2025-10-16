import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type {
  Message,
  MessageFilters,
  CreateMessageData,
  UpdateMessageData,
  MessageStats,
} from '../types';

/**
 * Query keys factory for messages
 */
export const messageKeys = {
  all: ['messages'] as const,
  lists: () => [...messageKeys.all, 'list'] as const,
  list: (filters: MessageFilters) => [...messageKeys.lists(), filters] as const,
  details: () => [...messageKeys.all, 'detail'] as const,
  detail: (id: string) => [...messageKeys.details(), id] as const,
  stats: () => [...messageKeys.all, 'stats'] as const,
};

/**
 * Hook to fetch messages with optional filters
 */
export function useMessages(filters?: MessageFilters) {
  return useQuery({
    queryKey: messageKeys.list(filters || {}),
    queryFn: async () => {
      const response = await apiClient.get<Message[]>('/messages', filters);
      return response.data || [];
    },
  });
}

/**
 * Hook to fetch a single message by ID
 */
export function useMessage(id: string) {
  return useQuery({
    queryKey: messageKeys.detail(id),
    queryFn: async () => {
      const response = await apiClient.get<Message>(`/messages/${id}`);
      return response.data;
    },
    enabled: !!id,
  });
}

/**
 * Hook to fetch message statistics
 */
export function useMessageStats() {
  return useQuery({
    queryKey: messageKeys.stats(),
    queryFn: async () => {
      const response = await apiClient.get<MessageStats>('/messages/stats');
      return response.data;
    },
  });
}

/**
 * Hook to create new message
 */
export function useCreateMessage() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateMessageData) => {
      const response = await apiClient.post<Message>('/messages', data);
      return response.data;
    },
    onSuccess: () => {
      // Invalidate and refetch
      queryClient.invalidateQueries({ queryKey: messageKeys.lists() });
      queryClient.invalidateQueries({ queryKey: messageKeys.stats() });
    },
  });
}

/**
 * Hook to update existing message
 */
export function useUpdateMessage() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: UpdateMessageData) => {
      const response = await apiClient.put<Message>(`/messages/${data.id}`, data);
      return response.data;
    },
    onSuccess: (data) => {
      // Invalidate lists, stats, and specific message
      queryClient.invalidateQueries({ queryKey: messageKeys.lists() });
      queryClient.invalidateQueries({ queryKey: messageKeys.stats() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: messageKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Hook to delete message
 */
export function useDeleteMessage() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      await apiClient.delete(`/messages/${id}`);
      return id;
    },
    onSuccess: () => {
      // Invalidate lists and stats
      queryClient.invalidateQueries({ queryKey: messageKeys.lists() });
      queryClient.invalidateQueries({ queryKey: messageKeys.stats() });
    },
  });
}

/**
 * Hook to assign message to agent
 */
export function useAssignMessage() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ messageId, agentId }: { messageId: string; agentId: string }) => {
      const response = await apiClient.put<Message>(`/messages/${messageId}/assign`, {
        agentId,
      });
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: messageKeys.lists() });
      queryClient.invalidateQueries({ queryKey: messageKeys.stats() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: messageKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Hook to mark message as read
 */
export function useMarkMessageRead() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      const response = await apiClient.put<Message>(`/messages/${id}/read`);
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: messageKeys.lists() });
      queryClient.invalidateQueries({ queryKey: messageKeys.stats() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: messageKeys.detail(data.id) });
      }
    },
  });
}
