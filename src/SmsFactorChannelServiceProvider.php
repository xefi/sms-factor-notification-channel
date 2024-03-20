<?php

namespace Xefi\SmsFactor;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Xefi\SmsFactor\Channels\SmsFactorSmsChannel;

class SmsFactorChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sms-factor.php', 'sms-factor');

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sms-factor', function ($app) {
                return $app->make(SmsFactorSmsChannel::class);
            });
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \SMSFactor\SMSFactor::setApiToken(config('sms-factor.api_token'));

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/sms-factor.php' => $this->app->configPath('sms-factor.php'),
            ], 'sms-factor');
        }
    }
}
