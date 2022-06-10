<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

trait ResetsPasswords
{
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function sendResetLinkEmail(Request $request)
    {
        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink($request->only('email'));

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return true;

            case Password::INVALID_USER:
            default:
                return false;
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Your Password Reset Link';
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    public function reset(Request $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $broker = $this->getBroker();

        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $this->passwordReset($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return true;
            default:
                return false;
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function passwordReset($user, $password)
    {
        $user->password = Hash::make($password);

        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return string|null
     */
    public function getBroker()
    {
        return property_exists($this, 'broker') ? $this->broker : null;
    }
}
