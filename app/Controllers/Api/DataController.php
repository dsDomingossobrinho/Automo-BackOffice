<?php

namespace App\Controllers\Api;

use App\Core\Controller;

class DataController extends Controller
{
    public function organizationTypes()
    {
        header('Content-Type: application/json');
        error_log("=== DataController::organizationTypes CALLED ===");

        try {
            $search = $_GET['search'] ?? '';
            $page = (int)($_GET['page'] ?? 0);
            $size = (int)($_GET['size'] ?? 50);

            error_log("Params: search='$search', page=$page, size=$size");

            $endpoint = "/organization-types/paginated";
            $params = [
                'search' => $search,
                'page' => $page,
                'size' => $size
            ];

            $queryString = http_build_query($params);
            error_log("API endpoint: $endpoint ? $queryString");

            $response = $this->apiClient->authenticatedRequest('GET', $endpoint . '?' . $queryString);
            error_log("API response: " . json_encode($response));

            if ($response && isset($response['data']['content'])) {
                error_log("SUCCESS: Returning " . count($response['data']['content']) . " items");
                echo json_encode($response['data']);
                exit;
            } else {
                error_log("ERROR: No response or no content field");
                error_log("Response structure: " . var_export($response, true));
                echo json_encode([
                    'content' => [],
                    'totalElements' => 0
                ]);
                exit;
            }

        } catch (\Exception $e) {
            error_log("EXCEPTION in organizationTypes: " . $e->getMessage());
            error_log("Exception trace: " . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Erro ao carregar tipos de organização',
                'details' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function countries()
    {
        header('Content-Type: application/json');

        try {
            $search = $_GET['search'] ?? '';
            $page = (int)($_GET['page'] ?? 0);
            $size = (int)($_GET['size'] ?? 50);

            $endpoint = "/countries/paginated";
            $params = [
                'search' => $search,
                'page' => $page,
                'size' => $size
            ];

            $queryString = http_build_query($params);
            $response = $this->apiClient->authenticatedRequest('GET', $endpoint . '?' . $queryString);

            if ($response && isset($response['data']['content'])) {
                echo json_encode($response['data']);
                exit;
            } else {
                // Retornar resposta vazia se a API não responder
                echo json_encode([
                    'content' => [],
                    'totalElements' => 0
                ]);
                exit;
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Erro ao carregar países',
                'details' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function provinces()
    {
        header('Content-Type: application/json');

        try {
            $search = $_GET['search'] ?? '';
            $page = (int)($_GET['page'] ?? 0);
            $size = (int)($_GET['size'] ?? 50);

            $endpoint = "/provinces/paginated";
            $params = [
                'search' => $search,
                'page' => $page,
                'size' => $size
            ];

            $queryString = http_build_query($params);
            $response = $this->apiClient->authenticatedRequest('GET', $endpoint . '?' . $queryString);

            if ($response && isset($response['data']['content'])) {
                echo json_encode($response['data']);
                exit;
            } else {
                // Retornar resposta vazia se a API não responder
                echo json_encode([
                    'content' => [],
                    'totalElements' => 0
                ]);
                exit;
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Erro ao carregar províncias',
                'details' => $e->getMessage()
            ]);
            exit;
        }
    }
}