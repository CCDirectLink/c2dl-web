<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');
require_once( getenv('C2DL_SYS', true) . '/repository/Structure.php');
require_once( getenv('C2DL_SYS', true) . '/repository/IAccount.php');

require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseTable.php');
require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumn.php');
require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumnStringSizeConstraints.php');
require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumnStringRegexConstraints.php');

require_once( getenv('C2DL_SYS', true) . '/error/NoDatabaseException.php');
require_once( getenv('C2DL_SYS', true) . '/error/TypeException.php');
require_once( getenv('C2DL_SYS', true) . '/error/RequestException.php');

require_once( getenv('C2DL_SYS', true) . '/logger/Log.php');

use c2dl\sys\err\RequestException;
use c2dl\sys\err\TypeException;
use c2dl\sys\err\NoDatabaseException;

use c2dl\sys\log\Log;
use c2dl\sys\service\GeneralService;
use \PDO;

/*
 * Account Repository (singleton)
 */
class Account implements IAccount {

    private static $_instance;

    private $_pdo;
    private $_tableStructure;

    /*
     * Get Account repository instance
     * @param string|null $dbEntry database name
     * @return Account Account repository
     */
    public static function getInstance($dbEntry = 'acc'): IAccount {
        if(!self::$_instance) {
            self::$_instance = new self($dbEntry);
        }
        return self::$_instance;
    }

    /*
     * Constructor
     * @param string|null $dbEntry database name
     * @return Account Account repository
     */
    private function __construct($dbEntry = 'acc') {
        $this->_tableStructure = [
            'user' => DatabaseTable::create('acc_user', // name
                DatabaseColumn::create('id', PDO::PARAM_INT), [ // key
                    // data
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
            'auth' => DatabaseTable::create('acc_auth', // name
                DatabaseColumn::create('id', PDO::PARAM_INT), [ // key
                    // data
                    'userId' => DatabaseColumn::create('userId', PDO::PARAM_INT),
                    'mainAuth' => DatabaseColumn::create('mainAuth', PDO::PARAM_INT),
                    'required' => DatabaseColumn::create('required', PDO::PARAM_INT),
                    'type' => DatabaseColumn::create(
                        'type', PDO::PARAM_STR, [DatabaseColumnStringSizeConstraints::create(1, 32)]
                    ),
                    'data' => DatabaseColumn::create('data', PDO::PARAM_LOB)
            ]),
            'linked' => DatabaseTable::create('acc_linked', // name
                DatabaseColumn::create('userId', PDO::PARAM_INT), [ // key
                    // data
                    'facebook' => DatabaseColumn::create('facebook', PDO::PARAM_INT),
                    'google' => DatabaseColumn::create('google', PDO::PARAM_INT),
                    'github' => DatabaseColumn::create('github', PDO::PARAM_INT),
                    'gitlab' => DatabaseColumn::create('gitlab', PDO::PARAM_INT),
                    'discord' => DatabaseColumn::create('discord', PDO::PARAM_INT)
            ])
        ];

        $this->_pdo = Database::getInstance()->getConnection($dbEntry);
    }

    /*
     * No Clone
     */
    private function __clone() { }

    /*
     * Check if linked type (facebook, ...) is in database structure
     * @param DatabaseColumn[] $dbStructure database structure
     * @param string $type linked type
     * @return DatabaseColumn|null null if not in structure
     */
    static private function _typeCheck($dbStructure, $type): ?DatabaseColumn {
        foreach ($dbStructure as &$entry) {
            if (GeneralService::stringsEqual($type, $entry->name())) {
                return $entry;
            }
        }
        return null;
    }

    /*
     * Get userData by userId
     * id (int), user (string), mail (string|null), mailValid (bool), mailLogin (bool), active (bool)
     *
     * @param int $id User Id
     * @return mixed[] User data
     */
    public function getUserDataByUserId($id): ?iterable {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if (!isset($id)) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'id' => gettype($id)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_userTable = $this->_tableStructure['user'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_userTable->name(),
            Structure::prepareStatementString(array($_userTable->key())),
            array($_userTable->key()), array($id));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }

        return $result;
    }

    /*
     * Get userId by username
     * @param string $username Username
     * @return int User Id
     */
    public function getUserIdByUsername($username): ?int {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if (!isset($username)) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'username' => gettype($username)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_userTable = $this->_tableStructure['user'];

        $result = Structure::executeSelectPDO($this->_pdo, $_userTable->key()->name(), $_userTable->name(),
            Structure::prepareStatementString(array($_userTable->data()['user'])),
            array($_userTable->data()['user']), array($username));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }
        if (!GeneralService::inArray($_userTable->key()->name(), $result, true)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No username');
        }

        return $result[$_userTable->key()->name()];
    }

    /*
     * Get userId by mail
     * @param string $mail Mail
     * @return int User Id
     */
    public function getUserIdByMail($mail): ?int {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if (!isset($mail)) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'mail' => gettype($mail)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_userTable = $this->_tableStructure['user'];

        $result = Structure::executeSelectPDO($this->_pdo, $_userTable->key()->name(), $_userTable->name(),
            Structure::prepareStatementString(array($_userTable->data()['mail'])),
            array($_userTable->data()['mail']), array($mail));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }
        if (!GeneralService::inArray($_userTable->key()->name(), $result, true)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No mail');
        }

        return $result[$_userTable->key()->name()];
    }

    /*
     * Get linkedData by userId
     * userId (int), facebook (int), google (int), github (int), gitlab (int), discord (int)
     *
     * @param int $id user Id
     * @return mixed[] linked data
     */
    public function getLinkedByUserId($id): ?iterable {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if (!isset($id)) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'id' => gettype($id)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_linkedTable = $this->_tableStructure['linked'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_linkedTable->name(),
            Structure::prepareStatementString(array($_linkedTable->key())),
            array($_linkedTable->key()), array($id));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }

        return $result;
    }

    /*
     * Check if linked type (facebook, ...) exist for user id
     * @param int $id user id
     * @param string $type linked type
     * @return bool true if exist
     */
    public function hasLinkedByUserId($id, $type): ?bool {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if ((!isset($id)) || (!isset($type))) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'id' => gettype($id),
                'type' => gettype($type)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_linkedTable = $this->_tableStructure['linked'];
        $_type = self::_typeCheck($_linkedTable->data(), $type);
        $result = Structure::executeSelectPDO($this->_pdo, $_type->name(), $_linkedTable->name(),
            Structure::prepareStatementString(array($_linkedTable->key())),
            array($_linkedTable->key()), array($id));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }

        if (!GeneralService::inArray($_type->name(), $result, true)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No id');
        }

        if ($result[$_type->name()] === null) {
            return false;
        }

        return true;
    }

    /*
     * Get user id by linked entry
     * @param string $type linked type
     * @param int $linked linked id
     * @return int user id
     */
    public function getUserIdByLinked($type, $linked): int {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if ((!isset($type)) || (!isset($linked))) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'type' => gettype($type),
                'linked' => gettype($linked)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_linkedTable = $this->_tableStructure['linked'];
        $_type = self::_typeCheck($_linkedTable->data(), $type);
        $result = Structure::executeSelectPDO($this->_pdo, $_linkedTable->key()->name(), $_linkedTable->name(),
            Structure::prepareStatementString(array($_type)),
            array($_type), array($linked));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }
        if (!GeneralService::inArray($_linkedTable->key()->name(), $result, true)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No id');
        }

        return $result[$_linkedTable->key()->name()];
    }

    /*
     * Get auth data by user id
     * @param int $id user id
     * @return mixed[] auth data
     */
    public function getAuthByUserId($id): iterable {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if (!isset($id)) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'id' => gettype($id)
            ]);
            throw new TypeException('Param not set', 1);
        }

        $_authTable = $this->_tableStructure['auth'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_authTable->name(),
            Structure::prepareStatementString(array($_authTable->data()['userId'])),
            array($_authTable->data()['userId']), array($id), true);

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
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

    /*
     * Validate auth data
     * @param int $id user id
     * @param mixed $auth auth data
     * @param callable $function auth validator
     * @return bool true if auth successful
     */
    public function validateAuthByAuthId($id, $auth, $function): bool {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if ((!isset($id)) || (!isset($auth)) || (!isset($function))) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'id' => gettype($id),
                'auth' => gettype($auth),
                'function' => gettype($function)
            ]);
            throw new TypeException('Param not set', 1);
        }
        if (!is_callable($function)) {
            $log->error(__FUNCTION__ . ' param function not callable', [
                'exception' => 'TypeException',
                'function' => $function
            ]);
            throw new TypeException('Param with invalid type: function not callable', 2);
        }

        $_authTable = $this->_tableStructure['auth'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_authTable->name(),
            Structure::prepareStatementString(array($_authTable->key())),
            array($_authTable->key()), array($id));

        if (!isset($result)) {
            $log->error(__FUNCTION__ . ' No result', [
                'exception' => 'RequestException'
            ]);
            throw new RequestException('Database request failed: No result');
        }

        $valResult = $function($result[$_authTable->data()['type']->name()],
            $auth,
            $result[$_authTable->data()['data']->name()]);

        $log->info(__FUNCTION__, [
            'valid' => $valResult
        ]);

        return $valResult;
    }

    /*
     * Set user data
     * @param int $id user id
     * @param mixed[] $data user data
     * @return mixed[] new user data
     */
    public function setUserData($id, $data): iterable {
        $log = Log::getInstance()->getLogger('db');

        if (is_null($this->_pdo)) {
            $log->error(__FUNCTION__ . ' No PDO', [
                'exception' => 'NoDatabaseException'
            ]);
            throw new NoDatabaseException('PDO not set');
        }
        if ((!isset($id)) || (!isset($data))) {
            $log->error(__FUNCTION__ . ' Param not set', [
                'exception' => 'TypeException',
                'id' => gettype($id),
                'data' => gettype($data)
            ]);
            throw new TypeException('Param not set or types invalid', 1);
        }

        $_userTable = $this->_tableStructure['user'];
        $_setList = Structure::prepareStatementStringFilter($_userTable->data(), $data);

        // exception handling in service/UI
        Structure::executeUpdatePDO($this->_pdo, $_userTable->name(), $_setList,
            Structure::prepareStatementString(array($_userTable->key())), $_userTable->allColumns(),
            array_merge($data, array($_userTable::PRIMARY => $id)));

        return $this->getUserDataByUserId($id);
    }

    /*
     * Set link data
     * @param int $id user id
     * @param string $type link type
     * @param int $data link data
     * @return mixed[] new link data
     */
    public function setLink($id, $type, $data): iterable {

    }

    /*
     * Set auth data
     * @param int $id user id
     * @param mixed[] $data auth data
     */
    public function setAuth($id, $data): void {

    }

    /*
     * Add user data
     * @param mixed[] $data user data
     * @return mixed[] created user data
     */
    public function addUser($data): iterable {

    }

    /*
     * Add auth data
     * @param int $userId user id
     * @param mixed[] $data auth data
     * @return mixed[] created user data
     */
    public function addAuth($userId, $data): iterable {

    }

    /*
     * Remove user
     * @param int $id user id
     * @return mixed[] user data
     */
    public function removeUser($id): iterable {

    }

}
