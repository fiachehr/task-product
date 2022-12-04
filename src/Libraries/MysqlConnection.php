<?php
namespace App\Libraries;

use App\Interfaces\DatabaseInterface;
use PDO;
use PDOException;

class MysqlConnection implements DatabaseInterface
{
    /**
     * Class instance
     * @var object
     */
    private static $instance = null;

    /**
     * Database connection
     * @var object
     */
    protected $db;

    private function __construct(private $host, private $database, private $username, private $password)
    {
        $this->connection();
    }

    /**
     * Create instance from current class
     *
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     *
     * @return object
     */
    public static function getInstance(string $host, string $database, string $username, string $password): object
    {
        if (self::$instance == null) {
            self::$instance = new MysqlConnection($host, $database, $username, $password);
        }

        return self::$instance;
    }

    /**
     * Connect to MYSQL database
     */
    public function connection(): void
    {
        try {
            $this->db = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Return data
     *
     * @return array
     */
    public function fetchAllData(): array
    {
        $data = $this->db->query("SELECT * FROM products");
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
