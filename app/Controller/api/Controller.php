<?php

namespace Controller\api;

class Controller
{
    // Method to send JSON response
    protected function jsonResponse($data, $statusCode = 200)
    {
        // Set the status code
        http_response_code($statusCode);

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Encode the response data as JSON
        echo json_encode($data);
        exit(); // Ensure no further code is executed
    }
}

