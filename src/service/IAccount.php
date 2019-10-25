<?php namespace c2dl\sys\db;

/*
 * Account Repository (singleton)
 */
interface IAccount {

    /*
     * Get Account repository instance
     * @param string|null $dbEntry database name
     * @return Account Account repository
     */
    public static function getInstance($dbEntry = 'acc'): IAccount;

    /*
     * Test only
     * @param PDO $dummyPdo database
     * @param Log $logger logger
     * @return Account Account repository
     */
    public static function createTestDummy($dummyPdo, $logger,
                                           $select, $update, $prepareStatement, $filter): IAccount;

    /*
     * Get userData by userId
     * id (int), user (string), mail (string|null), mailValid (bool), mailLogin (bool), active (bool)
     *
     * @param int $id User Id
     * @return mixed[] User data
     */
    public function getUserDataByUserId($id): ?iterable;

    /*
     * Get userId by username
     * @param string $username Username
     * @return int User Id
     */
    public function getUserIdByUsername($username): ?int;

    /*
     * Get userId by mail
     * @param string $mail Mail
     * @return int User Id
     */
    public function getUserIdByMail($mail): ?int;

    /*
     * Get linkedData by userId
     * userId (int), facebook (int), google (int), github (int), gitlab (int), discord (int)
     *
     * @param int $id user Id
     * @return mixed[] linked data
     */
    public function getLinkedByUserId($id): ?iterable;

    /*
     * Check if linked type (facebook, ...) exist for user id
     * @param int $id user id
     * @param string $type linked type
     * @return bool true if exist
     */
    public function hasLinkedByUserId($id, $type): ?bool;

    /*
     * Get user id by linked entry
     * @param string $type linked type
     * @param int $linked linked id
     * @return int user id
     */
    public function getUserIdByLinked($type, $linked): ?int;

    /*
     * Get auth data by user id
     * @param int $id user id
     * @return mixed[] auth data
     */
    public function getAuthByUserId($id): ?iterable;

    /*
     * Validate auth data
     * @param int $id user id
     * @param mixed $auth auth data
     * @param callable $function auth validator
     * @return bool true if auth successful
     */
    public function validateAuthByAuthId($id, $auth, $function): ?bool;

    /*
     * Set user data
     * @param int $id user id
     * @param mixed[] $data user data
     * @return mixed[] new user data
     */
    public function setUserData($id, $data): iterable;

    /*
     * Set link data
     * @param int $id user id
     * @param string $type link type
     * @param int $data link data
     * @return mixed[] new link data
     */
    public function setLink($id, $type, $data): iterable;

    /*
     * Set auth data
     * @param int $id user id
     * @param mixed[] $data auth data
     */
    public function setAuth($id, $data): void;

    /*
     * Add user data
     * @param mixed[] $data user data
     * @return mixed[] created user data
     */
    public function addUser($data): iterable;

    /*
     * Add auth data
     * @param int $userId user id
     * @param mixed[] $data auth data
     * @return mixed[] created user data
     */
    public function addAuth($userId, $data): iterable;

    /*
     * Remove user
     * @param int $id user id
     * @return mixed[] user data
     */
    public function removeUser($id): iterable;

    /*
     * Remove user
     * @param int $id user id
     * @return mixed[] user data
     */
    public function removeAuth($id): iterable;

}
