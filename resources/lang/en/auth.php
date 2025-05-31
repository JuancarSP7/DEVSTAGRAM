<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify the messages displayed to the user during
    | authentication (login, logout, errors, etc). Feel free to customize
    | these lines as needed for your application.
    |
    */

    'failed'   => 'The provided credentials do not match our records.', // When credentials are incorrect
    'password' => 'The password is incorrect.',                        // Incorrect password
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.', // Throttle protection

    // Additional recommended messages
    'login'    => 'Login',
    'logout'   => 'Logout',
    'register' => 'Register',
    'email'    => 'Email Address',
    'remember' => 'Remember me',
    'forgot_password' => 'Forgot your password?',
    'reset_password'  => 'Reset Password',
    'send_reset_link' => 'Send Password Reset Link',
    'confirm_password' => 'Confirm Password',
    'name'     => 'Username',

    // For custom messages or buttons in views
    'verify_email'     => 'Verify Your Email Address',
    'verification_link_sent' => 'A new verification link has been sent to your email address.',
    'check_email_verification' => 'Before proceeding, please check your email for a verification link.',
    'not_receive_email' => 'If you did not receive the email,',
    'request_another'   => 'click here to request another',

    'recover_password_page_title' => 'Recover password',
    'recover_password_title' => 'Recover your password',
    'email' => 'Email address',
    'email_placeholder' => 'Your registered email',
    'send_reset_link' => 'Send reset link',
];
