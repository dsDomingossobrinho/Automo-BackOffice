<?php
namespace App\Controllers;

use App\Core\Controller;

/**
 * Dashboard Controller
 */
class DashboardController extends Controller
{
    /**
     * Show dashboard with general information
     */
    public function index()
    {
        try {
            // Fetch dashboard statistics from API
            $stats = $this->getDashboardStats();
            $recentActivity = $this->getRecentActivity();
            $chartData = $this->getChartData();
            
            $this->view('dashboard/index', [
                'stats' => $stats,
                'recent_activity' => $recentActivity,
                'chart_data' => $chartData
            ]);
        } catch (\Exception $e) {
            // If API is not available, show dashboard with empty data
            $this->view('dashboard/index', [
                'stats' => $this->getDefaultStats(),
                'recent_activity' => [],
                'chart_data' => $this->getDefaultChartData(),
                'api_error' => true
            ]);
        }
    }
    
    /**
     * Get dashboard statistics from API
     */
    private function getDashboardStats()
    {
        try {
            // Get various stats from different endpoints
            $users = $this->apiClient->authenticatedRequest('GET', '/users');
            $clients = $this->apiClient->authenticatedRequest('GET', '/clients');
            $messages = $this->apiClient->authenticatedRequest('GET', '/messages');
            $finances = $this->apiClient->authenticatedRequest('GET', '/payments');
            
            return [
                'total_users' => count($users ?? []),
                'total_clients' => count($clients ?? []),
                'total_messages' => count($messages ?? []),
                'total_revenue' => $this->calculateTotalRevenue($finances ?? []),
                'active_clients' => $this->countActiveClients($clients ?? []),
                'monthly_revenue' => $this->calculateMonthlyRevenue($finances ?? []),
                'messages_today' => $this->countMessagesToday($messages ?? []),
                'new_clients_month' => $this->countNewClientsThisMonth($clients ?? [])
            ];
        } catch (\Exception $e) {
            return $this->getDefaultStats();
        }
    }
    
    /**
     * Get recent activity from API
     */
    private function getRecentActivity()
    {
        try {
            // Get recent activities - this would need to be implemented in the backend
            // For now, we'll simulate some activities
            return [
                [
                    'type' => 'user_login',
                    'message' => 'Novo login de usuário admin@automo.com',
                    'timestamp' => date('Y-m-d H:i:s'),
                    'icon' => 'sign-in-alt',
                    'color' => 'success'
                ],
                [
                    'type' => 'client_registered',
                    'message' => 'Novo cliente registado no sistema',
                    'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                    'icon' => 'user-plus',
                    'color' => 'info'
                ],
                [
                    'type' => 'message_sent',
                    'message' => '15 mensagens enviadas com sucesso',
                    'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                    'icon' => 'envelope',
                    'color' => 'primary'
                ],
                [
                    'type' => 'payment_received',
                    'message' => 'Pagamento de 50.000 AOA recebido',
                    'timestamp' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                    'icon' => 'money-bill-wave',
                    'color' => 'warning'
                ]
            ];
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Get chart data for dashboard
     */
    private function getChartData()
    {
        try {
            // Get data for charts - monthly revenue, client growth, etc.
            return [
                'monthly_revenue' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun'],
                    'data' => [25000, 30000, 45000, 35000, 50000, 60000]
                ],
                'client_growth' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun'],
                    'data' => [10, 25, 40, 60, 85, 110]
                ],
                'message_stats' => [
                    'labels' => ['Enviadas', 'Lidas', 'Respondidas'],
                    'data' => [850, 650, 420]
                ]
            ];
        } catch (\Exception $e) {
            return $this->getDefaultChartData();
        }
    }
    
    /**
     * Get default stats when API is not available
     */
    private function getDefaultStats()
    {
        return [
            'total_users' => 0,
            'total_clients' => 0,
            'total_messages' => 0,
            'total_revenue' => 0,
            'active_clients' => 0,
            'monthly_revenue' => 0,
            'messages_today' => 0,
            'new_clients_month' => 0
        ];
    }
    
    /**
     * Get default chart data when API is not available
     */
    private function getDefaultChartData()
    {
        return [
            'monthly_revenue' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun'],
                'data' => [0, 0, 0, 0, 0, 0]
            ],
            'client_growth' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun'],
                'data' => [0, 0, 0, 0, 0, 0]
            ],
            'message_stats' => [
                'labels' => ['Enviadas', 'Lidas', 'Respondidas'],
                'data' => [0, 0, 0]
            ]
        ];
    }
    
    /**
     * Calculate total revenue from payments
     */
    private function calculateTotalRevenue($payments)
    {
        $total = 0;
        foreach ($payments as $payment) {
            if (isset($payment['amount'])) {
                $total += floatval($payment['amount']);
            }
        }
        return $total;
    }
    
    /**
     * Count active clients
     */
    private function countActiveClients($clients)
    {
        $count = 0;
        foreach ($clients as $client) {
            if (isset($client['state']) && $client['state']['name'] === 'ACTIVE') {
                $count++;
            }
        }
        return $count;
    }
    
    /**
     * Calculate monthly revenue
     */
    private function calculateMonthlyRevenue($payments)
    {
        $total = 0;
        $currentMonth = date('Y-m');
        
        foreach ($payments as $payment) {
            if (isset($payment['amount']) && isset($payment['createdAt'])) {
                $paymentMonth = date('Y-m', strtotime($payment['createdAt']));
                if ($paymentMonth === $currentMonth) {
                    $total += floatval($payment['amount']);
                }
            }
        }
        return $total;
    }
    
    /**
     * Count messages sent today
     */
    private function countMessagesToday($messages)
    {
        $count = 0;
        $today = date('Y-m-d');
        
        foreach ($messages as $message) {
            if (isset($message['createdAt'])) {
                $messageDate = date('Y-m-d', strtotime($message['createdAt']));
                if ($messageDate === $today) {
                    $count++;
                }
            }
        }
        return $count;
    }
    
    /**
     * Count new clients this month
     */
    private function countNewClientsThisMonth($clients)
    {
        $count = 0;
        $currentMonth = date('Y-m');
        
        foreach ($clients as $client) {
            if (isset($client['createdAt'])) {
                $clientMonth = date('Y-m', strtotime($client['createdAt']));
                if ($clientMonth === $currentMonth) {
                    $count++;
                }
            }
        }
        return $count;
    }
}