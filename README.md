SimpleSMSGreek
==========
[![Build Status](https://travis-ci.org/KaramanisWeb/SimpleSMSGreek.svg?branch=master)](https://travis-ci.org/KaramanisWeb/SimpleSMSGreek)
[![Latest Stable Version](https://poser.pugx.org/KaramanisWeb/SimpleSMSGreek/v/stable)](https://packagist.org/packages/KaramanisWeb/SimpleSMSGreek)
[![Latest Unstable Version](https://poser.pugx.org/KaramanisWeb/SimpleSMSGreek/v/unstable)](https://packagist.org/packages/karamanisweb/simplesmsgreek)
[![License](https://poser.pugx.org/KaramanisWeb/SimpleSMSGreek/license)](https://packagist.org/packages/karamanisweb/simplesmsgreek)
[![Total Downloads](https://poser.pugx.org/KaramanisWeb/SimpleSMSGreek/downloads)](https://packagist.org/packages/karamanisweb/simplesmsgreek)

## Introduction
SimpleSMSGreek is a wrapper for [SimpleSMS](https://github.com/simplesoftwareio/simple-sms) package that provides additional Greek SMS drivers. [simplesoftwareio/simple-sms](https://github.com/simplesoftwareio/simple-sms). This is a package for [Laravel](http://laravel.com/) and provides the capability to use Greek gateways to send SMS. These are the extra providers: [Smsn](http://www.smsn.gr), [Ez4usms](http://ez4usms.com), [Sms.net.gr](http://www.sms.net.gr/)

## Requirements

#### Laravel 5
* PHP: >= 7.0.0
* simplesoftwareio/simple-sms >= 3.1.0

## Installation

#### Composer
You can run the composer command `composer require karamanisweb/simplesmsgreek`
or you can add the package to your `require` in your `composer/json` file:

    "require": {
        "karamanisweb/simplesmsgreek": "1.0.*"
    }

And then run the command `composer update`.

This procedure will install the package into your application.

#### Service Providers

Once you have installed the package to your laravel application.

Add `KaramanisWeb\SimpleSMSGreek\SmsServiceProvider::class` into your `config/app.php` config file inside the `providers` array.

#### Aliases

Now all you have to do is register the Facade.

Add `'SMS' => SimpleSoftwareIO\SMS\Facades\SMS::class` in your `config/app.php` config file inside the `aliases` array.

#### Publish Configuration

If you need to change to make changes into the configuration file you must run the following command to save your config file to your local app:

     php artisan vendor:publish --provider="KaramanisWeb\SimpleSMSGreek\SmsServiceProvider"

This will copy the configuration files to your `config` folder.

or you can manual copy the config file from `vendors/karamanisweb/simplesmsgreek/Config` directory to your local app.

## Documentation
This package adds 3 greek SMS drivers
- Smsn
- Ez4usms
- Sms.net.gr
    

 #### Smsn

 ```php
'driver' => env('SMS_DRIVER', 'smsn'),
'smsn' => [
    'username' => env('SMSN_USERNAME', 'Your Smsn Username'),
    'password' => env('SMSN_PASSWORD', 'Your Smsn Password'),
    'unicode' => env('SMSN_UNICODE', false),
    ]
```

#### Ez4usms

```php
'driver' => env('SMS_DRIVER', 'ez4us'),
'ez4us' => [
    'username' => env('EZ4US_USERNAME', 'Your Ez4us Username'),
    'password' => env('EZ4US_PASSWORD', 'Your Ez4us Password'),
    'unicode' => env('EZ4US_UNICODE', false),
    ]
```  

#### Sms.net.gr

```php
'driver' => env('SMS_DRIVER', 'smsnetgr'),
'smsnetgr' => [
    'username' => env('SMSNETGR_USERNAME', 'Your Smsnetgr Username'),
    'api_password' => env('SMSNETGR_API_PASS', 'Your Smsnetgr API Password'),
    'api_token' => env('SMSNETGR_API_TOKEN', 'Your Smsnetgr API Token'),
    'unicode' => env('SMSNETGR_UNICODE', false),
    ]
```  

The documentation for SimpleSMS can be found [here.](https://www.simplesoftware.io/docs/simple-sms)