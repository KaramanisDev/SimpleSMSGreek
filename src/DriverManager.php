<?php

namespace KaramanisWeb\SimpleSMSGreek;

use GuzzleHttp\Client;
use KaramanisWeb\SimpleSMSGreek\Drivers\Ez4uSMS;
use KaramanisWeb\SimpleSMSGreek\Drivers\SmsnetgrSMS;
use KaramanisWeb\SimpleSMSGreek\Drivers\SmsnSMS;
use SimpleSoftwareIO\SMS\DriverManager as Manager;

class DriverManager extends Manager
{
    public function createEz4usDriver()
    {
        $config = $this->app['config']->get('sms.ez4us', []);
        $provider = new Ez4uSMS(
            new Client(),
            $config['username'],
            $config['password'],
            $config['unicode']
        );
        return $provider;
    }

    public function createSmsnetgrDriver()
    {
        $config = $this->app['config']->get('sms.smsnetgr', []);
        $provider = new SmsnetgrSMS(
            new Client(),
            $config['username'],
            $config['api_password'],
            $config['apo_token'],
            $config['unicode']
        );
        return $provider;
    }

    public function createSmsnDriver()
    {
        $config = $this->app['config']->get('sms.smsn', []);
        $provider = new SmsnSMS(
            new Client(),
            $config['username'],
            $config['password'],
            $config['unicode']
        );
        return $provider;
    }

}