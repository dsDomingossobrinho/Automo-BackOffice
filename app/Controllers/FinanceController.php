<?php

namespace App\Controllers;

use App\Core\Controller;

class FinanceController extends Controller
{
    public function index()
    {
        $period = $_GET['period'] ?? 'year';
        $year = $_GET['year'] ?? date('Y');
        
        $params = [
            'period' => $period,
            'year' => $year
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/finances', $params);
            
            if ($response['success'] ?? false) {
                $totalRevenue = $response['data']['total_revenue'] ?? 0;
                $chartData = $response['data']['chart'] ?? [];
                $stats = $response['data']['stats'] ?? [];
                $topClients = $response['data']['top_clients'] ?? [];
                $recentTransactions = $response['data']['recent_transactions'] ?? [];
            } else {
                $totalRevenue = 0;
                $chartData = [];
                $stats = [];
                $topClients = [];
                $recentTransactions = [];
                $this->setFlash('errors', ['Erro ao carregar dados financeiros: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $totalRevenue = 0;
            $chartData = [];
            $stats = [];
            $topClients = [];
            $recentTransactions = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('finances/index', [
            'totalRevenue' => $totalRevenue,
            'chartData' => $chartData,
            'stats' => $stats,
            'topClients' => $topClients,
            'recentTransactions' => $recentTransactions,
            'period' => $period,
            'year' => $year
        ]);
    }

    public function monthly()
    {
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        
        $params = [
            'year' => $year,
            'month' => $month
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/finances/monthly', $params);
            
            if ($response['success'] ?? false) {
                $monthlyRevenue = $response['data']['monthly_revenue'] ?? 0;
                $dailyData = $response['data']['daily_data'] ?? [];
                $stats = $response['data']['stats'] ?? [];
                $transactions = $response['data']['transactions'] ?? [];
                $comparison = $response['data']['comparison'] ?? [];
            } else {
                $monthlyRevenue = 0;
                $dailyData = [];
                $stats = [];
                $transactions = [];
                $comparison = [];
                $this->setFlash('errors', ['Erro ao carregar dados mensais: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $monthlyRevenue = 0;
            $dailyData = [];
            $stats = [];
            $transactions = [];
            $comparison = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('finances/monthly', [
            'monthlyRevenue' => $monthlyRevenue,
            'dailyData' => $dailyData,
            'stats' => $stats,
            'transactions' => $transactions,
            'comparison' => $comparison,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function daily()
    {
        $date = $_GET['date'] ?? date('Y-m-d');
        
        $params = [
            'date' => $date
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/finances/daily', $params);
            
            if ($response['success'] ?? false) {
                $dailyRevenue = $response['data']['daily_revenue'] ?? 0;
                $hourlyData = $response['data']['hourly_data'] ?? [];
                $stats = $response['data']['stats'] ?? [];
                $transactions = $response['data']['transactions'] ?? [];
                $comparison = $response['data']['comparison'] ?? [];
            } else {
                $dailyRevenue = 0;
                $hourlyData = [];
                $stats = [];
                $transactions = [];
                $comparison = [];
                $this->setFlash('errors', ['Erro ao carregar dados diários: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $dailyRevenue = 0;
            $hourlyData = [];
            $stats = [];
            $transactions = [];
            $comparison = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('finances/daily', [
            'dailyRevenue' => $dailyRevenue,
            'hourlyData' => $hourlyData,
            'stats' => $stats,
            'transactions' => $transactions,
            'comparison' => $comparison,
            'date' => $date
        ]);
    }

    public function weekly()
    {
        $week = $_GET['week'] ?? date('W');
        $year = $_GET['year'] ?? date('Y');
        
        $params = [
            'week' => $week,
            'year' => $year
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/finances/weekly', $params);
            
            if ($response['success'] ?? false) {
                $weeklyRevenue = $response['data']['weekly_revenue'] ?? 0;
                $dailyData = $response['data']['daily_data'] ?? [];
                $stats = $response['data']['stats'] ?? [];
                $transactions = $response['data']['transactions'] ?? [];
                $comparison = $response['data']['comparison'] ?? [];
                $weekDates = $response['data']['week_dates'] ?? [];
            } else {
                $weeklyRevenue = 0;
                $dailyData = [];
                $stats = [];
                $transactions = [];
                $comparison = [];
                $weekDates = [];
                $this->setFlash('errors', ['Erro ao carregar dados semanais: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $weeklyRevenue = 0;
            $dailyData = [];
            $stats = [];
            $transactions = [];
            $comparison = [];
            $weekDates = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('finances/weekly', [
            'weeklyRevenue' => $weeklyRevenue,
            'dailyData' => $dailyData,
            'stats' => $stats,
            'transactions' => $transactions,
            'comparison' => $comparison,
            'week' => $week,
            'year' => $year,
            'weekDates' => $weekDates
        ]);
    }
}