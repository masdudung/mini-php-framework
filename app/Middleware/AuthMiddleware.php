<?php
namespace App\Middleware;

class AuthMiddleware {
    public function handle() {
        // Example: Check if the user is authenticated
        if (!isset($_SESSION['user'])) {
            // Redirect to login page or handle unauthorized access
            http_response_code(401);
            exit('Unauthorized');
        }
    }
}
