import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import type {
  AccountType,
  CreateAccountTypeData,
  UpdateAccountTypeData,
} from "@/types";
import { apiClient } from "../services/api";

// Fetch all account types
export function useAccountTypes() {
  return useQuery({
    queryKey: ["account-types"],
    queryFn: async () => {
      const response = await apiClient.get<AccountType[]>("/account-types");
      // Handle both direct array and wrapped response formats
      if (Array.isArray(response)) {
        return response;
      }

      const dataField =
        "data" in response
          ? (response as unknown as { data: AccountType[] }).data
          : undefined;

      return Array.isArray(dataField) ? dataField : [];
    },
    staleTime: 5 * 60 * 1000,
  });
}

// Create account type
export function useCreateAccountType() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateAccountTypeData) => {
      return await apiClient.post<AccountType>("/account-types", data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["account-types"] });
    },
  });
}

// Update account type
export function useUpdateAccountType() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({
      id,
      ...data
    }: UpdateAccountTypeData & { id: number }) => {
      return await apiClient.put<AccountType>(`/account-types/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["account-types"] });
    },
  });
}

// Delete account type
export function useDeleteAccountType() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/account-types/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["account-types"] });
    },
  });
}
