<?php

namespace KaramanisWeb\SimpleSMSGreek;

use SimpleSoftwareIO\SMS\SMS as SSIO_SMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

class SMS extends SSIO_SMS
{
    protected $driver;

    protected $container;

    public function __construct(DriverInterface $driver)
    {
        parent::__construct($driver);
    }
}