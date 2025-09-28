<?php

namespace App\Entities\Reviews;

use Exception;

class Review
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    private $comment;

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->id ?? 0;
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
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setComment($value)
    {
        $this->comment = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array("name" => $this->getName(), "comment" => $this->getComment(), "id" => $this->getID());
    }
}
