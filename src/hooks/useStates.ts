import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import type {
  CreateStateData,
  State,
  StatesPaginatedResponse,
  UpdateStateData,
} from "@/types";
import { apiClient } from "../services/api";

// Fetch states with pagination
export function useStates(page = 0, size = 10, search?: string) {
  return useQuery({
    queryKey: ["states", page, size, search],
    queryFn: async () => {
      const response = await apiClient.get<StatesPaginatedResponse>(
        "/states/paginated",
        {
          page,
          size,
          ...(search && { search }),
        },
      );
      // Handle both direct response and wrapped response formats
      if ("content" in response) {
        return response as unknown as StatesPaginatedResponse;
      }

      const dataField =
        "data" in response
          ? (response as unknown as { data: StatesPaginatedResponse }).data
          : undefined;

      return dataField || (response as unknown as StatesPaginatedResponse);
    },
    staleTime: 5 * 60 * 1000,
  });
}

// Create state
export function useCreateState() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateStateData) => {
      return await apiClient.post<State>("/states", data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["states"] });
    },
  });
}

// Update state
export function useUpdateState() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, ...data }: UpdateStateData & { id: number }) => {
      return await apiClient.put<State>(`/states/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["states"] });
    },
  });
}

// Delete state
export function useDeleteState() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/states/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["states"] });
    },
  });
}
