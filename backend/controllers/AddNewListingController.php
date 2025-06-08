<?php
class AddNewListingController
{
    public static function createListingFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed']);
            return;
        }

        header('Content-Type: application/json');

        // Extract and sanitize POST data
        $title = isset($_POST['title']) ? trim($_POST['title']) : null;
        $details = isset($_POST['details']) ? trim($_POST['details']) : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $location = isset($_POST['location']) ? trim($_POST['location']) : null;

        // Validate required fields
        if (!$title || !$details || !$price || !$location) {
            http_response_code(400);
            echo json_encode(['message' => 'All fields are required']);
            return;
        }

        // Validate length constraints
        if (mb_strlen($title) > 100) {
            http_response_code(400);
            echo json_encode(['message' => 'Title exceeds maximum length of 100']);
            return;
        }
        if (mb_strlen($details) > 500) {
            http_response_code(400);
            echo json_encode(['message' => 'Details exceed maximum length of 500']);
            return;
        }
        if (mb_strlen($location) > 100) {
            http_response_code(400);
            echo json_encode(['message' => 'Location exceeds maximum length of 100']);
            return;
        }

        // Validate price
        if (!is_numeric($price) || floatval($price) < 0) {
            http_response_code(400);
            echo json_encode(['message' => 'Price must be a positive number']);
            return;
        }
        $price = floatval($price);

        // XSS prevention: block basic HTML/script patterns in inputs
        $xssPattern = '/<[^>]*script|on\w+=|javascript:/i';
        if (preg_match($xssPattern, $title) || preg_match($xssPattern, $details) || preg_match($xssPattern, $location)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input: HTML or JavaScript not allowed']);
            return;
        }

        // Validate and handle file upload
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['message' => 'Photo upload failed or missing']);
            return;
        }

        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = basename($_FILES['photo']['name']);
        $fileSize = $_FILES['photo']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedMimeTypes)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid image format. Only JPG, PNG, GIF allowed']);
            return;
        }

        if ($fileSize > 5 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode(['message' => 'Image file too large (max 5MB)']);
            return;
        }

        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $newFileName = uniqid('listing_') . '-' . preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);
        $destPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to save uploaded photo']);
            return;
        }

        // Save listing securely - ListingsService should use prepared statements internally
        try {
            $listingsService = new ListingsService();

            $listingsService->createListing([
                'title' => htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),  // sanitize output
                'description' => htmlspecialchars($details, ENT_QUOTES, 'UTF-8'),
                'price' => $price,
                'location' => htmlspecialchars($location, ENT_QUOTES, 'UTF-8'),
                'photo_path' => '/uploads/' . $newFileName,
            ]);

            http_response_code(201);
            echo json_encode(['message' => 'Listing created successfully']);
        } catch (Exception $e) {
            // Delete uploaded file on error to avoid orphan files
            if (file_exists($destPath)) {
                unlink($destPath);
            }

            http_response_code(500);
            echo json_encode(['message' => 'Error creating listing: ' . $e->getMessage()]);
        }
    }
}
?>
