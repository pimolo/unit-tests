<?php

use App\DatabaseConnection;
use App\EmailSender;
use App\Exchange;
use App\Product;
use App\User;
use PHPUnit\Framework\TestCase;

class ExchangeTest extends TestCase
{
    /**
     * @var User
     */
    private $validReceiver;

    /**
     * @var User
     */
    private $tooOldReceiver;

    /**
     * @var User
     */
    private $invalidReceiver;

    /**
     * @var Product
     */
    private $validProduct;

    /**
     * @var Product
     */
    private $invalidProduct;

    function setUp()
    {
        $validReceiver = $this->createMock(User::class);
        $validReceiver->method('isValid')->willReturn(true);
        $validReceiver->method('getOld')->willReturn(15);
        $this->validReceiver = $validReceiver;

        $tooOldReceiver = $this->createMock(User::class);
        $tooOldReceiver->method('isValid')->willReturn(true);
        $tooOldReceiver->method('getOld')->willReturn(20);
        $this->tooOldReceiver = $tooOldReceiver;

        $validProduct = $this->createMock(Product::class);
        $validProduct->method('isValid')->willReturn(true);
        $this->validProduct = $validProduct;

        $invalidReceiver = $this->createMock(User::class);
        $invalidReceiver->method('isValid')->willReturn(false);
        $validReceiver->method('getOld')->willReturn(15);
        $this->invalidReceiver = $invalidReceiver;

        $invalidProduct = $this->createMock(Product::class);
        $invalidProduct->method('isValid')->willReturn(false);
        $this->invalidProduct = $invalidProduct;
    }

    function testIfPartsInvalid()
    {

        $emailSender = $this->createMock(EmailSender::class);
        $emailSender
            ->expects($this->never())
            ->method('sendEmail')
        ;

        $dbConnection = $this->createMock(DatabaseConnection::class);
        $dbConnection
            ->expects($this->never())
            ->method('saveExchange')
        ;

        $exchange = new Exchange($emailSender, $dbConnection);
        $exchange->setReceiver($this->invalidReceiver);
        $exchange->setProduct($this->invalidProduct);


        $exchange->setStartDate($this->anything());
        $exchange->setEndDate($this->anything());

        $exchange->save();
    }

    function testIfPartsValidButTooOld()
    {

        $emailSender = $this->createMock(EmailSender::class);
        $emailSender
            ->expects($this->never())
            ->method('sendEmail')
        ;

        $dbConnection = $this->createMock(DatabaseConnection::class);
        $dbConnection
            ->expects($this->once())
            ->method('saveExchange')
        ;

        $exchange = new Exchange($emailSender, $dbConnection);
        $exchange->setReceiver($this->tooOldReceiver);
        $exchange->setProduct($this->validProduct);
        $now = new \DateTimeImmutable();
        $exchange->setStartDate($now->modify('+1 day'));
        $exchange->setEndDate($now->modify('+3 days'));

        $exchange->save();
    }

    function testIfPartsValidButWrongDates()
    {

        $emailSender = $this->createMock(EmailSender::class);
        $emailSender
            ->expects($this->never())
            ->method('sendEmail')
        ;

        $dbConnection = $this->createMock(DatabaseConnection::class);
        $dbConnection
            ->expects($this->never())
            ->method('saveExchange')
        ;

        $exchange = new Exchange($emailSender, $dbConnection);
        $exchange->setReceiver($this->validReceiver);
        $exchange->setProduct($this->validProduct);
        $now = new \DateTimeImmutable();
        $exchange->setStartDate($now->modify('+10 days'));
        $exchange->setEndDate($now->modify('+1 day'));

        $exchange->save();
    }

    function testIfAllValid()
    {

        $emailSender = $this->createMock(EmailSender::class);
        $emailSender
            ->expects($this->once())
            ->method('sendEmail')
        ;

        $dbConnection = $this->createMock(DatabaseConnection::class);
        $dbConnection
            ->expects($this->once())
            ->method('saveExchange')
        ;

        $exchange = new Exchange($emailSender, $dbConnection);
        $exchange->setReceiver($this->validReceiver);
        $exchange->setProduct($this->validProduct);
        $now = new \DateTimeImmutable();
        $exchange->setStartDate($now->modify('+1 day'));
        $exchange->setEndDate($now->modify('+3 days'));

        $exchange->save();
    }
}
