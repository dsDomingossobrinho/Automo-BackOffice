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

    public function getUser()
    {
        header('Content-Type: application/json');

        // Obter ID da URL
        $uri = $_SERVER['REQUEST_URI'];
        preg_match('/\/api\/data\/users\/(\d+)/', $uri, $matches);
        $id = $matches[1] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID do usuário é obrigatório']);
            exit;
        }

        error_log("=== DataController::getUser CALLED with ID: {$id} ===");

        try {
            error_log("Making API request to /users/{$id}");
            $userData = $this->apiClient->authenticatedRequest('GET', "/users/{$id}");
            error_log("API response: " . json_encode($userData));

            if (!$userData) {
                error_log("No user data returned from API");
                http_response_code(404);
                echo json_encode(['error' => 'Usuário não encontrado']);
                exit;
            }

            echo json_encode($userData);
            exit;

        } catch (\Exception $e) {
            error_log("Exception in getUser: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro ao buscar usuário',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function updateUser()
    {
        header('Content-Type: application/json');

        // Obter ID da URL
        $uri = $_SERVER['REQUEST_URI'];
        preg_match('/\/api\/data\/users\/(\d+)/', $uri, $matches);
        $id = $matches[1] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID do usuário é obrigatório']);
            exit;
        }

        error_log("=== DataController::updateUser CALLED with ID: {$id} ===");

        try {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' => 'Dados inválidos']);
                exit;
            }

            // Construir payload baseado na documentação
            $payload = [
                'name' => $data['name'],
                'accountTypeId' => (int)($data['accountTypeId'] ?? 1),
                'stateId' => (int)($data['stateId'] ?? 1)
            ];

            // Adicionar campos opcionais apenas se não estiverem vazios
            if (!empty($data['contacto'])) {
                $payload['contacto'] = $data['contacto'];
            }

            if (!empty($data['email'])) {
                $payload['email'] = $data['email'];
            }

            if (!empty($data['img'])) {
                $payload['img'] = $data['img'];
            }

            if (!empty($data['organizationTypeId'])) {
                $payload['organizationTypeId'] = (int)$data['organizationTypeId'];
            }

            if (!empty($data['countryId'])) {
                $payload['countryId'] = (int)$data['countryId'];
            }

            if (!empty($data['provinceId'])) {
                $payload['provinceId'] = (int)$data['provinceId'];
            }

            error_log("Payload: " . json_encode($payload));

            $response = $this->apiClient->authenticatedRequest('PUT', "/users/{$id}", $payload);

            if ($response) {
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao atualizar usuário']);
            }
            exit;

        } catch (\Exception $e) {
            error_log("Exception in updateUser: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro ao atualizar usuário',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Search organization types - alias for organizationTypes() method
     */
    public function searchOrganizationTypes()
    {
        return $this->organizationTypes();
    }

    /**
     * Search countries - alias for countries() method
     */
    public function searchCountries()
    {
        return $this->countries();
    }

    /**
     * Search provinces - alias for provinces() method
     */
    public function searchProvinces()
    {
        return $this->provinces();
    }
}