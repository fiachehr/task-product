<?php
namespace App;

class FetchData
{

    /**
     * Data Source class
     * @var object
     */
    private $connection = null;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return data to user interface
     *
     * @return array
     */
    public function fetchAllData(): array
    {
        return $this->connection->fetchAllData();
    }
}
