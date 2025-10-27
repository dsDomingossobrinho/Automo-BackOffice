import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import type {
  CountriesPaginatedResponse,
  Country,
  CreateCountryData,
  UpdateCountryData,
} from "@/types";
import { apiClient } from "../services/api";

// Fetch countries with pagination
export function useCountries(page = 0, size = 10, search?: string) {
  return useQuery({
    queryKey: ["countries", page, size, search],
    queryFn: async () => {
      const response = await apiClient.get<CountriesPaginatedResponse>(
        "/countries/paginated",
        {
          page,
          size,
          ...(search && { search }),
        },
      );
      // Handle both direct response and wrapped response formats
      if ("content" in response) {
        return response as unknown as CountriesPaginatedResponse;
      }

      const dataField =
        "data" in response
          ? (response as unknown as { data: CountriesPaginatedResponse }).data
          : undefined;

      return dataField || (response as unknown as CountriesPaginatedResponse);
    },
    staleTime: 5 * 60 * 1000,
  });
}

// Create country
export function useCreateCountry() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateCountryData) => {
      return await apiClient.post<Country>("/countries", data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["countries"] });
    },
  });
}

// Update country
export function useUpdateCountry() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, ...data }: UpdateCountryData & { id: number }) => {
      return await apiClient.put<Country>(`/countries/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["countries"] });
    },
  });
}

// Delete country
export function useDeleteCountry() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/countries/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["countries"] });
    },
  });
}
