<?php

/**
 * TAC Callbacks file
 *
 * $Id: Callbacks.php,v 1.6 2003/11/25 05:48:46 andrew Exp $
 * $Author: andrew $
 */
 
/**
 * Callbacks - List of all Callbacks our bot can handle
 *
 * @author Andrew Heebner <andrew@evilwalrus.com>
 * @version $Revision: 1.6 $
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
    public function __construct(TAC $object)
    {
        $this->core = $object;
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
        throw new TACException('Invalid method called => ('.__CLASS__.'::'.$method.')');
    }

    // this uses CLIENT_AWAY
    public function setAway($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            $this->core->utilities->aim_set_away($data['message_text']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function addPounce($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            $this->core->buddy->aim_update_buddy($data['message_text'], ADD_POUNCE);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function delPounce($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            $this->core->buddy->aim_update_buddy($data['message_text'], REMOVE_POUNCE);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    // this uses BUDDY_STATUS
    public function pounceBuddy($data)
    {
        // make sure they didn't just sign off, or put up their away message
        if ($data['online'] == true && $data['class']['away'] == false) {
            $this->core->buddy->aim_pounce_buddy($data['screenname'], 'You have just been pounced! :-D', true);
        }
    }

    public function formatNick($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            $this->core->utilities->aim_format_sn($data['message_text']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function leaveChat($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            if ($data['message_type'] == AIM_MSG_CHAT) {
                if (!$data['whisper']) {
                    $this->core->chat->aim_chat_send($data['cid'], "As you wish... :'(");
                    $this->core->chat->aim_chat_part($data['cid']);
                } else {
                    // this is obsolete, so, we really don't worry about it being used
                    $this->core->chat->aim_chat_whisper($data['cid'], $data['screenname'], "Pssst, it's not polite to whisper");
                }
            }
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function inviteChat($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            // ensure we only activate the callback if the !invite command is used in
            // a chat room, and not an instant message
            if ($data['message_type'] == AIM_MSG_CHAT) {
                $this->core->chat->aim_chat_invite($data['cid'], $data['message_text']);
            }
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function addBuddy($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            $this->core->buddy->aim_add_buddy($data['message_text']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function removeBuddy($data)
    {
        if ($this->core->utilities->aim_is_admin($data['screenname'])) {
            $this->core->buddy->aim_remove_buddy($data['message_text']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'You are not authorized to the requested command', true);
        }
    }

    public function googleSearch($data)
    {
        $misc = explode('%TO%', $data['message_text'], 2);
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
            $this->core->chat->aim_chat_send($data['cid'], $result);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], $result);
        }
    }
    
    public function sayStuff($data)
    {
        /* This could be made into a seperate function, but i'm too lazy */
        $misc = explode('%TO%', $data['message_text'], 2);
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
            $this->core->chat->aim_chat_send($data['cid'], $data['message_text']);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], $data['message_text'], true);
        }
    }

    public function sayOnlineTime($data)
    {
        $time = $this->core->utilities->aim_onlinetime();
        $text = 'I have been online for ';
        $text.= ($time['days'] == 0) ? '' : $time['days'] . ' day(s), ';
        $text.= ($time['hours'] == 0) ? '' : $time['hours'] . ' hour(s), ';
        $text.= ($time['mins'] == 0) ? '' : $time['mins'] . ' minute(s), ';
        $text.= ($time['secs'] == 0) ? '' : $time['secs'] . ' second(s)';
        if ($data['message_type'] == AIM_MSG_CHAT) {
            $this->core->chat->aim_chat_send($data['cid'], $text);
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], $text);
        }
    }

    public function getNetstats($data)
    {
        // we can only use this on a windows client, that is,
        // until i code something else to get the information
        // from a linux-based client server... until then, it
        // just outputs a nice message stating we can't output.
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // this code *assumes* we're on a system where `netstat`
            // is executable by PHP.
            $newdata = array();
            $dat = `netstat -e`;
            $dat = explode("\n", $dat);
            foreach ($dat as $d) {
                if (preg_match('/^Bytes([\s].+)([0-9])([\s].+)([0-9])/', $d, $matches)) {
                    $newdata['recv'] = $this->convertBytes(trim($matches[1].$matches[2]), true, 2);
                    $newdata['sent'] = $this->convertBytes(trim($matches[3].$matches[4]), true, 2);
                    $message = sprintf('My network has sent <b>%s</b> of traffic, and recieved <b>%s</b> of traffic', $newdata['sent'], $newdata['recv']);
                    $success = true;
                    break;
                } else {
                    $success = false;
                }
            }
            if ($success) {
                $this->core->utilities->aim_send_im($data['screenname'], $message, true);
            } else {
                $this->core->utilities->aim_send_im($data['screenname'], 'Sorry, !netstat is unavailable at the moment', true);
            }
        } else {
            $this->core->utilities->aim_send_im($data['screenname'], 'Sorry, !netstat is unavailable on Linux at the moment (sorry :-()', true);
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

    function convertBytes($bytes, $base10 = false, $round = 0, $labels = array('bytes', 'kb', 'mb', 'gb'))
    {
        if (($bytes <= 0) || (! is_array($labels)) || (count($labels) <= 0))
            return null;
    
        $step = $base10 ? 3 : 10;
        $base = $base10 ? 10 : 2;
        $log = (int)(log10($bytes) / log10($base));
        krsort($labels);
    
        foreach ($labels as $p => $lab) {
            $pow = $p * $step;
            if ($log < $pow) continue;
            $text = round($bytes / pow($base, $pow), $round) . $lab;
            break;
        }
        return $text;
    }
    
} // End Callbacks

?>
