import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import type {
  CreateProvinceData,
  Province,
  ProvincesPaginatedResponse,
  UpdateProvinceData,
} from "@/types";
import { apiClient } from "../services/api";

// Fetch provinces with pagination
export function useProvinces(
  page = 0,
  size = 10,
  search?: string,
  countryId?: number,
  stateId?: number,
) {
  return useQuery({
    queryKey: ["provinces", page, size, search, countryId, stateId],
    queryFn: async () => {
      const response = await apiClient.get<ProvincesPaginatedResponse>(
        "/provinces/paginated",
        {
          page,
          size,
          ...(search && { search }),
          ...(countryId && { countryId }),
          ...(stateId && { stateId }),
        },
      );
      // Handle both direct response and wrapped response formats
      if ("content" in response) {
        return response as unknown as ProvincesPaginatedResponse;
      }

      const dataField =
        "data" in response
          ? (response as unknown as { data: ProvincesPaginatedResponse }).data
          : undefined;

      return dataField || (response as unknown as ProvincesPaginatedResponse);
    },
    staleTime: 5 * 60 * 1000,
  });
}

// Get provinces by country (for select dropdowns)
export function useProvincesByCountry(countryId?: number) {
  return useQuery({
    queryKey: ["provinces-by-country", countryId],
    queryFn: async () => {
      const response = await apiClient.get<Province[]>(
        `/provinces/country/${countryId}`,
      );
      // Handle both direct array and wrapped response formats
      if (Array.isArray(response)) {
        return response;
      }

      const dataField =
        "data" in response
          ? (response as unknown as { data: Province[] }).data
          : undefined;

      return Array.isArray(dataField) ? dataField : [];
    },
    enabled: !!countryId,
    staleTime: 5 * 60 * 1000,
  });
}

// Create province
export function useCreateProvince() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateProvinceData) => {
      return await apiClient.post<Province>("/provinces", data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["provinces"] });
      queryClient.invalidateQueries({ queryKey: ["provinces-by-country"] });
    },
  });
}

// Update province
export function useUpdateProvince() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({
      id,
      ...data
    }: UpdateProvinceData & { id: number }) => {
      return await apiClient.put<Province>(`/provinces/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["provinces"] });
      queryClient.invalidateQueries({ queryKey: ["provinces-by-country"] });
    },
  });
}

// Delete province
export function useDeleteProvince() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/provinces/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["provinces"] });
      queryClient.invalidateQueries({ queryKey: ["provinces-by-country"] });
    },
  });
}
