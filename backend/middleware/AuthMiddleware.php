<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class AuthMiddleware {

    // Secret key for JWT - load from environment or fallback to a default (should be secured in production)
    private static $secret;

    // Initialize secret key (call this once at the app startup)
    public static function init() {
        self::$secret = getenv('JWT_SECRET') ?: 'secret-key1';
    }

    // Log each incoming request (optional)
    public static function logRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $timestamp = date("Y-m-d H:i:s");
        error_log("[$timestamp] $method $uri");
    }

    // Validate required JSON fields in request body
    public static function validateJson(array $requiredFields) {
        $data = Flight::request()->data->getData();
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                header('Content-Type: application/json');
                Flight::json(["error" => "Missing field: $field"], 400);
                exit();
            }
        }
    }

    // Authenticate user by validating JWT from Authorization header
    public static function authenticate() {
        self::logRequest();

        $authHeader = self::getAuthorizationHeader();
        if (!$authHeader) {
            header('Content-Type: application/json');
            Flight::json(['error' => 'Authorization header missing'], 401);
            exit();
        }

        if (strpos($authHeader, 'Bearer ') !== 0) {
            header('Content-Type: application/json');
            Flight::json(['error' => 'Invalid token format'], 401);
            exit();
        }

        $token = substr($authHeader, 7); // Remove "Bearer "

        try {
            $decoded = JWT::decode($token, new Key(self::$secret, 'HS256'));
            // Store user info globally for this request
            Flight::set('user', $decoded);
        } catch (ExpiredException $e) {
            header('Content-Type: application/json');
            Flight::json(['error' => 'Token expired'], 401);
            exit();
        } catch (SignatureInvalidException $e) {
            header('Content-Type: application/json');
            Flight::json(['error' => 'Invalid token signature'], 401);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            Flight::json(['error' => 'Invalid token'], 401);
            exit();
        }
    }

    // Check admin role - only allow if user role is 'admin'
    public static function requireAdmin() {
        self::authenticate();
        $user = Flight::get('user');
        $userData = (array) $user;

        if (!isset($userData['role']) || $userData['role'] !== 'admin') {
            header('Content-Type: application/json');
            Flight::json(['error' => 'Admin access required'], 403);
            exit();
        }
    }

    // Require any authenticated user (admin or regular user)
    public static function requireUser() {
        self::authenticate();
    }

    // Get current user ID from JWT payload
    public static function getUserId() {
        $user = Flight::get('user');
        $userData = (array) $user;
        return $userData['id'] ?? null;
    }

    // Check if user is admin
    public static function isAdmin() {
        $user = Flight::get('user');
        $userData = (array) $user;
        return (isset($userData['role']) && $userData['role'] === 'admin');
    }

    // Helper to get Authorization header (works with different server configs)
    private static function getAuthorizationHeader() {
        if (isset($_SERVER['Authorization'])) {
            return trim($_SERVER['Authorization']);
        }
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return trim($_SERVER['HTTP_AUTHORIZATION']);
        }
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            // Normalize header names
            foreach ($headers as $key => $value) {
                if (strtolower($key) === 'authorization') {
                    return trim($value);
                }
            }
        }
        return null;
    }
}

// Initialize secret key when the file is included
AuthMiddleware::init();
