<?php

namespace App;

class User
{
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var int
     */
    private $old;

    /**
     * @var string
     */
    private $email;

    /**
     * @param $firstname
     * @param $lastname
     * @param $old
     * @param $email
     * @return User
     */
    public static function create($firstname, $lastname, $old, $email)
    {
        return (new self)
            ->setFirstname($lastname)
            ->setLastname($lastname)
            ->setOld($old)
            ->setEmail($email)
        ;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (!empty($this->getEmail()) && !empty($this->getFirstname()) && !empty($this->getLastname()) && !empty($this->getOld()))
            && $this->getOld() >= 13
        ;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return int
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * @param int $old
     * @return User
     */
    public function setOld($old)
    {
        $this->old = $old;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
