import { useQuery } from "@tanstack/react-query";
import type { TransactionFilters } from "@/types";
import { useFinanceSummary, useTransactions } from "./useFinances";

export interface FinanceStatistics {
  totalIncome: number;
  semestralIncome: number;
  weeklyIncome: number;
  dailyIncome: number;
}

export function useFinanceStatistics(
  filters?: Pick<TransactionFilters, "dateFrom" | "dateTo">,
) {
  const { data: transactions = [] } = useTransactions(filters);
  const { data: summary } = useFinanceSummary(filters);

  return useQuery({
    queryKey: ["finance-statistics", transactions, summary],
    queryFn: async (): Promise<FinanceStatistics> => {
      const totalIncome = summary?.totalIncome || 0;

      // Calcular faturamento semestral (últimos 6 meses)
      const sixMonthsAgo = new Date();
      sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);
      const semestralIncome = transactions
        .filter((t) => new Date(t.date) >= sixMonthsAgo)
        .reduce((sum, t) => sum + (t.type === "income" ? t.amount : 0), 0);

      // Calcular faturamento semanal (últimos 7 dias)
      const weekAgo = new Date();
      weekAgo.setDate(weekAgo.getDate() - 7);
      const weeklyIncome = transactions
        .filter((t) => new Date(t.date) >= weekAgo)
        .reduce((sum, t) => sum + (t.type === "income" ? t.amount : 0), 0);

      // Calcular faturamento diário (hoje)
      const today = new Date();
      const startOfDay = new Date(
        today.getFullYear(),
        today.getMonth(),
        today.getDate(),
      );
      const dailyIncome = transactions
        .filter((t) => new Date(t.date) >= startOfDay)
        .reduce((sum, t) => sum + (t.type === "income" ? t.amount : 0), 0);

      return {
        totalIncome,
        semestralIncome,
        weeklyIncome,
        dailyIncome,
      };
    },
    enabled: !!transactions,
    staleTime: 5 * 60 * 1000,
  });
}
