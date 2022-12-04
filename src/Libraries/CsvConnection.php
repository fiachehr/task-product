<?php
namespace App\Libraries;

use App\Interfaces\DatabaseInterface;

class CsvConnection implements DatabaseInterface
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
            self::$instance = new CsvConnection($filePath);
        }

        return self::$instance;
    }

    /**
     * Get data from CSV file and create data array
     */
    public function connection(): void
    {

        if (($handle = fopen($this->filePath, 'r')) !== false) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row) {
                    $this->data[$row]['id'] = $data[0];
                    $this->data[$row]['manufacturer'] = $data[1];
                    $this->data[$row]['name'] = $data[2];
                    $this->data[$row]['additional'] = $data[3];
                    $this->data[$row]['price'] = $data[4];
                    $this->data[$row]['availability'] = $data[5];
                    $this->data[$row]['product_image'] = $data[6];
                }
                $row++;
            }
            fclose($handle);
        }
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
