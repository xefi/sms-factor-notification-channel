# Laravel SMSFactor Notification Channel

## Prerequisites

Before you can send notifications via SMSFactor, you need to install the `xefi/sms-factor-notification-channel`

```bash
composer require xefi/sms-factor-notification-channel
```

The package includes a [configuration file](https://github.com/xefi/sms-factor-notification-channel/config/sms-factor.php). However, you are not required to export this configuration file to your own application. You can simply use the `SMS_FACTOR_TOKEN` environment variables to define your SMSFactor token.

```
SMS_FACTOR_TOKEN=your-token
```

## Formating SMS Notifications

If a notification supports being sent as an SMS, you should define a `toSmsFactor` method on the notification class. This method will receive a $notifiable entity and should return an `Xefi\SmsFactor\Messages\SmsFactorMessage` instance:

```php
use Xefi\SmsFactor\Messages\SmsFactorMessage;
 
/**
 * Get the SMSFactor representation of the notification.
 */
public function toSmsFactor(object $notifiable): SmsFactorMessage
{
    return (new SmsFactorMessage)
                ->text('Your SMS message content');
}
```

## Customizing the "To" Number

If you would like to customize the number depending on the notifiable object you are calling, you'll need to implement the `routeNotificationForSmsFactor` method on your notifiable model:

```php
use Illuminate\Notifications\Notification;

/**
 * Get the corresponding phone number for the current model.
 */
public function routeNotificationForSmsFactor(Notification $notification)
{
    return $this->phone;
}
```

## Customizing the "From" Number

If you would like to send some notifications from a phone number that is different from the phone number specified by your `SMS_FACTOR_SMS_FROM` environment variable, you may call the `sender` method on a `SmsFactorMessage` instance:

```php
use Xefi\SmsFactor\Messages\SmsFactorMessage;
 
/**
 * Get the SMSFactor representation of the notification.
 */
public function toSmsFactor(object $notifiable): SmsFactorMessage
{
    return (new SmsFactorMessage)
                ->content('Your SMS message content')
                ->sender('15554443333');
}
```

## Support