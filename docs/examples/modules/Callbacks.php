 <?php

/*****************************************
 General Reminder:

 All callbacks functions MUST have a single
 parameter passed to it, with the variable
 $data.  Any other variable names are
 ignored, except for $data.
   
*****************************************/


/**
 * Callbacks - List of all Callbacks our bot can handle
 *
 * @author Andrew Heebner <andrew@evilwalrus.com>
 * @version $Revision: 1.2 $
 * @require PHP 5.0
 */
class Callbacks
{
    protected $core;
    
    /**
     * __construct: Callbacks constructor
     *
     * @param object $object Object to store for parent referencing
     * @access private
     * @return void
     */
    public function __construct(&$object)
    {
        $this->core = &$object;
    }

    /**
     * __destruct: Callbacks destructor
     *
     * @access private
     * @return void
     */
    protected function __destruct()
    {
        unset($this->core);
    }

    /**
     * __call: Callbacks invalid method parser
     *
     * @param string $method Invalid method called
     * @access private
     * @return void
     * @throws TOCException
     */
    protected function __call($method)
    {
        throw new TOCException('Invalid method called => (Callbacks::'.$method.')');
    }

    // set an away message for our client (available via !away <awaymsg>)
    public function setAway($data)
    {
        $this->core->utilities->aim_set_away($data['message_text']);
    }

    // format our client's nick  (available via !nick <newnick>)
    public function formatNick($data)
    {
        $this->core->utilities->aim_format_sn($data['message_text']);
    }

    // leave a specified chat (available via !leave)
    public function leaveChat($data)
    {
        if ($data['message_type'] == AIM_MSG_CHAT) {
            if (!$data['whisper']) {
                $this->core->chat->aim_chat_send("As you wish... :'(", $data['cid']);
                $this->core->chat->aim_chat_part($data['cid']);
            } else {
                $this->core->chat->aim_chat_whisper("Pssst, it's not polite to whisper", $data['cid'], $data['screenname']);
            }
        }
    }

    // use the client to invite a user to a chatroom (available via !invite <screenname>)
    public function inviteChat($data)
    {
        // ensure we only activate the callback if the !invite command is used in
        // a chat room, and not an instant message
        if ($data['message_type'] == AIM_MSG_CHAT) {
            $this->core->chat->aim_chat_invite($data['cid'], $data['message_text']);
        }
    }

    // add a buddy to our client's buddylist (available via !add <screenname>)
    public function addBuddy($data)
    {
        $this->core->buddy->aim_add_buddy($data['message_text']);
    }

    // search google and return the first result to our user (available via !google <searchstring>)

    public function googleSearch($data)
    {
        $misc = explode('~*', $data['message_text'], 2);
        $data['message_text'] = $misc[0];
        $data['requestline'] = (!empty($misc[1])) ? ' (Requested by '.$data['screenname'].')' : '';
        $data['screenname']  = (!empty($misc[1])) ? $misc[1] : $data['screenname'];
        
        $result = '';
        
        $encoded = urlencode($data['message_text']);
        $ret = $this->send_google_request('www.google.com', $encoded, true);
        @list($head, $body) = explode("\r\n\r\n", $ret);
        $head = explode("\r\n", $head);
        
        $header = array();
        
        foreach ($head as $line) {
            $dt = explode(' ', $line, 2);
            $header[str_replace(':','',$dt[0])] = $dt[1];
        }
        
        $result = ($header['HTTP/1.1'] == '302 Found') ? 'I found this: ('.$data['message_text'].') ' . $header['Location'] . $data['requestline'] : 'Sorry, no link found for "<b>' . $data['message_text'] . '</b>"';
        
        if ($data['message_type'] == AIM_MSG_CHAT) {
            $this->core->chat->aim_chat_send($result, $data['cid']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], $result);
        }
    }

    // make the client say what we want it to say (available via !say <flag> <what_to_say>~*<to_user>)    
    public function sayStuff($data)
    {
        /* This could be made into a seperate function, but i'm too lazy */
        $misc = explode('~*', $data['message_text'], 2);
        $fcap = explode(' ', $misc[0], 2);
        if (substr($fcap[0], 0, 1) == '-') $flag = $fcap[0];
 
        /* Message flag array */
        static $_flags = array('-r' => 'strrev',
                               '-s' => 'str_shuffle',
                               '-crc' => 'crc32',
                               '-md5' => 'md5',
                               '-sha1' => 'sha1');
            
        /* Capture modified text from flag call */
        if (!empty($flag)) {
            /* Check for valid flags first */
            $data['message_text'] = (array_key_exists($flag, $_flags)) ? $_flags[$flag]($fcap[1]) : $fcap[1];
        } else {
            /* Send regular text if no flag */
            $data['message_text'] = $misc[0];
        }

        /* if a %TO% user exists */
        if (!empty($misc[1])) $data['screenname'] = $misc[1];

        /* Debug the flags to the user if requested */
        if ($data['message_text'] == '*showflags') {
            ob_start();
            print_r($_flags);
            $op = ob_get_contents();
            ob_end_clean();
            $data['message_text'] = '<br>'.nl2br($op);
        }

        /* send the message to the appropriate source */
        if ($data['message_type'] == AIM_MSG_CHAT) {
            $this->core->chat->aim_chat_send($data['message_text'], $data['cid']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], $data['message_text']);
        }
    }

    // lets the requesting user know how long the client has been logged on  (available via !online)
    public function sayOnlineTime($data)
    {
        $time = $this->core->aim_onlinetime();
        $text = 'I have been online for ';
        $text.= ($time['days'] == 0) ? '' : $time['days'] . ' day(s), ';
        $text.= ($time['hours'] == 0) ? '' : $time['hours'] . ' hour(s), ';
        $text.= $time['mins'] . ' minute(s), ';
        $text.= ($time['secs'] == 0) ? '' : $time['secs'] . ' second(s)';
        if ($data['message_type'] == AIM_MSG_CHAT) {
            $this->core->chat->aim_chat_send($text, $data['cid']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], $text);
        }
    }

    /**
     * Supplemental functions
     */
    public function send_google_request($host, $data, $ua = false)
    {
        $buffer = '';
        if ($fp = fsockopen($host, 80)) {
            stream_set_blocking($fp, true);
            stream_set_timeout($fp, 5);
            stream_set_write_buffer($fp, 0);
            fwrite($fp, "HEAD /search?q=" . $data . "&btnI=1 HTTP/1.1\r\n");
            fwrite($fp, "Host: " . $host . "\r\n");
            if ($ua) fwrite($fp, "User-Agent: TAC (PHP/".phpversion().")\r\n");
            fwrite($fp, "Connection: Close\r\n\r\n");
            while (!feof($fp)) $buffer .= fgets($fp, 128);
            fclose($fp);
        }
        return $buffer;
    }
    
} // End Callbacks

?>