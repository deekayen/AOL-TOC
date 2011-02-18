<?php

/**
 * Bot initialization file
 *
 * $Id: bot.php,v 1.5 2003/11/30 02:33:40 andrew Exp $
 * $Author: andrew $
 */

// Require the main AIM library
require_once 'TAC.php';

// Options for TOC constructor
$options = array('screenname'   =>  'SCREENNAME',            // Bot Screenname
                 'password'     =>  'PASSWORD',              // Bot password
                 'admin'        =>  true,                    // Turn admin mode on/off
                 'admins'       =>  array('ayitathedj',
                                          'bige42083',
                                          'bigenoone'),      // Array of unrestricted users
                 'defensive'    =>  true,                    // Warn upon being warned (eviled)
                 'debug'        =>  true                     // Debug mode
                 );

// Try initializing a new class procedure
try {
    $aim = new TAC($options);
    if ($aim instanceof TAC) {
        // If it works, register the handlers (in modules/Callbacks.php)
        $aim->parser->aim_register_handler(array('away'         =>  array('setAway',          CLIENT_AWAY)),
                                           array('pounce'       =>  array('pounceBuddy',      BUDDY_STATUS)),
                                           array('addpounce'    =>  array('addPounce')),
                                           array('delpounce'    =>  array('delPounce')),
                                           array('nick'         =>  array('formatNick')),
                                           array('leavechat'    =>  array('leaveChat')),
                                           array('invite'       =>  array('inviteChat')),
                                           array('addbuddy'     =>  array('addBuddy')),
                                           array('delbuddy'     =>  array('removeBuddy')),
                                           array('say'          =>  array('sayStuff')),
		                                   array('google'       =>  array('googleSearch')),
                                           array('netstat'      =>  array('getNetstats')),
                                           array('online'       =>  array('sayOnlineTime'))
            );

        // Loop the bot to catch messages
        $aim->aim_loop();
    } else {
        // Something foobar'd, throw an error (this should never happen)
        throw new TACException('Unable to initialize the TAC class.');
    }
// Catch the error with our error-handler
} catch (TACException $ex) {
    // Display the throw error from TAC
    echo $ex->display();
}

?>