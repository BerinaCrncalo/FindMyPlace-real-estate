<?php
require 'vendor/autoload.php';

// FlightPHP Database Connection
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=FindMyPlace', 'root', 'database1'));

// Register DAOs
require_once "dao/BaseDao.php";
require_once 'dao/CategoryDao.php';
require_once 'dao/ContactMessageDao.php';
require_once 'dao/FavoritesDao.php';
require_once 'dao/ListingImageDao.php';
require_once 'dao/ListingsDao.php';
require_once 'dao/SavedSearchesDao.php';
require_once 'dao/UserDao.php';
require_once 'dao/UserProfilesDao.php';

// Register Services
require_once 'services/CategoryService.php';
require_once 'services/ContactMessageService.php';
require_once 'services/FavoritesService.php';
require_once 'services/ListingImageService.php';
require_once 'services/ListingsService.php';
require_once 'services/SavedSearchesService.php';
require_once 'services/UserService.php';
require_once 'services/UserProfilesService.php';

// Register Controllers
require_once 'controllers/CategoryController.php';
require_once 'controllers/ContactMessageController.php';
require_once 'controllers/FavoritesController.php';
require_once 'controllers/ListingImageController.php';
require_once 'controllers/ListingsController.php';
require_once 'controllers/SavedSearchesController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/UserProfilesController.php';

// Routes for Categories
Flight::route('POST /categories', [CategoryController::class, 'createCategory']);
Flight::route('GET /categories', [CategoryController::class, 'getAllCategories']);
Flight::route('GET /categories/@id', [CategoryController::class, 'getCategoryById']);
Flight::route('PUT /categories/@id', [CategoryController::class, 'updateCategory']);
Flight::route('DELETE /categories/@id', [CategoryController::class, 'deleteCategory']);

// Routes for Contact Messages
Flight::route('POST /contact_messages', [ContactMessageController::class, 'createContactMessage']);
Flight::route('GET /contact_messages', [ContactMessageController::class, 'getAllContactMessages']);
Flight::route('GET /contact_messages/@id', [ContactMessageController::class, 'getContactMessageById']);
Flight::route('PUT /contact_messages/@id', [ContactMessageController::class, 'updateContactMessage']);
Flight::route('DELETE /contact_messages/@id', [ContactMessageController::class, 'deleteContactMessage']);

// Routes for Favorites
Flight::route('POST /favorites', [FavoritesController::class, 'addToFavorites']);
Flight::route('GET /favorites/user/@user_id', [FavoritesController::class, 'getFavoritesByUserId']);
Flight::route('DELETE /favorites/@id', [FavoritesController::class, 'removeFromFavorites']);

// Routes for Listing Images
Flight::route('POST /listing_images', [ListingImageController::class, 'addImageToListing']);
Flight::route('GET /listing_images', [ListingImageController::class, 'getAllImages']);
Flight::route('GET /listing_images/@id', [ListingImageController::class, 'getImageById']);
Flight::route('PUT /listing_images/@id', [ListingImageController::class, 'updateImage']);
Flight::route('DELETE /listing_images/@id', [ListingImageController::class, 'deleteImage']);

// Routes for Listings
Flight::route('POST /listings', [ListingsController::class, 'createListing']);
Flight::route('GET /listings', [ListingsController::class, 'getAllListings']);
Flight::route('GET /listings/@id', [ListingsController::class, 'getListingById']);
Flight::route('PUT /listings/@id', [ListingsController::class, 'updateListing']);
Flight::route('DELETE /listings/@id', [ListingsController::class, 'deleteListing']);

// Routes for Saved Searches
Flight::route('POST /saved_searches', [SavedSearchesController::class, 'createSavedSearch']);
Flight::route('GET /saved_searches/@user_id', [SavedSearchesController::class, 'getSavedSearchesByUserId']);
Flight::route('PUT /saved_searches/@id', [SavedSearchesController::class, 'updateSavedSearch']);
Flight::route('DELETE /saved_searches/@id', [SavedSearchesController::class, 'deleteSavedSearch']);

// Routes for Users
Flight::route('POST /users', [UserController::class, 'registerUser']);
Flight::route('GET /users/@id', [UserController::class, 'getUserById']);
Flight::route('PUT /users/@id', [UserController::class, 'updateUser']);
Flight::route('DELETE /users/@id', [UserController::class, 'deleteUser']);

// Routes for User Profiles
Flight::route('POST /user_profiles', [UserProfilesController::class, 'createProfile']);
Flight::route('GET /user_profiles/@user_id', [UserProfilesController::class, 'getProfile']);
Flight::route('PUT /user_profiles/@id', [UserProfilesController::class, 'updateProfile']);
Flight::route('DELETE /user_profiles/@id', [UserProfilesController::class, 'deleteProfile']);

// Route to display Swagger UI page
Flight::route('GET /docs', function() {
    require 'swagger-ui.php';  // This will display the Swagger UI page
});

// Route to generate OpenAPI documentation (Swagger JSON)
Flight::route('GET /generate-docs', function() {
    require 'generate-docs.php';  // This will generate and output the OpenAPI JSON
});

// Start FlightPHP Application
Flight::start();
?>
