<?php
// +######################################################################+
// # THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  #
// # "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    #
// # LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    #
// # FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE       #
// # COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,  #
// # INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, #
// # BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;     #
// # LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER     #
// # CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT   #
// # LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN    #
// # ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE      #
// # POSSIBILITY OF SUCH DAMAGE.                                          #
// +######################################################################+
//
// +----------------------------------------------------------------------+
// | Release Notes:                                                       |
// +----------------------------------------------------------------------+
// | - This script is 100% dependent on America Online Time Warner        |
// |   providing the AOL Instant Messenger service using the TOC          |
// |   protocol, which has been unsupported for years. If one day AOL     |
// |   decided to charge for IM or TOC, or stopped providing service      |
// |   under the TOC protocol, this script would be rendered useless.     |
// +----------------------------------------------------------------------+
// $Id:$

// TAKE THESE OUT LATER
// THEY SHOULD BE IN THE USER SCRIPT, NOT THE CLASS
error_reporting (E_ALL);

// Allow the script to hang around waiting
set_time_limit(0);

// bypass default 4k output buffering config
ob_end_flush();

// not using implicit because of PHP bug #16676
// http://bugs.php.net/bug.php?id=16676
//ob_implicit_flush(0);

require_once 'PEAR.php';

/**
 * AOL Instant Messenger TOC protocol class
 *
 * @version 0.0
 * @author David Norman <deekayen@deekayen.net>
 */

class AOL_TOC extends PEAR {

    /** Hostname of TOC server
     *
     * @see connect()
     */
    var $TocServer = 'toc.oscar.aol.com';

    /** Port to connect to on TOC server
     *
     * @see connect()
     */
    var $TocPort = 80;

    /** Hostname of authorization server
     *
     * @see signOn()
     */
    var $AuthServer = 'login.oscar.aol.com';

    /** Port to send authorization information
     *
     * @see signOn()
     */
    var $AuthPort = 9993;

    /** Signature of script to send to AOL
     *
     * @see signOn()
     */
    var $agent = 'AOL_TOC';

    /** Currently supported version of TOC */
    var $toc_version = 'TOC1.0';

    /** Formatted username received from TOC */
    var $toc_nick = '';

    /** Connection status for communication
     *
     * @see connect()
     */
    var $aol_connected = 0;

    /** Socket file pointer */
    var $aol_connection_handle = '';

    /** Random sequence number required by TOC */
    var $_outseq = 0;

    /** Debug status for script development */
    var $debug = true;

    /** Whether socket is blocking
     *
     * @see connect()
     */
    var $socket_blocking = 1;

    /** Contains status of buddies on buddy list */
    var $buddies = array();

    /** Strip HTML from incoming messages */
// turning this on means this script has support to read through all the
// HTML a OSCAR client sends by default
// ex: <BODY BGCOLOR="#ffffff">message</HTML>
    var $strip_html = true;

    /** Error codes for messages from TOC */
    var $errorCodes = array(
        // AIM Errors
        901 => array('type'    => 'notice',
                     'message' => 'User not currently available'),
        902 => array('type'    => 'notice',
                     'message' => 'Warning that screenname not currently available'),
        903 => array('type'    => 'notice',
                     'message' => 'A message has been dropped, you are exceeding the server speed limit'),

        // Chat Errors
        950 => array('type'    => 'error',
                     'message' => 'Requested chat is unavailable.'),

        // IM & Info Errors
        960 => array('type'    => 'notice',
                     'message' => 'You are sending message too fast'),
        961 => array('type'    => 'notice',
                     'message' => 'You missed an im because it was too big.'),
        962 => array('type'    => 'notice',
                     'message' => 'You missed an im because it was sent too fast.'),

        // Dir Errors
        970 => array('type'    => 'notice',
                     'message' => 'Failure'),
        971 => array('type'    => 'notice',
                     'message' => 'Too many matches'),
        972 => array('type'    => 'notice',
                     'message' => 'Need more qualifiers'),
        973 => array('type'    => 'notice',
                     'message' => 'Dir service temporarily unavailable'),
        974 => array('type'    => 'notice',
                     'message' => 'Email lookup restricted'),
        975 => array('type'    => 'notice',
                     'message' => 'Keyword Ignored'),
        976 => array('type'    => 'notice',
                     'message' => 'No Keywords'),
        977 => array('type'    => 'error',
                     'message' => 'Language not supported'),
        978 => array('type'    => 'error',
                     'message' => 'Country not supported'),
        979 => array('type'    => 'notice',
                     'message' => 'Failure unknown'),

        // Auth errors
        980 => array('type'    => 'critical',
                     'message' => 'Incorrect nickname or password.'),
        981 => array('type'    => 'critical',
                     'message' => 'The service is temporarily unavailable.'),
        982 => array('type'    => 'critical',
                     'message' => 'Your warning level is currently too high to sign on.'),
        983 => array('type'    => 'critical',
                     'message' => 'You have been connecting and disconnecting too frequently.  Wait 10 minutes and try again.  If you continue to try, you will need to wait even longer.'),
        989 => array('type'    => 'critical',
                     'message' => 'An unknown signon error has occurred')
    );

    /** TOC user class */
    var $uc = array(
        'uc0' => array(' ' => 'Ignore',
                       'A' => 'On AOL'),
        'uc1' => array(' ' => 'Ignore',
                       'A' => 'Admin',
                       'U' => 'Unconfirmed',
                       'O' => 'Normal',
                       'C' => 'Wireless'),
        'uc2' => array(' ' => 'Ignore',
                       'U' => 'Unavailable')
    );

    /**
     * Constructs a new AOL_TOC object.
     *
     * @access public
     */
    function AOL_TOC()
    {
        $this->PEAR();
        if($this->debug) error_reporting (E_ALL);

    }  // end constructor

    /**
     * Converts message to binary and sends to AOL
     *
     * Accepts $msg, truncates it to make sure it fits within
     * the 2048 bit guideline AOL TOC set, converts to binary,
     * and writes to the socket. $_outseq gets incremented because
     * AOL TOC demands that each message have a unique, incremented,
     * numerical identifier.
     * 
     * @param string $msg
     * @param int $channel (optional) TOC frame channel (1-5)
     *
     * @access private
     * @return mixed Returns bytes sent, or a PEAR_Error
     *               containing a descriptive error message on
     *               failure.
     */
    function _sflapWrite($msg, $channel = 2)
    {
        // TOC doesn't allow long messages
        $msg = (strlen($msg) > 2044) ? substr($msg, 0, 2043)."\0" : $msg."\0";

        $message = pack("aCnna*", '*', $channel, $this->_outseq, strlen($msg), $msg);

        $result = fwrite($this->aol_connection_handle, $message, strlen($message));

        if($result < 0)
            return $this->raiseError('_sflapWrite: couldn\'t write to socket!');

        if($this->debug) {
            echo strlen($message) ." chan = $channel seq = ". $this->_outseq .' len = '. strlen($msg) .' data = '. $msg ."\n";
           // ob_flush();
        }

        $this->_outseq++;
        return $result;

    } // end func _sflapWrite

    /**
     * Kills all but strict alphanumeric characters
     * Typically used for screen names
     *
     * @param string $data 
     * @access private
     */
    function _normalize($data)
    {
        return strtolower(preg_replace("/[^A-Za-z0-9]/", '', $data));

    } // end func _normalize

    /**
     * Escapes parenthesis, brackets, dollar sign, and quotes
     *
     * All strings must run through this function before sending to TOC
     *
     * @param string $data
     * @access private
     * @return string
     */
    function _encode ($data)
    {
        // there are three different ways to do this
        // I left out ereg_replace cause preg is better

        // str_replace is the fastest string replacement function
        $search = array('[',']','{','}','(',')','$','"','\\');
        $replace = array('\[','\]','\{','\}','\(','\)','\$','\"','\\\\');
        return '"'. str_replace($search, $replace, $data) .'"';

        // but here is the regex one-liner way anyway
        // return '"'.  preg_replace("/([\\\}\{\(\)\[\]\$\"])/", "\\\\\\1", $data) .'"';

    } // end func _encode

    /**
     * Converts password to format AOL likes
     *
     * @param string $password
     * @access private
     * @return string
     */
    function _encodePass($password)
    {
        $rpassword = "0x";
        $i = 0;

        $key = "Tic/Toc";

        // following is equivilent of explode('', $key);
        // but doesn't give a warning like explode() in E_ALL
        $skey = preg_split('//', $key, -1, PREG_SPLIT_NO_EMPTY);
        $c = preg_split('//', $password, -1, PREG_SPLIT_NO_EMPTY);

        for($i=0; $i<sizeof($c); $i++) {
            $p = (int)implode('', unpack("c", $c[$i]));
            $k = (int)implode('', unpack("c", $skey[$i % strlen($key)]));
            $rpassword = sprintf("%s%02x", $rpassword, $p ^ $k);
        }

    return $rpassword;

    } // end func _encodePass

    /**
     * Reads TOC version from AOL and compares it to supported version.
     * 
     * We are expecting 'SIGN_ON:x.x'
     * Error if $toc_version does not equal what TOC says
     *
     * @return mixed Returns true on success, or a PEAR_Error
     *               containing a descriptive error message on
     *               failure.
     * @see $toc_version
     * @access private
     */
    function _tocSignOn($version)
    {
        return ($version_arr[1] == $this->toc_version) ? true : $this->raiseError('TOC versions do not match');

    } // end func _tocSignOn

    /**
     * Reads formatted nick from TOC and saves privately
     *
     * We are expecting 'NICK:xxxxxx'
     *
     * @return mixed Returns true on success, or a PEAR_Error
     *               containing a descriptive error message on
     *               failure.
     * @access private
     */
    function _readNick()
    {
        $nick_str = AOL_TOC::_sflapRecv();
        $nick_arr = explode(':', $nick_str);
        $this->toc_nick = $nick_arr[1];
        return (strlen($this->toc_nick) > 2) ? true : false;

    } // end func _readNick

    /**
     * Handles arrival/departure/updates on buddy list
     *
     * We are expecting:
     * UPDATE_BUDDY:<Buddy User>:<Online? T/F>:<Evil Amount>:<Signon Time>:<IdleTime>:<UC> 
     * Evil Amount is a percentage, Signon Time is UNIX epoc, idle time is in minutes,
     * UC (User Class) is a two/three character string.
     *
     * @param $buffer string
     * @return true on success or Pear error on failure
     */
    function _updateBuddy($buffer)
    {
        $buddy_info = explode(':', substr($buffer, strpos(':', $buffer), strlen($buffer)));
        var_dump($buddy_info);

    } // end func _updateBuddy

    /**
     * Connects to AOL
     *
     * Opens a connection to the TOC server and sets socket blocking
     * according to set configuration.
     *
     * @see $aol_connection_handle
     * @access public
     * @return true on success or PEAR error on failure
     */
    function connect()
    {
	
        // check to see if we are connected already, return if so
        if($this->aol_connected)
            return 1;

        $this->aol_connection_handle = fsockopen ($this->TocServer, $this->TocPort, $errno, $errstr, 30);
        if(!is_resource($this->aol_connection_handle))
            return $this->raiseError($errstr, $errno);

        socket_set_blocking($this->aol_connection_handle, $this->socket_blocking);
        return 1;

    } // end func connect

    /**
     * Sends username and password to TOC
     *
     * This sends username and password to TOC,
     * checks supported version of TOC, and
     * reads proper formatting of nick from TOC
     * This is were $_outseq is initialized.
     *
     * @see $_outseq
     * @access public
     */
    function signOn($screenname, $password)
    {
        fputs($this->aol_connection_handle, "FLAPON\r\n\r\n");

        // just grab this even though it's not really useful
        fread($this->aol_connection_handle, 10);

        $screenname = $this->_normalize($screenname);

        mt_srand((double)microtime()*1000000);
        $this->_outseq = (int)mt_rand(1, 10000);

        $sflap_signon_data = pack("Nnna".strlen($screenname), 1, 1, strlen($screenname), $screenname);
        $msg = pack("aCnn", '*', 1, $this->_outseq, strlen($sflap_signon_data));
        $msg .= $sflap_signon_data;

        fputs($this->aol_connection_handle, $msg);
        unset($sflap_signon_data, $msg);

        $this->_outseq++;

        AOL_TOC::_sflapWrite('toc_signon ' . $this->AuthServer . ' ' .
                           $this->AuthPort . ' ' . $screenname . ' ' .
                           $this->_encodePass($password) . 
                           ' english ' . $this->_encode($this->agent));

        // yes the sleep is really nessesary
        sleep(1);

        // check TOC version support
        if(!$this->isError($this->_sflapRecv())) {

            AOL_TOC::_sflapWrite('toc_set_info "I am using AOL_TOC written in PHP by David Norman \(deekayen\)"');
            AOL_TOC::_sflapWrite('toc_add_buddy '. $screenname .' evilnorm prigwen austinthepunk deekayen');
            AOL_TOC::_sflapWrite('toc_init_done');
            $this->aol_connected = 1;
            sleep(1);

            // get correct formatting of screenname
            AOL_TOC::_sflapRecv();
        }

// XXX - fclose needs to be replaced with a real disconnect function
//        fclose($this->aol_connection_handle);

//    return;

    } // end func signOn

    /**
     * Decode information from AOL TOC
     *
     * Unpacks 6 byte FLAP header to find out how much data to read
     * in the message. Takes command from TOC and sends it off to
     * the appropriate function for processing.
     *
     * @access private
     * @return string on success or PEAR error on failure
     */
    function _sflapRecv()
    {
        $header = fread($this->aol_connection_handle, 6);
        $data = unpack("aone/Ctwo/nthree/nfour", $header);
        $msg = fread($this->aol_connection_handle, $data["four"]);
        $msg = implode('', unpack("a*done", $msg));

        if(strlen($msg) == 4)
            // keepalive from TOC?
            // var_dump shows: string(4) "2"
            return 1;
        preg_match("/^([A-Z_]{4,19})\:(.*)$/", $msg, $matches);
        if($this->debug) var_dump($matches);
        list($orig, $cmd, $args) = $matches;

        // don't unset $msg so it can be returned if nessesary
        unset($header, $orig, $data, $matches);

        switch($cmd) {    
        case 'SIGN_ON':
            unset($cmd);
            if($this->aol_connected)
                // we must have had a PAUSE, re-login!
                continue; // replace continue with real code later
            return ($args == $this->toc_version) ? 1 : $this->raiseError('Remote TOC version not supported');
            break;

        case 'CONFIG':
            unset($cmd);
            // not currently supported
            // parse_toc_buddy_list()
            return 1;
            break;

        case 'ERROR':
            $code = substr($args, 0, 3);
            unset($cmd, $args);
            switch($this->errorCodes[$code]['type']) {
            case 'notice':
                echo 'Error '. $code .': '. $this->errorCodes[$code]['message'];
                break;
            case 'error':
                echo 'Error '. $code .': '. $this->errorCodes[$code]['message'];
                break;
            case 'critical':
                die('Error '. $code .': '. $this->errorCodes[$code]['message']);
                break;
            }
//            return $this->raiseError($this->errorCodes[$matches[1]], $matches[1]);
            return $this->raiseError($this->errorCodes[$code]['message'], $this->errorCodes[$code]['type']);
            break;

        case 'NICK':
            $this->toc_nick = trim($args);
            unset($cmd, $args);
            if($this->debug) {
                echo 'Connected as '. $this->toc_nick ."\n";
               // ob_flush();
            }
            return 1;
            break;

        case 'UPDATE_BUDDY':
            // <Buddy User>:<Online? T/F>:<Evil Amount>:<Signon Time>:<IdleTime>:<UC>
            preg_match("/^([A-Za-z1-9 ]{3,16})\:(T|F)\:(\d{1,3})\:(\d{10})\:(\d{1,8})\:(.{2,3})$/", $args, $matches);
//            var_dump($matches);
            unset($cmd, $args);
            if(sizeof($matches) == 7) {
                // this array is a first attempt at creating a list of online users
                // pretend it's a buddy list
                $this->buddy[$matches[1]] = array('online' => $matches[2],
                                        'evil'   => $matches[3],
                                        'signon' => $matches[4],
                                        'idle'   => $matches[5],
                                        'uc0'    => $matches[6][0],
                                        'uc1'    => $matches[6][1]);
                $this->buddy[$matches[1]]["uc2"] = (strlen($matches[6]) < 3) ? '' : $matches[6][2];
                $this->myevil = ($matches[1] == $this->toc_nick) ? $matches[3] : $this->myevil;
                print_r($this->buddy);
            }
            return 1;
            break;

        case "EVILED":
            preg_match("/^(.*)\:(.*)$/", $args, $matches);
            unset($cmd, $args);
            $this->myevil = $matches[1];
            return 1;
            break;

        case "IM_IN":
            // <Source User>:<Auto Response T/F>:<Message>
            preg_match("/^([A-Za-z1-9 ]{3,16})\:(T|F)\:(.*)$/", $args, $matches);
//              var_dump($matches);
            unset($cmd, $args);
            $message = ($this->strip_html) ? strip_tags($matches[3]) : $matches[3];

            if(!strcmp($message, '!exit'))
                return 0;
            elseif(!strcmp($message, '!users')) {
                AOL_TOC::sendIM($matches[1], 'Currently logged on: '. exec('users'));
                return 1;
            } elseif(!strcmp($message, '!uptime')) {
                AOL_TOC::sendIM($matches[1], exec('uptime'));
                return 1;
            } elseif(!strcmp(substr($message, 0, 8), '!sendim ')) {
            	// splits to command, sendto nick, message
            	$values = split(' ', $message, 3);
                AOL_TOC::sendIM($values[1], $values[2]);
            	
// needs error checking before confirmation
                AOL_TOC::sendIM($matches[1], 'Message sent to '. $values[1] .'!');
                unset($values);
                return 1;
            }
            
            AOL_TOC::sendIM($matches[1], "You said: ". $message);
            return 1;
            break;
        }

        return $msg; // this shouldn't ever happen

    } // end func _sflapRecv

    /**
     * Used in loop to read messages from TOC
     *
     * @access public
     */
    function dispatch() {
        return AOL_TOC::_sflapRecv();
    } // end func dispatch

    /**
     * Returns formatted screenname
     *
     * @access public
     * @return string
     */
    function getNick()
    {
        return (isset($this->nick)) ? $this->nick : '';

    } // end func getNick

    /**
     * Format username and encode message and send to TOC
     *
     * @see _sflapWrite()
     * @param $user string screen name of recipient
     * @param $msg string message to send to recipient
     * @access public
     */
    function sendIM($user, $msg)
    {
        $user = AOL_TOC::_normalize($user);
        $msg = AOL_TOC::_encode($msg);

        return AOL_TOC::_sflapWrite("toc_send_im $user $msg");

    } // end func _sflapWrite
}

// for testing
// not intended to be in final script

$aim = new AOL_TOC;

$aim->connect();
$aim->setErrorHandling(PEAR_ERROR_PRINT);
$aim->signOn("signonnick", "password");
$aim->sendIM("sendtonick", "This message is from AOL_TOC, written in PHP by David Norman.");
while($aim->dispatch()) {
    sleep(1);
}

?>
