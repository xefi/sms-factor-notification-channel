<?php

namespace Xefi\SmsFactor\Channels;

use Xefi\SmsFactor\Messages\SmsFactorMessage;
use SMSFactor\Message;
use Illuminate\Notifications\Notification;

class SmsFactorSmsChannel extends Notification
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return \SmsFactor\ApiResponse
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('sms-factor', $notification)) {
            return;
        }

        $message = $notification->toSmsFactor($notifiable);

        if (is_string($message)) {
            $message = (new SmsFactorMessage())->text($message);
        }

        return Message::send([
            'to' => $to,
            'text' => trim($message->text),
            'delay' => $message->delay,
            'pushtype' => $message->pushtype ?? null,
            'sender' => $message->sender ?? config('sms-factor.sms_from'),
            'gsmsmsid' => $message->gsmsmsid ?? null,
        ]);
    }
}