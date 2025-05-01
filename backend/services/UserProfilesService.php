<?php
require_once 'UserProfilesDao.php';

class UserProfilesService {
    private $userProfilesDao;

    public function __construct() {
        $this->userProfilesDao = new UserProfilesDao();
    }

    public function getProfileByUserId($user_id) {
        return $this->userProfilesDao->getByUserId($user_id);
    }

    public function createProfile($data) {
        return $this->userProfilesDao->create($data);
    }

    public function updateProfile($id, $data) {
        return $this->userProfilesDao->update($id, $data);
    }

    public function deleteProfile($id) {
        return $this->userProfilesDao->delete($id);
    }
}
?>
