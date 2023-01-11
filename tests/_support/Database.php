<?php

/**
 * Class Database
 */
class Database
{
    const NG_CONNECTION = 'ng';
    const NGU_CONNECTION = 'ngu';

    const DB_CONNECTIONS = [
        self::NG_CONNECTION => [
            'host' => '127.0.0.1',
            'charset' => 'utf8mb4',
            'user' => 'user',
            'pass' => 'password',
            'name' => 'ng_development',
        ],
        self::NGU_CONNECTION => [
            'host' => '127.0.0.1',
            'charset' => 'utf8mb4',
            'user' => 'user',
            'pass' => 'password',
            'name' => 'ngu_development',
        ],
    ];

    protected $status = false;
    protected $msg = '';

    /** @var PDO $pdo */
    protected $pdo = null;

    /**
     * @param string $connections
     * @return self
     */
    public static function connections($connections)
    {
        $self = new self;
        $config = self::DB_CONNECTIONS[$connections];
        if (!is_array($config)) {
            $self->msg = 'error init config';
            return $self;
        }

        if (!isset($config['user']) || !isset($config['pass']) || !isset($config['name']) || !isset($config['charset']) || !isset($config['host'])) {
            $self->msg = 'err empty params';
            return $self;
        }
        $host = $config['host'];
        $db = $config['name'];
        $charset = $config['charset'];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
            $self->status = true;
            $self->pdo = $pdo;
            return $self;
        } catch (\PDOException $e) {
            $self->msg = $e->getMessage();
            return $self;
        }
    }

    public function fail()
    {
        return !$this->status;
    }

    public function err()
    {
        return $this->msg;
    }

    public function pdo()
    {
        return $this->pdo;
    }
}