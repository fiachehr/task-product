<?php
namespace App\Interfaces;

interface DatabaseInterface{
    public function connection();
    public function fetchAllData();
}

