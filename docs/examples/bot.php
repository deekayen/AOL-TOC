<?php

// Require the main TAC library
require_once 'TAC.php';

// Options for TAC constructor
$options = array('sn'        => 'AIMTACBOT',         // Bot Screenname
                 'pass'      => 'password',          // Bot password
                 'debug'     => false,               // Output debug text to console
                 'buddyfile' => 'lib/xml/buddy.xml', // buddylist file
                 'admin'     => false,               // Turn on/off admin mode
                 'admins'    => array(),             // Array of unrestricted users (if admin mode is on)
                 'defensive' => true,                // Warn upon being warned (eviled)
                 'font'      => 'Courier',           // Font
                 'font_s'    => 2                    // Font size
                 );

// Try initializing a new class procedure
try {
    $aim = new TAC($options);
    if ($aim instanceof TAC) {
        // If it works, register the handlers (in lib/Callbacks.php)
        //
        // handlers must be registered as an associative array:
        //   - key(alert) => value(callback function)
        //
        $aim->parser->aim_register_handler(array('away'    => 'setAway'),
                                           array('back'    => 'setBack'),
                                           array('nick'    => 'formatNick'),
                                           array('leave'   => 'leaveChat'),
                                           array('invite'  => 'inviteChat'),
                                           array('add'     => 'addBuddy'),
                                           array('say'     => 'sayStuff'),
		                                   array('google'  => 'googleSearch'),
                                           array('online'  => 'sayOnlineTime'));
        // Loop the bot to catch messages
        $aim->aim_loop();
    } else {
        // Something foobar'd, throw an error
        throw new TACException('Unable to initialize the TAC class.');
    }
// Catch the error with our error-handler
} catch (TACException $ex) {
    // Display the throw error from TOC
    echo $ex->display();
}

?>