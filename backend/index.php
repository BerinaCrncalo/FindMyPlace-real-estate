<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Setup DB connection via FlightPHP
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=FindMyPlace', 'root', 'database1'));

// Load Middleware classes
require_once 'middleware/AuthMiddleware.php';
require_once 'middleware/RequestLogger.php';

// Load DAOs
require_once "dao/BaseDao.php";
require_once 'dao/CategoryDao.php';
require_once 'dao/ContactMessageDao.php';
require_once 'dao/FavoritesDao.php';
require_once 'dao/ListingImageDao.php';
require_once 'dao/ListingsDao.php';
require_once 'dao/SavedSearchesDao.php';
require_once 'dao/UserDao.php';
require_once 'dao/UserProfilesDao.php';

// Load Services
require_once 'services/CategoryService.php';
require_once 'services/ContactMessageService.php';
require_once 'services/FavoritesService.php';
require_once 'services/ListingImageService.php';
require_once 'services/ListingsService.php';
require_once 'services/SavedSearchesService.php';
require_once 'services/UserService.php';
require_once 'services/UserProfilesService.php';

// Load Controllers
require_once 'controllers/CategoryController.php';
require_once 'controllers/ContactMessageController.php';
require_once 'controllers/FavoritesController.php';
require_once 'controllers/ListingImageController.php';
require_once 'controllers/ListingsController.php';
require_once 'controllers/SavedSearchesController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/UserProfilesController.php';

// Basic request logging for every request
Flight::before('start', function(&$params, &$output) {
    RequestLogger::logRequest();
});

// ------------------
// Authentication routes (no auth required here)

// Register new user (hash password)
Flight::route('POST /users', function() {
    AuthMiddleware::validateJson(['username', 'email', 'password']);
    $controller = new UserController();
    $controller->registerUser();
});

// Login user (returns JWT token)
Flight::route('POST /login', function() {
    AuthMiddleware::validateJson(['email', 'password']);
    $controller = new UserController();
    $controller->loginUser();
});

// ------------------
// Middleware helpers for authorization

function requireAdmin() {
    AuthMiddleware::requireUser();
    if (!AuthMiddleware::isAdmin()) {
        Flight::halt(403, json_encode(['error' => 'Admin access required']));
    }
}

function requireUserOrAdmin() {
    AuthMiddleware::requireUser();
    // Additional user-specific checks can be placed here if needed
}
function requireSellerOrAdmin() {
    AuthMiddleware::requireUser();  // check if user is authenticated first

    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        Flight::halt(401, json_encode(['error' => 'Authorization header missing']));
    }

    $authHeader = $headers['Authorization'];
    if (strpos($authHeader, 'Bearer ') !== 0) {
        Flight::halt(401, json_encode(['error' => 'Invalid Authorization header format']));
    }

    $token = substr($authHeader, 7); // remove "Bearer " prefix

    try {
        $secretKey = 'secret_key1'; 
        $decoded = Firebase\JWT\JWT::decode($token, new Firebase\JWT\Key($secretKey, 'HS256'));

        if (!isset($decoded->role)) {
            Flight::halt(403, json_encode(['error' => 'Role claim missing in token']));
        }

        $role = $decoded->role;
        if ($role !== 'admin' && $role !== 'seller') {
            Flight::halt(403, json_encode(['error' => 'Only sellers or admins can add listings']));
        }

    } catch (Exception $e) {
        Flight::halt(401, json_encode(['error' => 'Invalid token: ' . $e->getMessage()]));
    }
}


// ------------------
// Routes for Categories

// Create Category - only Admin
Flight::route('POST /categories', function() {
    requireAdmin();
    AuthMiddleware::validateJson(['name']);
    $controller = new CategoryController();
    $controller->createCategory();
});

// Get all categories - everyone can view
Flight::route('GET /categories', function() {
    $controller = new CategoryController();
    $controller->getAllCategories();
});

// Get category by id - everyone can view
Flight::route('GET /categories/@id', function($id) {
    $controller = new CategoryController();
    $controller->getCategoryById($id);
});

// Update Category - only Admin
Flight::route('PUT /categories/@id', function($id) {
    requireAdmin();
    AuthMiddleware::validateJson(['name']);
    $controller = new CategoryController();
    $controller->updateCategory($id);
});

// Delete Category - only Admin
Flight::route('DELETE /categories/@id', function($id) {
    requireAdmin();
    $controller = new CategoryController();
    $controller->deleteCategory($id);
});

// ------------------
// Contact Messages

// Create Contact Message - any authenticated user
Flight::route('POST /contact_messages', function() {
    requireUserOrAdmin();
    AuthMiddleware::validateJson(['name', 'email', 'message']);
    $controller = new ContactMessageController();
    $controller->createContactMessage();
});

// Get all contact messages - only Admin
Flight::route('GET /contact_messages', function() {
    requireAdmin();
    $controller = new ContactMessageController();
    $controller->getAllContactMessages();
});

// Get contact message by id - only Admin
Flight::route('GET /contact_messages/@id', function($id) {
    requireAdmin();
    $controller = new ContactMessageController();
    $controller->getContactMessageById($id);
});

// Update contact message - only Admin
Flight::route('PUT /contact_messages/@id', function($id) {
    requireAdmin();
    AuthMiddleware::validateJson(['message']);
    $controller = new ContactMessageController();
    $controller->updateContactMessage($id);
});

// Delete contact message - only Admin
Flight::route('DELETE /contact_messages/@id', function($id) {
    requireAdmin();
    $controller = new ContactMessageController();
    $controller->deleteContactMessage($id);
});

// ------------------
// Favorites

// Add to favorites - any authenticated user
Flight::route('POST /favorites', function() {
    requireUserOrAdmin();
    AuthMiddleware::validateJson(['user_id', 'listing_id']);
    $controller = new FavoritesController();
    $controller->addToFavorites();
});

// Get favorites by user id - only that user or Admin
Flight::route('GET /favorites/user/@user_id', function($user_id) {
    AuthMiddleware::requireUser();
    if (!AuthMiddleware::isAdmin() && AuthMiddleware::getUserId() != $user_id) {
        Flight::halt(403, json_encode(['error' => 'Access denied']));
    }
    $controller = new FavoritesController();
    $controller->getFavoritesByUserId($user_id);
});

// Remove from favorites - user who owns or Admin
Flight::route('DELETE /favorites/@id', function($id) {
    requireUserOrAdmin();
    $controller = new FavoritesController();
    $controller->removeFromFavorites($id);
});

// ------------------
// Listing Images

// Add image to listing - Admin only
Flight::route('POST /listing_images', function() {
    requireAdmin();
    AuthMiddleware::validateJson(['listing_id', 'image_url']);
    $controller = new ListingImageController();
    $controller->addImageToListing();
});

// Get all images - public
Flight::route('GET /listing_images', function() {
    $controller = new ListingImageController();
    $controller->getAllImages();
});

// Get image by id - public
Flight::route('GET /listing_images/@id', function($id) {
    $controller = new ListingImageController();
    $controller->getImageById($id);
});

// Update image - Admin only
Flight::route('PUT /listing_images/@id', function($id) {
    requireAdmin();
    AuthMiddleware::validateJson(['image_url']);
    $controller = new ListingImageController();
    $controller->updateImage($id);
});

// Delete image - Admin only
Flight::route('DELETE /listing_images/@id', function($id) {
    requireAdmin();
    $controller = new ListingImageController();
    $controller->deleteImage($id);
});

// ------------------
// Listings

// Create listing - Admin only
Flight::route('POST /listings', function() {
    requireSellerOrAdmin();
    AuthMiddleware::validateJson(['title', 'description', 'price']);
    $controller = new ListingsController();
    $controller->createListing();
});

// Get all listings - public
Flight::route('GET /listings', function() {
    $controller = new ListingsController();
    $controller->getAllListings();
});

// Get listing by id - public
Flight::route('GET /listings/@id', function($id) {
    $controller = new ListingsController();
    $controller->getListingById($id);
});

// Update listing - Admin only
Flight::route('PUT /listings/@id', function($id) {
    requireAdmin();
    AuthMiddleware::validateJson(['title']);
    $controller = new ListingsController();
    $controller->updateListing($id);
});

// Delete listing - Admin only
Flight::route('DELETE /listings/@id', function($id) {
    requireAdmin();
    $controller = new ListingsController();
    $controller->deleteListing($id);
});

// ------------------
// Saved Searches

// Create saved search - any authenticated user
Flight::route('POST /saved_searches', function() {
    requireUserOrAdmin();
    AuthMiddleware::validateJson(['user_id', 'search_query']);
    $controller = new SavedSearchesController();
    $controller->createSavedSearch();
});

// Get saved searches by user - user or admin
Flight::route('GET /saved_searches/@user_id', function($user_id) {
    AuthMiddleware::requireUser();
    if (!AuthMiddleware::isAdmin() && AuthMiddleware::getUserId() != $user_id) {
        Flight::halt(403, json_encode(['error' => 'Access denied']));
    }
    $controller = new SavedSearchesController();
    $controller->getSavedSearchesByUserId($user_id);
});

// Update saved search - user or admin
Flight::route('PUT /saved_searches/@id', function($id) {
    requireUserOrAdmin();
    AuthMiddleware::validateJson(['search_query']);
    $controller = new SavedSearchesController();
    $controller->updateSavedSearch($id);
});

// Delete saved search - user or admin
Flight::route('DELETE /saved_searches/@id', function($id) {
    requireUserOrAdmin();
    $controller = new SavedSearchesController();
    $controller->deleteSavedSearch($id);
});

// ------------------
// Users

// Get user by id - user themselves or admin
Flight::route('GET /users/@id', function($id) {
    AuthMiddleware::requireUser();
    if (!AuthMiddleware::isAdmin() && AuthMiddleware::getUserId() != $id) {
        Flight::halt(403, json_encode(['error' => 'Access denied']));
    }
    $controller = new UserController();
    $controller->getUserById($id);
});

// Update user - user themselves or admin
Flight::route('PUT /users/@id', function($id) {
    AuthMiddleware::requireUser();
    if (!AuthMiddleware::isAdmin() && AuthMiddleware::getUserId() != $id) {
        Flight::halt(403, json_encode(['error' => 'Access denied']));
    }
    AuthMiddleware::validateJson(['email']);
    $controller = new UserController();
    $controller->updateUser($id);
});

// Delete user - only admin
Flight::route('DELETE /users/@id', function($id) {
    requireAdmin();
    $controller = new UserController();
    $controller->deleteUser($id);
});

// ------------------
// User Profiles

// Create profile - user themselves or admin
Flight::route('POST /user_profiles', function() {
    requireUserOrAdmin();
    AuthMiddleware::validateJson(['user_id', 'bio']);
    $controller = new UserProfilesController();
    $controller->createProfile();
});

// Get profile - user themselves or admin
Flight::route('GET /user_profiles/@user_id', function($user_id) {
    AuthMiddleware::requireUser();
    if (!AuthMiddleware::isAdmin() && AuthMiddleware::getUserId() != $user_id) {
        Flight::halt(403, json_encode(['error' => 'Access denied']));
    }
    $controller = new UserProfilesController();
    $controller->getProfile($user_id);
});

// Update profile - user themselves or admin
Flight::route('PUT /user_profiles/@id', function($id) {
    requireUserOrAdmin();
    AuthMiddleware::validateJson(['bio']);
    $controller = new UserProfilesController();
    $controller->updateProfile($id);
});

// Delete profile - user themselves or admin
Flight::route('DELETE /user_profiles/@id', function($id) {
    requireUserOrAdmin();
    $controller = new UserProfilesController();
    $controller->deleteProfile($id);
});

// ------------------
// Swagger API docs

Flight::route('GET /docs', function() {
    require 'swagger-ui.php';
});
Flight::route('GET /generate-docs', function() {
    require 'generate-docs.php';
});

// ------------------
// Start the Flight app
Flight::start();
