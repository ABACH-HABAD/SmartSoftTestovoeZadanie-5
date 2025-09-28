<?php

namespace App\Entities\Users;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setID($value)
    {
        $this->id = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setSurname($value)
    {
        $this->surname = $value;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setEmail($value)
    {
        $this->email = $value;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setMessage($value)
    {
        $this->message = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array("id" => $this->getID(), "name" => $this->getName(), "surname" => $this->getSurname(), "email" => $this->getEmail(),  "message" => $this->getMessage());
    }
}
