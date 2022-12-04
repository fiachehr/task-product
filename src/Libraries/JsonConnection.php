<?php
namespace App\Libraries;

use App\Interfaces\DatabaseInterface;

class JsonConnection implements DatabaseInterface
{

    /**
     * Class instance
     * @var object
     */
    private static $instance = null;

    /**
     * Fetched data as array
     * @var array
     */
    private $data = null;

    private function __construct(private $filePath)
    {
        $this->connection();
    }

    /**
     * Create instance from current class
     *
     * @param string $filePath
     *
     * @return object
     */
    public static function getInstance(string $filePath): object
    {
        if (self::$instance == null) {
            self::$instance = new JsonConnection($filePath);
        }

        return self::$instance;
    }

    /**
     * Get data from JSON file and create data array
     */
    public function connection(): void
    {
        $this->data = json_decode(file_get_contents($this->filePath), true);
    }

    /**
     * Return data
     *
     * @return array
     */
    public function fetchAllData(): array
    {
        return $this->data;
    }

}
