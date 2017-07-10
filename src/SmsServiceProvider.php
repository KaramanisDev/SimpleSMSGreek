<?php

namespace KaramanisWeb\SimpleSMSGreek;

use Illuminate\Support\ServiceProvider;
use KaramanisWeb\SimpleSMSGreek\SMS as sms;

class SmsServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/sms.php' => config_path('sms.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('sms', function ($app) {
            $this->registerSender();
            $sms = new SMS($app['sms.sender']);
            $this->setSMSDependencies($sms, $app);

            if ($app['config']->has('sms.from')) {
                $sms->alwaysFrom($app['config']['sms']['from']);
            }
            return $sms;
        });
    }

    public function registerSender()
    {
        $this->app->bind('sms.sender', function ($app) {
            return (new DriverManager($app))->driver();
        });
    }

    private function setSMSDependencies($sms, $app)
    {
        $sms->setContainer($app);
        $sms->setQueue($app['queue']);
    }

    public function provides()
    {
        return ['sms', 'sms.sender'];
    }
}