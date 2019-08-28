<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');

use c2dl\sys\service\GeneralService;
use \PDO;
use \PDOException;

class Account {

    private static $_instance;

    private $_pdo;
    private $_tableUser;
    private $_tableAuth;
    private $_tableSessions;
    private $_tableGroups;
    private $_tableHistory;
    private $_tableLinked;

    private $_tableUserRights;
    private $_tableGroupRights;

    public static function getInstance($dbEntry = 'acc'): Account {
        if(!self::$_instance) {
            self::$_instance = new self($dbEntry);
        }
        return self::$_instance;
    }

    private function __construct($dbEntry = 'acc') {
        $this->_tableUser = 'acc_user';
        $this->_tableAuth = 'acc_auth';
        $this->_tableSessions = 'acc_sessions';
        $this->_tableGroups = 'acc_groups';
        $this->_tableHistory = 'acc_history';
        $this->_tableLinked = 'acc_linked';

        $this->_tableUserRights = 'acc_user_rights';
        $this->_tableGroupRights = 'acc_group_rights';

        $this->_pdo = Database::getInstance()->getConnection($dbEntry);
    }

    private function __clone() { }

    public function getUserDataByUserId($id): ?iterable {
        $_tableId = 'id';
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT * FROM ' . $this->_tableUser . ' WHERE ' . $_tableId . ' = :id'
            );
            $_statement->bindParam(':id', $id, PDO::PARAM_INT);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $result;
    }

    public function getUserIdByUsername($username): ?int {
        $_tableId = 'id';
        $_tableUser = 'user';
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT ' . $_tableId . ' FROM ' . $this->_tableUser . ' WHERE ' . $_tableUser . ' = :username'
            );
            $_statement->bindParam(':username', $username, PDO::PARAM_STR);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $result[$_tableId];
    }

    public function getUserIdByMail($mail): ?int {
        $_tableId = 'id';
        $_tableMail = 'mail';
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT ' . $_tableId . ' FROM ' . $this->_tableUser . ' WHERE ' . $_tableMail . ' = :mail'
            );
            $_statement->bindParam(':mail', $mail, PDO::PARAM_STR);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $result[$_tableId];
    }

    public function getLinkedByUserId($id): ?iterable {
        $_tableId = 'userId';
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT * FROM ' . $this->_tableLinked . ' WHERE ' . $_tableId . ' = :id'
            );
            $_statement->bindParam(':id', $id, PDO::PARAM_INT);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $result;
    }

    static private function _typeCheck($type): ?string {
        if (GeneralService::stringsEqual($type, 'facebook')) {
            return 'facebook';
        }
        else if (GeneralService::stringsEqual($type, 'google')) {
            return 'google';
        }
        else if (GeneralService::stringsEqual($type, 'github')) {
            return 'github';
        }
        else if (GeneralService::stringsEqual($type, 'gitlab')) {
            return 'gitlab';
        }
        else if (GeneralService::stringsEqual($type, 'discord')) {
            return 'discord';
        }
        return null;
    }

    public function hasLinkedByUserId($id, $type): ?bool {
        $_tableId = 'userId';
        $_type = self::_typeCheck($type);
        if ($_type === null) {
            return null;
        }
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT ' . $_type . ' FROM ' . $this->_tableLinked . ' WHERE ' . $_tableId . ' = :id'
            );
            $_statement->bindParam(':id', $id, PDO::PARAM_INT);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        if ($result[$_type] === null) {
            return false;
        }

        return true;
    }

    public function getUserIdByLinked($type, $linked): ?int {
        $_tableId = 'userId';
        $_type = self::_typeCheck($type);
        if ($_type === null) {
            return null;
        }
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT ' . $_tableId . ' FROM ' . $this->_tableLinked . ' WHERE ' . $_type . ' = :linked'
            );
            $_statement->bindParam(':linked', $linked, PDO::PARAM_INT);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $result[$_tableId];
    }

    public function getAuthByUserId($id): ?iterable {
        $_tableId = 'userId';
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT * FROM ' . $this->_tableAuth . ' WHERE ' . $_tableId . ' = :id'
            );
            $_statement->bindParam(':id', $id, PDO::PARAM_INT);
            $_statement->execute();
            $result = $_statement->fetchAll();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || (empty($result))) {
            return null;
        }

        $_resArray = array();

        foreach ($result as &$row) {
            $_resArray[$row['id']] = array(
                'mainAuth' => $row['mainAuth'],
                'required' => $row['required'],
                'type' => $row['type']
            );
        }

        return $_resArray;
    }

    public function validateAuthByAuthId($id, $auth, $function): ?bool {
        $_tableId = 'id';
        $_tableTypeEntry = 'type';
        $_privateDataEntry = 'data';
        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'SELECT ' . $_privateDataEntry . ', ' . $_tableTypeEntry . ' FROM ' .
                $this->_tableAuth . ' WHERE ' . $_tableId . ' = :id'
            );
            $_statement->bindParam(':id', $id, PDO::PARAM_INT);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $function($result[$_tableTypeEntry], $auth, $result[$_privateDataEntry]);
    }

    public function setUserData($id, $data): iterable {

    }

    public function setLink($id, $type, $data): iterable {

    }

    public function setAuth($id, $data): void {

    }

    public function addUser($data): iterable {

    }

    public function addAuth($userId, $data): void {

    }

}
