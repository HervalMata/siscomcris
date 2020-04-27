<?php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 22:24
 */

class Inquiry extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $inquiry;

    /**
     * Inquiry constructor.
     * @param $inquiry
     */
    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this
            ->from($this->inquiry->email)
            ->markdown('emails.inquiry.send')
            ->with([
                'from' => $this->inquiry->first_name . ' ' . $this->inquiry->last_name,
                'email' => $this->inquiry->email,
                'iam' => $this->inquiry->select,
                'message' => $this->inquiry->message
            ]);
    }
}
