<?php
namespace App\Libraries;

use App\Interfaces\DatabaseInterface;

class XmlConnection implements DatabaseInterface
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
    public static function getInstance($filePath): object
    {
        if (self::$instance == null) {
            self::$instance = new XmlConnection($filePath);
        }

        return self::$instance;
    }

    /**
     * Get data from XML file and create data array
     */
    public function connection(): void
    {

        $this->data = simplexml_load_file($this->filePath);

    }

    /**
     * Return data
     *
     * @return array
     */
    public function fetchAllData(): array
    {
        foreach ($this->data as $key => $value) {
            $data[] = (array) $value;
        }
        return $data;
    }

}
