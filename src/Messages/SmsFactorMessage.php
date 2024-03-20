<?php

namespace Xefi\SmsFactor\Messages;

use Carbon\Carbon;

class SmsFactorMessage
{
    /**
     * The message text.
     *
     * @var string
     */
    public $text;

    /**
     * The push type (alert or marketing).
     *
     * @var string
     */
    public $pushtype;

    /**
     * The date that the sms should be sent at (optional).
     *
     * @var \Carbon\Carbon
     */
    public $delay;

    /**
     * The sender that should be used.
     *
     * @var string
     */
    public $sender;

    /**
     * An id of your choice to link it to its delivery report.
     *
     * @var string
     */
    public $gsmsmsid;

    /**
     * Set the message text.
     *
     * @param string $text
     *
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set the message pushtype.
     *
     * @param string $pushtype
     *
     * @return $this
     */
    public function pushtype($pushtype)
    {
        $this->pushtype = $pushtype;

        return $this;
    }

    /**
     * Set the message delay.
     *
     * @param \Carbon\Carbon $delay
     *
     * @return $this
     */
    public function delay($delay)
    {
        if ($delay instanceof Carbon) {
            $delay = $delay->format('Y-m-d H:i:s');
        }

        $this->delay = $delay;

        return $this;
    }

    /**
     * Set the message sender.
     *
     * @param string $sender
     *
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the message gsmsmsid.
     *
     * @param string $gsmsmsid
     *
     * @return $this
     */
    public function gsmsmsid($gsmsmsid)
    {
        $this->gsmsmsid = $gsmsmsid;

        return $this;
    }
}
