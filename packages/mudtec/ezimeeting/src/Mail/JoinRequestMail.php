<?php

namespace Mudtec\Ezimeeting\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JoinRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $corporation;
    public $requestId;
    public $corpId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $corporation)
    {
        $this->user = $user;
        $this->corporation = $corporation;
        $this->requestId = $this->user->id;
        $this->corpId = $this->corporation->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('ezimeeting::emails.join-request')
                    ->subject('Join Request for Corporation' . $this->corporation->name)
                    ->with([
                        'userName' => $this->user->name,
                        'corporationName' => $this->corporation->name,
                    ]);
    }
}