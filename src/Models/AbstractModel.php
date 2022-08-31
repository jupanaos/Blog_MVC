<?php

namespace App\Models;

use DateTime;

abstract class AbstractModel
{
    private $id;
    private $createdAt;
    private $updatedAt;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
        // $this->createdAt = new DateTime();
        // $this->updatedAt = new DateTime();
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = "set".str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
            if (is_callable(array($this, $method))) {
                $this->$method($value);
            }
            // var_dump($method);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}