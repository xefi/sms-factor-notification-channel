<?php

namespace Xefi\SmsFactor\Tests\Unit\Channels;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;
use SMSFactor\Message;
use SMSFactor\SMSFactor;
use Xefi\SmsFactor\Channels\SmsFactorSmsChannel;
use Xefi\SmsFactor\Messages\SmsFactorMessage;
use Xefi\SmsFactor\SmsFactorChannelServiceProvider;

class SmsFactorSmsChannelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        SMSFactor::setApiToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMTEyNCIsImlhdCI6MTU1NjAxMDEyNX0.mvbtwke3ji2UZ_npySJ-LTepr5NEud9BIdtBT68RgXQ');
    }

    public function testSmsIsSentViaSmsFactor()
    {
        $notification = new NotificationSmsFactorSmsChannelTestNotification;
        $notifiable = new NotificationSmsFactorSmsChannelTestNotifiable;

        $channel = new SmsFactorSmsChannel();

        $this->mock('alias:'.Message::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    [
                        'to' => '5555555555',
                        'text' => 'this is my message',
                        'delay' => null,
                        'pushtype' => null,
                        'sender' => null,
                        'gsmsmsid' => null,
                    ]
                )
                ->once();
        });

        $channel->send($notifiable, $notification);
    }

    public function testSmsIsSentViaSmsFactorWithCustomSender()
    {
        $notification = new NotificationSmsFactorSmsChannelTestCustomSenderNotification;
        $notifiable = new NotificationSmsFactorSmsChannelTestNotifiable;

        $channel = new SmsFactorSmsChannel();

        $this->mock('alias:'.Message::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    [
                        'to' => '5555555555',
                        'text' => 'this is my message',
                        'delay' => null,
                        'pushtype' => null,
                        'sender' => '12345',
                        'gsmsmsid' => null,
                    ]
                )
                ->once();
        });

        $channel->send($notifiable, $notification);
    }

    public function testSmsIsSentViaSmsFactorWithCustomDelay()
    {
        $notification = new NotificationSmsFactorSmsChannelTestCustomDelayNotification;
        $notifiable = new NotificationSmsFactorSmsChannelTestNotifiable;

        $channel = new SmsFactorSmsChannel();

        $this->mock('alias:'.Message::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    [
                        'to' => '5555555555',
                        'text' => 'this is my message',
                        'delay' => Carbon::create(2024, 01, 01)->format('Y-m-d H:i:s'),
                        'pushtype' => null,
                        'sender' => null,
                        'gsmsmsid' => null,
                    ]
                )
                ->once();
        });

        $channel->send($notifiable, $notification);
    }

    public function testSmsIsSentViaSmsFactorWithCustomPushType()
    {
        $notification = new NotificationSmsFactorSmsChannelTestCustomPushTypeNotification;
        $notifiable = new NotificationSmsFactorSmsChannelTestNotifiable;

        $channel = new SmsFactorSmsChannel();

        $this->mock('alias:'.Message::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    [
                        'to' => '5555555555',
                        'text' => 'this is my message',
                        'delay' => null,
                        'pushtype' => 'alert',
                        'sender' => null,
                        'gsmsmsid' => null,
                    ]
                )
                ->once();
        });

        $channel->send($notifiable, $notification);
    }

    public function testSmsIsSentViaSmsFactorWithCustomGsmsmsid()
    {
        $notification = new NotificationSmsFactorSmsChannelTestCustomGsmsmsidNotification;
        $notifiable = new NotificationSmsFactorSmsChannelTestNotifiable;

        $channel = new SmsFactorSmsChannel();

        $this->mock('alias:'.Message::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    [
                        'to' => '5555555555',
                        'text' => 'this is my message',
                        'delay' => null,
                        'pushtype' => null,
                        'sender' => null,
                        'gsmsmsid' => 'my-custom-id',
                    ]
                )
                ->once();
        });

        $channel->send($notifiable, $notification);
    }
}

class NotificationSmsFactorSmsChannelTestNotification extends Notification
{
    public function toSmsFactor($notifiable)
    {
        return (new SmsFactorMessage())->text('this is my message');
    }
}

class NotificationSmsFactorSmsChannelTestCustomSenderNotification extends Notification
{
    public function toSmsFactor($notifiable)
    {
        return (new SmsFactorMessage())->text('this is my message')->sender('12345');
    }
}

class NotificationSmsFactorSmsChannelTestCustomDelayNotification extends Notification
{
    public function toSmsFactor($notifiable)
    {
        return (new SmsFactorMessage())->text('this is my message')->delay(Carbon::create(2024, 01, 01));
    }
}

class NotificationSmsFactorSmsChannelTestCustomPushTypeNotification extends Notification
{
    public function toSmsFactor($notifiable)
    {
        return (new SmsFactorMessage())->text('this is my message')->pushtype('alert');
    }
}

class NotificationSmsFactorSmsChannelTestCustomGsmsmsidNotification extends Notification
{
    public function toSmsFactor($notifiable)
    {
        return (new SmsFactorMessage())->text('this is my message')->gsmsmsid('my-custom-id');
    }
}

class NotificationSmsFactorSmsChannelTestNotifiable
{
    use Notifiable;

    public $phone_number = '5555555555';

    public function routeNotificationForSmsFactor($notification)
    {
        return $this->phone_number;
    }
}