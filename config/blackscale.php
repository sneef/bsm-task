<?php

return [

    /**
     * Sleeping time (seconds)
     */
    'sleep' => 2,

    /**
     * Email sender
     */
    'sender' => 'no-reply@blackscale.media',

    /**
     * Step 1: attemp to login (retrive ctoken)
     */
    'step1' => [
        'url' => 'https://challenge.blackscale.media/register.php'
    ],

    /**
     * Step 2: submit register form
     */
    'step2' => [
        'url' => 'https://challenge.blackscale.media/captcha_bot.php'
    ],

    'step3' => [
        ''
    ]
];