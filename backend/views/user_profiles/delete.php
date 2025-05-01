<?php
Flight::route('GET /user_profile/delete/@id', function($id) {
    // Delete the profile from the database
    $userProfilesDao = new UserProfilesDao();
    $userProfilesDao->delete($id);

    // Redirect to the profile index page after deletion
    Flight::redirect('/user_profiles');
});
?>
