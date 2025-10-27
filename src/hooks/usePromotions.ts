import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { apiClient } from "@/services/api";
import type {
  CreatePromotionData,
  Promotion,
  PromotionsPaginatedResponse,
  UpdatePromotionData,
} from "@/types";

export function usePromotions(page = 0, size = 10, search?: string) {
  return useQuery({
    queryKey: ["promotions", page, size, search],
    queryFn: async () => {
      const response = await apiClient.get<PromotionsPaginatedResponse>(
        "/promotions/paginated",
        {
          page,
          size,
          ...(search && { search }),
        },
      );

      if ("content" in response) {
        return response as unknown as PromotionsPaginatedResponse;
      }

      const dataField =
        "data" in response
          ? (response as unknown as { data: PromotionsPaginatedResponse }).data
          : undefined;

      return dataField || (response as unknown as PromotionsPaginatedResponse);
    },
    staleTime: 5 * 60 * 1000,
  });
}

export function useCreatePromotion() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreatePromotionData) => {
      return await apiClient.post<Promotion>("/promotions", data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["promotions"] });
    },
  });
}

export function useUpdatePromotion() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({
      id,
      ...data
    }: UpdatePromotionData & { id: number }) => {
      return await apiClient.put<Promotion>(`/promotions/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["promotions"] });
    },
  });
}

export function useDeletePromotion() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/promotions/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["promotions"] });
    },
  });
}
