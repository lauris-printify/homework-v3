<?php


namespace App;

use App\Interfaces\IReturn;

class ReturnUser implements IReturn
{
    private $id;
    private $name;
    private $surname;
    private $balance;

    public function __construct(int $id, string $name, string $surname, int $balance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->balance = $balance;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getBalance()
    {
        return $this->balance;
    }
}