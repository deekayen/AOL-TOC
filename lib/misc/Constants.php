<?php

/**
 * TAC Constants List
 *
 * $Id: Constants.php,v 1.4 2003/11/25 05:48:46 andrew Exp $
 * $Author: andrew $
 */

// Error type constants
define('ERR_FATAL',             'fatal');   // Fatal error (client dies)
define('ERR_WARN',              'warn');    // Warning (client continues)

// Buddylist constants
define('LIST_PERMIT_ALL',       0x00001);   // Permit all users
define('LIST_DENY_ALL',         0x00002);   // Deny all users
define('LIST_PERMIT_SOME',      0x00003);   // Permit only those on permit list
define('LIST_DENY_SOME',        0x00004);   // Deny only those on the deny list
define('LIST_ALLOW_BUDDYLIST',  0x00005);   // Allow all users on bussylist
define('LIST_BLOCK_AIM',        0x00006);   // Block all users (invisible)

// User buddylist constants
define('ADD_PERMIT',            0x00010);   // Add buddy to permit list
define('REMOVE_PERMIT',         0x00011);   // Remove buddy from permit list
define('ADD_DENY',              0x00012);   // Add buddy to deny list
define('REMOVE_DENY',           0x00013);   // Remove buddy from deny list
define('ADD_POUNCE',            0x00014);   // Add buddy to pounce list
define('REMOVE_POUNCE',         0x00015);   // Remove buddy from pounce list

// Debug Message type constants
define('AIM_INFO',              'INFO');    // Informational message
define('AIM_ERR',               'ERR ');    // Fatal error (client dies)
define('AIM_RECV',              'RECV');    // Recieved data
define('AIM_SENT',              'SENT');    // Sent data
define('AIM_RAW',               'RAW ');    // Raw IO (debug mode)
define('AIM_WARN',              'WARN');    // Warning message (client continues)

// Chat message type constants
define('AIM_MSG_IM',            'IM');      // Instant message
define('AIM_MSG_CHAT',          'CHAT');    // Chat message

// Callback type constants
define('BUDDY_STATUS',          0x00020);   // UPDATE_BUDDY2
define('CLIENT_AWAY',           0x00021);   // IM_IN2 (Away message)
define('CLIENT_GENERAL',        0x00022);   // IM_IN2 (For users to make their own mssage parser)
define('CLIENT_DEFAULT',        0x00023);   // All other functions

// User class constants
define('USER_TYPE_AOL',         0x00030);   // AOL user (yes, it sucks)
define('USER_TYPE_NORMAL',      0x00031);   // Normal internet user
define('USER_TYPE_UNCONFIRMED', 0x00032);   // Unconfirmed internet user
define('USER_TYPE_ADMIN',       0x00033);   // AIM admin user (AIM admins, is that a joke? :))

?>
