<?php

namespace Controller\api;

use Service\AuthService;
use Repository\ReaderRepository;
use Database\Connect;

class TelegramController extends Controller
{
    private $authService;

    public function __construct()
    {
        $connect = Connect::getInstance();
        $this->authService = new AuthService($connect);
    }

    // Handles the /api/link request to save the binding token and Telegram ID
    public function linkTelegramAccountPost()
    {
        // CORS headers
      //  header("Access-Control-Allow-Origin: *");  // Allow access from any origin
      //  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");  // Allow POST, GET, OPTIONS methods
      //  header("Access-Control-Allow-Headers: Content-Type, Authorization");  // Allow necessary headers

        // Handle OPTIONS request (preflight request from browser)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        // Get the secret token from the environment variable
        $secretToken = getenv('SECRET_TOKEN'); // Use environment variable for the secret token

        // Check the authorization token from request headers
        $authHeader = getallheaders()['Authorization'] ?? null;

        if (!$authHeader || $authHeader !== $secretToken) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
            return;
        }

        // Get data from the POST request
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate if both telegram_id and binding_token are provided
        if (empty($data['telegram_id']) || empty($data['binding_token'])) {
            $this->jsonResponse(['error' => 'Missing telegram_id or binding_token'], 400);
            return;
        }

        // Use AuthService to save or update the binding token and other user data
        $success = $this->authService->saveOrUpdateBindingTokenWithUserData($data);

        // Send response based on the success of the save operation
        if ($success) {
            $this->jsonResponse(['success' => 'Telegram ID and binding token saved successfully']);
        } else {
            $this->jsonResponse(['error' => 'Failed to save binding token'], 500);
        }
    }
}
