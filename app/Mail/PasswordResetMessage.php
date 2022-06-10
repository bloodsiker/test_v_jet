<?php

namespace App\Mail;

use App\Traits\ResetsPasswords;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMessage extends Mailable
{
    use Queueable;
    use SerializesModels;
    use ResetsPasswords;

    /**
     * @var link
     */
    public $link;

    /**
     * @var user
     */
    public $user;

    /**
     * @var token
     */
    public $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;

        $url = env('APP_URL');
        $link = sprintf('%s/password-reset?token=%s', $url, $token);
        $this->subject = sprintf('%s Password Reset', env('APP_NAME'));
        $this->link = preg_replace('/([^:])(\/{2,})/', '$1/', $link);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reset-password')
                    ->subject($this->getEmailSubject());
    }
}
