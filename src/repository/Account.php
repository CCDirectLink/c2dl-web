<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');
require_once( getenv('C2DL_SYS', true) . '/repository/Structure.php');

use c2dl\sys\service\GeneralService;
use \PDO;
use \PDOException;

class Account {

    private static $_instance;

    private $_pdo;
    private $_tableStructure;

    public static function getInstance($dbEntry = 'acc'): Account {
        if(!self::$_instance) {
            self::$_instance = new self($dbEntry);
        }
        return self::$_instance;
    }

    private function __construct($dbEntry = 'acc') {
        $this->_tableStructure = [
            'user' => DatabaseTable::create('acc_user',
                DatabaseColumn::create('id', PDO::PARAM_INT), [
                    'user' => DatabaseColumn::create(
                        'user', PDO::PARAM_STR, [DatabaseColumnStringSizeConstraints::create(3, 32)]
                    ),
                    'mail' => DatabaseColumn::create(
                        'mail', PDO::PARAM_STR, [DatabaseColumnStringSizeConstraints::create(5, 64)]
                    ),
                    'mailValid' => DatabaseColumn::create('mailValid', PDO::PARAM_BOOL),
                    'mailLogin' => DatabaseColumn::create('mailLogin', PDO::PARAM_BOOL),
                    'active' => DatabaseColumn::create('active', PDO::PARAM_BOOL)
            ]),
            'auth' => DatabaseTable::create('acc_auth',
                DatabaseColumn::create('id', PDO::PARAM_INT), [
                    'userId' => DatabaseColumn::create('userId', PDO::PARAM_INT),
                    'mainAuth' => DatabaseColumn::create('mainAuth', PDO::PARAM_INT),
                    'required' => DatabaseColumn::create('required', PDO::PARAM_INT),
                    'type' => DatabaseColumn::create(
                        'type', PDO::PARAM_STR, [DatabaseColumnStringSizeConstraints::create(1, 32)]
                    ),
                    'data' => DatabaseColumn::create('data', PDO::PARAM_LOB)
            ]),
            'linked' => DatabaseTable::create('acc_linked',
                DatabaseColumn::create('userId', PDO::PARAM_INT), [
                    'facebook' => DatabaseColumn::create('facebook', PDO::PARAM_INT),
                    'google' => DatabaseColumn::create('google', PDO::PARAM_INT),
                    'github' => DatabaseColumn::create('github', PDO::PARAM_INT),
                    'gitlab' => DatabaseColumn::create('gitlab', PDO::PARAM_INT),
                    'discord' => DatabaseColumn::create('discord', PDO::PARAM_INT)
            ])
        ];

        $this->_pdo = Database::getInstance()->getConnection($dbEntry);
    }

    private function __clone() { }



    public function getUserDataByUserId($id): ?iterable {
        if ((!isset($id)) || (is_null($this->_pdo))) {
            return null;
        }

        $_userTable = $this->_tableStructure['user'];
        return Structure::executeSelectPDO($this->_pdo, '*', $_userTable->name(),
            Structure::prepareStatementString(array($_userTable->key())),
            array($_userTable->key()), array($id));
    }

    public function getUserIdByUsername($username): ?int {
        if ((!isset($username)) || (is_null($this->_pdo))) {
            return null;
        }

        $_userTable = $this->_tableStructure['user'];
        $result = Structure::executeSelectPDO($this->_pdo, $_userTable->key()->name(), $_userTable->name(),
            Structure::prepareStatementString(array($_userTable->data()['user'])),
            array($_userTable->data()['user']), array($username));

        if (!isset($result)) {
            return null;
        }

        return $result[$_userTable->key()->name()];
    }

    public function getUserIdByMail($mail): ?int {
        if ((!isset($mail)) || (is_null($this->_pdo))) {
            return null;
        }

        $_userTable = $this->_tableStructure['user'];

        $result = Structure::executeSelectPDO($this->_pdo, $_userTable->key()->name(), $_userTable->name(),
            Structure::prepareStatementString(array($_userTable->data()['mail'])),
            array($_userTable->data()['mail']), array($mail));

        if (!isset($result)) {
            return null;
        }

        return $result[$_userTable->key()->name()];
    }

    public function getLinkedByUserId($id): ?iterable {
        if ((!isset($id)) || (is_null($this->_pdo))) {
            return null;
        }

        $_linkedTable = $this->_tableStructure['linked'];
        return Structure::executeSelectPDO($this->_pdo, '*', $_linkedTable->name(),
            Structure::prepareStatementString(array($_linkedTable->key())),
            array($_linkedTable->key()), array($id));
    }

    static private function _typeCheck($dbStructure, $type): ?DatabaseColumn {
        foreach ($dbStructure as &$entry) {
            if (GeneralService::stringsEqual($type, $entry->name())) {
                return $entry;
            }
        }
        return null;
    }

    public function hasLinkedByUserId($id, $type): ?bool {
        if ((!isset($id)) || (!isset($type)) || (is_null($this->_pdo))) {
            return null;
        }

        $_linkedTable = $this->_tableStructure['linked'];
        $_type = self::_typeCheck($_linkedTable->data(), $type);
        $result = Structure::executeSelectPDO($this->_pdo, $_type->name(), $_linkedTable->name(),
            Structure::prepareStatementString(array($_linkedTable->key())),
            array($_linkedTable->key()), array($id));

        if ($result[$_type->name()] === null) {
            return false;
        }

        return true;
    }

    public function getUserIdByLinked($type, $linked): ?int {
        if ((!isset($type)) || (!isset($linked)) || (is_null($this->_pdo))) {
            return null;
        }

        $_linkedTable = $this->_tableStructure['linked'];
        $_type = self::_typeCheck($_linkedTable->data(), $type);
        $result = Structure::executeSelectPDO($this->_pdo, $_linkedTable->key()->name(), $_linkedTable->name(),
            Structure::prepareStatementString(array($_type)),
            array($_type), array($linked));

        return $result[$_linkedTable->key()->name()];
    }

    public function getAuthByUserId($id): ?iterable {
        if ((!isset($id)) || (is_null($this->_pdo))) {
            return null;
        }

        $_authTable = $this->_tableStructure['auth'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_authTable->name(),
            Structure::prepareStatementString(array($_authTable->data()['userId'])),
            array($_authTable->data()['userId']), array($id), true);

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
        if ((!isset($id)) || (!isset($auth)) || (!isset($function)) ||
            (!is_callable($function)) || (is_null($this->_pdo))) {
            return null;
        }

        $_authTable = $this->_tableStructure['auth'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_authTable->name(),
            Structure::prepareStatementString(array($_authTable->key())),
            array($_authTable->key()), array($id));

        if (!isset($result)) {
            return null;
        }

        return $function($result[$_authTable->data()['type']->name()],
            $auth,
            $result[$_authTable->data()['data']->name()]);
    }

    public function setUserData($id, $data): iterable {
        if ((!isset($id)) || (!isset($data)) || (is_null($this->_pdo))) {
            return null;
        }

        $_setList = Structure::prepareStatementStringFilter($this->_tableStructure['user']->data(), $data);

        // executeUpdatePDO

        var_dump($_setList);
        return array();

        $_tableId = 'id';

        $result = null;
        try {
            $_statement = $this->_pdo->prepare(
                'UPDATE ' . $this->_tableUser . ' SET ' . $_setList . ' WHERE ' . $_tableId . ' = :id'
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

    public function setLink($id, $type, $data): iterable {

    }

    public function setAuth($id, $data): void {

    }

    public function addUser($data): iterable {

    }

    public function addAuth($userId, $data): void {

    }

    public function removeUser($id): iterable {

    }

}
