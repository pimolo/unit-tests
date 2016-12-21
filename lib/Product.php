<?php

namespace App;

class Product
{
    const ACTIVATED = 'ACTIVATED';
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $status;
    /**
     * @var User
     */
    private $owner;

    /**
     * @param string $name
     * @param string $status
     * @param $owner
     * @return Product
     */
    public static function create($name, $status, $owner)
    {
        return (new self)
            ->setName($name)
            ->setStatus($status)
            ->setOwner($owner)
        ;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (
            !empty($this->getName())
            && $this->status === self::ACTIVATED
            && $this->getOwner()->isValid()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;

    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return Product
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }
}
