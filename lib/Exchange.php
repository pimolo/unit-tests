<?php

namespace App;

class Exchange
{
    /**
     * @var User
     */
    private $receiver;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var EmailSender
     */
    private $emailSender;

    /**
     * @var DatabaseConnection
     */
    private $dbconnection;

    /**
     * @param EmailSender $emailSender
     * @param DatabaseConnection $dbConnection
     */
    public function __construct(EmailSender $emailSender, DatabaseConnection $dbConnection)
    {
        $this->emailSender = $emailSender;
        $this->dbconnection = $dbConnection;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     * @return Exchange
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Exchange
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     * @return Exchange
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     * @return Exchange
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return EmailSender
     */
    public function getEmailSender()
    {
        return $this->emailSender;
    }

    /**
     * @param EmailSender $emailSender
     * @return Exchange
     */
    public function setEmailSender($emailSender)
    {
        $this->emailSender = $emailSender;
        return $this;
    }

    /**
     * @return DatabaseConnection
     */
    public function getDbconnection()
    {
        return $this->dbconnection;
    }

    /**
     * @param DatabaseConnection $dbconnection
     * @return Exchange
     */
    public function setDbconnection($dbconnection)
    {
        $this->dbconnection = $dbconnection;
        return $this;
    }

    public function save()
    {
        if (
            $this->getReceiver()->isValid() && $this->getProduct()->isValid()
            && new \DateTime() < $this->getStartDate() && $this->getStartDate() < $this->getEndDate()
        ) {
            $this->getDbconnection()->saveExchange($this);

            if ($this->getReceiver()->getOld() < 18) {
                $this->getEmailSender()->sendEmail($this->getReceiver(), 'Vous êtes mineur');
            }
        }
    }
}
