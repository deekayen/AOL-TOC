<?php

/**
 * +-----------------------------------------------------------------------------+
 * |                                                                             |
 * | TAC (AOL Instant Messenger Class for PHP 5.0)                               |
 * |   - A dynamic API for utilizing the AOL Instant Messaging protocol          |
 * |                                                                             |
 * +-----------------------------------------------------------------------------+
 * |                                                                             |
 * | The Artistic License                                                        |
 * |                                                                             |
 * |   (c)2003 Andrew Heebner / andrew@evilwalrus.com                            |
 * |           David Norman   / deekayen@deekayen.net                            |
 * |                                                                             |
 * | Preamble                                                                    |
 * |                                                                             |
 * | The intent of this document is to state the conditions under which a        |
 * | Package may be copied, such that the Copyright Holder maintains some        |
 * | semblance of artistic control over the development of the package, while    |
 * | giving the users of the package the right to use and distribute the Package |
 * | in a more-or-less customary fashion, plus the right to make reasonable      |
 * | modifications.                                                              |
 * |                                                                             |
 * | Definitions:                                                                |
 * |                                                                             |
 * | "Package" refers to the collection of files distributed by the Copyright    |
 * | Holder, and derivatives of that collection of files created through textual |
 * | modification.                                                               |
 * |                                                                             |
 * | "Standard Version" refers to such a Package if it has not been modified, or |
 * | has been modified in accordance with the wishes of the Copyright Holder.    |
 * |                                                                             |
 * | "Copyright Holder" is whoever is named in the copyright or copyrights for   |
 * | the package.                                                                |
 * |                                                                             |
 * | "You" is you, if you're thinking about copying or distributing this         |
 * | Package.                                                                    |
 * |                                                                             |
 * | "Reasonable copying fee" is whatever you can justify on the basis of media  |
 * | cost, duplication charges, time of people involved, and so on. (You will    |
 * | not be required to justify it to the Copyright Holder, but only to the      |
 * | computing community at large as a market that must bear the fee.)           |
 * |                                                                             |
 * | "Freely Available" means that no fee is charged for the item itself, though |
 * | there may be fees involved in handling the item. It also means that         |
 * | recipients of the item may redistribute it under the same conditions they   |
 * | received it.                                                                |
 * |                                                                             |
 * |     1. You may make and give away verbatim copies of the source form of the |
 * |        Standard Version of this Package without restriction, provided that  |
 * |        you duplicate all of the original copyright notices and associated   |
 * |        disclaimers.                                                         |
 * |                                                                             |
 * |     2. You may apply bug fixes, portability fixes and other modifications   |
 * |        derived from the Public Domain or from the Copyright Holder. A       |
 * |        Package modified in such a way shall still be considered the         |
 * |        Standard Version.                                                    |
 * |                                                                             |
 * |     3. You may otherwise modify your copy of this Package in any way,       |
 * |        provided that you insert a prominent notice in each changed file     |
 * |        stating how and when you changed that file, and provided that you do |
 * |        at least ONE of the following:                                       |
 * |                                                                             |
 * |        a) place your modifications in the Public Domain or otherwise make   |
 * |           them Freely Available, such as by posting said modifications to   |
 * |           Usenet or an equivalent medium, or placing the modifications on a |
 * |           major archive site such as ftp.uu.net, or by allowing the         |
 * |           Copyright Holder to include your modifications in the Standard    |
 * |           Version of the Package.                                           |
 * |                                                                             |
 * |        b) use the modified Package only within your corporation or          |
 * |           organization.                                                     |
 * |                                                                             |
 * |        c) rename any non-standard executables so the names do not conflict  |
 * |           with standard executables, which must also be provided, and       |
 * |           provide a separate manual page for each non-standard executable   |
 * |           that clearly documents how it differs from the Standard Version.  |
 * |                                                                             |
 * |        d) make other distribution arrangements with the Copyright Holder.   |
 * |                                                                             |
 * |     4. You may distribute the programs of this Package in object code or    |
 * |        executable form, provided that you do at least ONE of the following: |
 * |                                                                             |
 * |        a) distribute a Standard Version of the executables and library      |
 * |           files, together with instructions (in the manual page or          |
 * |           equivalent) on where to get the Standard Version.                 |
 * |                                                                             |
 * |        b) accompany the distribution with the machine-readable source of    |
 * |           the Package with your modifications.                              |
 * | 	                                                                         |
 * |        c) accompany any non-standard executables with their corresponding   |
 * |           Standard Version executables, giving the non-standard executables |
 * |           non-standard names, and clearly documenting the differences in    |
 * |           manual pages (or equivalent), together with instructions on where |
 * |           to get the Standard Version.                                      |
 * |                                                                             |
 * |        d) make other distribution arrangements with the Copyright Holder.   |
 * |                                                                             |
 * |     5. You may charge a reasonable copying fee for any distribution of this |
 * |        Package.  You may charge any fee you choose for support of this      |
 * |        Package.  You may not charge a fee for this Package itself. However, |
 * |        you may distribute this Package in aggregate with other (possibly    |
 * |        commercial) programs as part of a larger (possibly commercial)       |
 * |        software distribution provided that you do not advertise this        |
 * |        Package as a product of your own.                                    |
 * |                                                                             |
 * |     6. The scripts and library files supplied as input to or produced as    |
 * |        output from the programs of this Package do not automatically fall   |
 * |        under the copyright of this Package, but belong to whomever          |
 * |        generated them, and may be sold commercially, and may be aggregated  |
 * |        with this Package.                                                   |
 * |                                                                             |
 * |     7. C, Perl, or PHP subroutines supplied by you and linked into this     |
 * |        Package shall not be considered part of this Package.                |
 * |                                                                             |
 * |     8. The name of the Copyright Holder may not be used to endorse or       |
 * |        promote products derived from this software without specific prior   |
 * |        written permission.                                                  |
 * |                                                                             |
 * |    9. THIS PACKAGE IS PROVIDED "AS IS" AND WITHOUT ANY EXPRESS OR IMPLIED   |
 * |        WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE IMPLIED WARRANTIES OF |
 * |        MERCHANTIBILITY AND FITNESS FOR A PARTICULAR PURPOSE.                |
 * |                                                                             |
 * +-----------------------------------------------------------------------------+
 * | CVS Information:                                                            |
 * +-----------------------------------------------------------------------------+
 * $Id: TAC.php,v 1.11 2003/12/07 01:26:08 andrew Exp $
 */

// Deny script timeout and enable error reporting
set_time_limit(0);
error_reporting(E_STRICT);

// Require misc files
require_once 'lib/misc/Constants.php';
require_once 'lib/ErrorHandler.php';

// Buffer output to console
ob_implicit_flush();

/**
 * TAC provides a customizable wrapper to the TOC protocol.
 * 
 * @author Andrew Heebner <andrew@evilwalrus.com> 
 * @version $Revision: 1.11 $
 * @require PHP 5.0
 */
class TAC
{

    // User vars (modifiable through constructor)
    public $user = array(
        'screenname'    =>  null,
        'password'      =>  null,
        'debug'         =>  false,
        'defensive'     =>  false,
        'timer'         =>  null,
        'chats'         =>  array(),
        'revision'      =>  '$Revision: 1.11 $',
        'admins'        =>  array(),
        'admin'         =>  false,
        'callbacks'     =>  'lib/Callbacks.php'
    );

    // pounce buddies
    public $pounce = array(
        'buddies'   =>  array()
    );
    
    // Connectivity variables
    public $conn = array(
        'auth_serv' =>  'login.oscar.aol.com',
        'auth_port' =>  5159,
        'toc_serv'  =>  'toc.oscar.aol.com',
        'toc_port'  =>  9898,
        'protocol'  =>  'TOC2.0',
        'language'  =>  'english-US'
    );

    // Away message variables
    public $away = array(
        'isaway'    =>  false,
        'message'   =>  null
    );

    // Connection variables
	protected $resource;
	protected $count;

    // Add-on class variable references
	public $utilities;
	public $chat;
	public $parser;
	public $buddy;
	public $callbacks;
    public $errorhandler;

	// User handler arrays
	public $handlers        = array();

	/**
	 * __construct: TAC Constructor
	 * 
	 * @access public 
	 * @return void 
	 * @throws TACException
	 */
	public function __construct($options)
	{
        // Compatibility check
        $this->_version();
        
        // Set variables
        foreach ($options as $k => $v) {
            // cater to special cases
            if ($k == 'screenname') $k = $this->aim_normalize($k);
            $this->user[$k] = $v;
        }

        // include the callbacks into the scope
        if (is_file($this->user['callbacks'])) {
            require_once $this->user['callbacks'];
        } else {
            throw new TACException('Unable to locate a useable callbacks file');
        }
        
        // Create object references
        $this->callbacks    = new Callbacks($this);
        $this->utilities    = new Utilities($this);
        $this->chat         = new Chat($this);
        $this->parser       = new Parser($this);
        $this->buddy        = new Buddy($this);
        $this->errorhandler = new ErrorHandler($this);

		// Attempt to connect and login
		try {
			$this->aim_connect();
		} 
		catch (TACException $ex) {
			$ex->display();
		} 
	} 

	/**
	 * __destruct: TAC Destructor
	 * 
	 * @access private 
	 * @return void 
	 */
	private function __destruct()
	{
		unset($this->resource, $this->callbacks, $this->chat,
              $this->utilities, $this->buddy, $this->parser,
              $this->errorhandler);
	} 

	/**
	 * __call: TAC invalid method parser
	 * 
	 * @param string $method Invalid method called
	 * @access private 
	 * @return void 
	 * @throws TACException
	 */
	private function __call($method)
	{
		throw new TACException('Invalid method called => (' . __CLASS__ . '::' . $method . ')');
	}
    
	/**
	 * _version: Run compatibility check (against PHP5)
	 * 
	 * @param integer $v (optional) Version to compare against
	 * @access private 
	 * @return boolean 
	 * @throws TACException
	 * @proto boolean _version([integer version])
	 */
	private function _version($v = 5)
	{
        $_cur = intval(phpversion());
		if ($_cur >= $v) {
			return true;
		} else {
			throw new TACException('PHP version ' . $v . ' required; have version ' . $_cur);
		}
        return false;
	} 

	/**
	 * aim_debug: Print debug text to console
	 * 
	 * @param string $text Text to print text
	 * @param string $type (optional) Message type
	 * @access public 
	 * @return void 
	 * @proto void aim_debug(string text_to_print [, string message_type])
	 */
	public function aim_debug($text, $type = AIM_INFO)
	{
		$_dl = '[' . $type . ' - ' . date('m/d/y @ h:i:sA', time()) . ']:  ' . $text . "\n";
		if ($type == AIM_ERR) {
            die($_dl);
        } else {
            print $_dl;
        }
    }

	/**
	 * aim_connect: Connect to the TOC server
	 * 
	 * @access private 
	 * @return boolean 
	 * @throws TACException
	 * @proto boolean aim_connect(void)
	 */
	private function aim_connect()
	{
		if ($this->resource = fsockopen($this->conn['toc_serv'], $this->conn['toc_port'])) {
			@readfile('tac.asc');
			$this->aim_login();
			return true;
		} else {
			throw new TACException('Could not make connection to TOC server');
		}
        return false;
	} 

	/**
	 * aim_disconnect: Disconnect from the TOC server
	 * 
	 * @access public 
	 * @return boolean 
	 * @throws TACException
	 * @proto boolean aim_connect(void)
	 */
	public function aim_disconnect()
	{
		if ($this->aim_connected() === true) {
			fclose($this->resource);
		} else {
			throw new TACException('No active connection was found to disconnect');
		}
        return false;
	} 

	/**
	 * aim_connected: Check if connection is still alive
	 * 
	 * @access public 
	 * @return boolean 
	 * @throws TACException
	 * @proto boolean aim_connected(void)
	 */
	public function aim_connected()
	{
		if (is_resource($this->resource)) {
			return true;
		} else {
			throw new TACException('Unable to find active connection');
		}
        return false;
	} 

	/**
	 * aim_login: Send login information to TOC server
	 * 
	 * @access private 
	 * @return void 
	 * @throws TACException
	 * @proto void aim_login(void)
	 */
	private function aim_login()
	{
		fwrite($this->resource, "FLAPON\r\n\r\n");
		fread($this->resource, 10);

		mt_srand((double)microtime() * 1000000);
		$this->count = (int)mt_rand(1, 10000);

		$signon_data = pack("Nnna" . strlen($this->user['screenname']), 1, 1, strlen($this->user['screenname']), $this->user['screenname']);
		$msg = pack("aCnn", '*', 1, $this->count, strlen($signon_data)) . $signon_data;
		if ($this->user['debug']) $this->aim_debug($msg, AIM_SENT);
		fwrite($this->resource, $msg);
		unset($signon_data, $msg);
		$this->count++;

        // TOC2 signon method
        $this->aim_send_raw(sprintf('toc2_signon %s %s %s %s %s TAC %s',
            $this->conn['auth_serv'], $this->conn['auth_port'], $this->user['screenname'], $this->aim_roast_pass($this->user['password']),
            $this->conn['language'], $this->aim_toc2_hash($this->user['screenname'], $this->user['password'])));

		sleep(1);

		try {
			if ($this->aim_connected()) {
				$this->aim_recv();
				$this->utilities->aim_set_info("Powered by <a href=\"http://projects.evilwalrus.com/andrew/TAC/manual/\">TAC</a> - (PHP " . phpversion() . "/" . PHP_OS . ")<br><br>CVS: " . $this->user['revision']);
				$this->buddy->aim_add_buddy($this->user['screenname']);
				$this->aim_send_raw('toc_init_done');
                $this->buddy->aim_list_mode(LIST_PERMIT_ALL);
				$this->user['timer'] = time();
			} 
		} catch (TACException $ex) {
			$ex->display();
		} 
	} 

	/**
	 * aim_send_raw: Send raw queries to TOC server
	 * 
	 * @param string $msg Raw text to send
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_send_raw(string text_to_send)
	 */
	public function aim_send_raw($msg)
	{
		$msg = (strlen($msg) > 2044) ? substr($msg, 0, 2043) . "\0" : $msg . "\0";
		$message = pack("aCnna*", '*', 2, $this->count, strlen($msg), $msg);
		$result = fwrite($this->resource, $message, strlen($message));
		$this->aim_debug($msg, AIM_SENT);
		$this->count++;
		return $result;
	} 

	/**
	 * aim_recv: Recieve data from TOC server
	 * 
	 * @access public 
	 * @return mixed 
	 * @throws TACException
	 * @proto mixed aim_recv(void)
	 */
	public function aim_recv()
	{
		$header = fread($this->resource, 6);
        if ($this->user['debug']) $this->aim_debug($header, AIM_RAW);

		// Need error checking here to prevent bad data
		try {
			if (!$data = @unpack("aone/Ctwo/nthree/nfour", $header)) {
				// This normally happens if you sign on elsewhere with the same name,
                // or, if the TOC server resets (AOL likes to do this alot).
				throw new TACException('Connection to TOC server interrupted.');
			} 
		} catch(TACException $ex) {
			$ex->display();
		}

        if ($this->user['debug']) print_r($data);
		$msg = fread($this->resource, $data['four']);
		$msg = implode('', unpack("a*done", $msg));
        if ($this->user['debug']) var_dump($msg);

        // match incoming commands
        preg_match("/^([A-Z0-9_]{4,19})\:(.*)/s", $msg, $matches);
        @list($orig, $cmd, $args) = $matches;
        // send the command and arguments to our parser
        $this->parser->aim_parse_command($cmd, $args);
        // regain some memory
        unset($header, $orig, $data, $matches);
	}

	/**
	 * aim_loop: Run main TOC loop for connection
	 * 
	 * @access public 
	 * @return void 
	 * @proto void aim_loop(void)
	 */
	public function aim_loop()
	{
		while ($this->aim_connected()) {
			echo $this->aim_recv();
		} 
	} 

	/**
	 * aim_roast_pass: 'Roasts' password with AOL-type encryption
	 * 
	 * @param string $pass Password to roast for AOL-crypt
	 * @access private 
	 * @return string 
	 * @proto string aim_roast_pass(string pass_to_encrypt)
	 */
	private function aim_roast_pass($pass)
	{
		$roast = 'Tic/Toc';
		$hex = '';

		for ($i = 0; $i < strlen($pass); $i++) {
			$char = chr(ord($pass{$i}) ^ ord($roast{$i % 7}));
			$char = dechex(ord($char));
			$hex .= str_repeat('0', 2 - strlen($char)) . $char;
		} 
		return '0x' . $hex;
	}

	/**
	 * aim_toc2_hash: Encodes user/pass for TOC2 signon
	 *
     * @param string $user Client username
	 * @param string $pass Client password
	 * @access private
	 * @return integer
	 * @proto integer aim_toc2_hash(string username, string password)
	 */    
    private function aim_toc2_hash($user, $pass)
    {
        $sUser = strtolower(substr($user, 0, 1));
        $sUserChar = (int)(ord($sUser) - 96);
        $sVar = (int)(($sUserChar * 7696) + 738816);
        $sBase = (int)($sUserChar * 746512);
        $sVal = (int)((ord(substr(strtolower($pass), 0, 1)) - 96) * $sVar);
        return (int)(($sVal - $sVar) + (int)($sBase + 71665152));
    }

	/**
	 * aim_normalize: Normalize data
	 * 
	 * @param string $data Data to normalize
	 * @access public 
	 * @return string 
	 * @proto string aim_normalize(string text_to_normalize)
	 */
	public function aim_normalize($data)
	{
		return strtolower(preg_replace("/[^A-Za-z0-9]/", '', $data));
	} 

	/**
	 * aim_encode: Special encoding for text to send to TOC server
	 * 
	 * @param string $data Data to encode
	 * @access public 
	 * @return string 
	 * @proto string aim_encode(string text_to_encode)
	 */
	public function aim_encode($data)
	{
		return '"' . preg_replace("/([\\\}\{\(\)\[\]\$\"])/", "\\\\\\1", $data) . '"';
	} 

} // End TAC

/**
 * Utilities class
 * 
 * @author Andrew Heebner <andrew@evilwalrus.com> 
 * @version $Revision: 1.11 $
 * @require PHP 5.0
 */
class Utilities
{

	protected $core;

	/**
	 * __construct: Utilities constructor
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
	 * __destruct: Utilities destructor
	 * 
	 * @access private 
	 * @return void 
	 */
	protected function __destruct()
	{
		unset($this->core);
	} 

	/**
	 * __call: Utilities invalid method parser
	 * 
	 * @param string $method Invalid method called
	 * @access private 
	 * @return void 
	 * @throws TACException
	 */
	protected function __call($method)
	{
		throw new TACException('Invalid method called => (' . __CLASS__ . '::' . $method . ')');
	}

	/**
	 * aim_is_admin: Checks is user is allowed to access restricted commands
	 * 
	 * @param string $nick Screenname of user to check authorization
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_is_admin(string screenname)
	 */
	public function aim_is_admin($nick)
	{
		if ($this->core->user['admin'] === true) {
			if (is_array($this->core->user['admins'])) {
				if (in_array($this->core->aim_normalize($nick), $this->core->user['admins'])) return true;
			} 
		} 
		return false;
	}

	/**
	 * aim_onlinetime: Display how long TOC has been connected
	 * 
	 * @access public 
	 * @return array 
	 * @proto array aim_onlinetime(void)
	 */
	public function aim_onlinetime()
	{
		$s = time() - $this->core->user['timer'];
		$d = intval($s / 86400);
		$s -= $d * 86400;
		$h = intval($s / 3600);
		$s -= $h * 3600;
		$m = intval($s / 60);
		$s -= $m * 60;
		return array('days' => $d, 'hours' => $h, 'mins' => $m, 'secs' => $s);
	} 

	/**
	 * aim_send_im: Send IM to specified user
	 * 
	 * @param string $user User to send IM to
	 * @param string $text Text to send to user
     * @param boolean $enc Send encoded IM via TOC2 protocol
	 * @param boolean $auto (optional) Whether to send IM as an autoresponder
	 * @access public 
	 * @return void 
	 * @proto void aim_send_im(string user, string text [, boolean autorespond])
	 */
	public function aim_send_im($user, $text, $enc = false, $auto = false)
	{
        if ($enc === false) {
            $this->core->aim_send_raw(sprintf('toc_send_im %s %s%s', $this->core->aim_normalize($user), $this->core->aim_encode($text), (($auto)?' auto':'')));
        } else {
            $this->core->aim_send_raw(sprintf('toc2_send_im_enc %s F U %s %s%s', $this->core->aim_normalize($user), $this->core->conn['language'], utf8_encode($this->core->aim_encode($text)), (($auto)?' auto':'')));
        }
	} 

	/**
	 * aim_set_away: Sets user status to away or back
	 * 
	 * @param string $message (optional)Away message to send to TOC server
	 * @access public 
	 * @return void 
	 * @proto void aim_set_away([mixed message])
	 */
	public function aim_set_away($message = null)
	{
        if (is_null($message) || empty($message)) {
            $this->core->away['message'] = '';
            $this->core->away['isaway'] = false;
            $this->core->aim_send_raw('toc_set_away');
            $this->aim_set_idle(0);
        } else {
            $this->core->away['message'] = trim($message);
            $this->core->away['isaway'] = true;
            $this->core->aim_send_raw(sprintf('toc_set_away %s', $this->core->aim_encode($this->core->away['message'])));
            $this->aim_set_idle(1);
        }
	} 

	/**
	 * aim_warn: Warn a user
	 * 
	 * @param string $user User to warn
	 * @param boolean $anonymous (optional) Whether to warn anonymously
	 * @access public 
	 * @return void 
	 * @proto void aim_warn(string user [, boolean anonymous_warn])
	 */
	public function aim_warn($user, $anonymous = false)
	{
		$anon = ($anonymous) ? 'anon': 'norm';
		$this->core->aim_send_raw(sprintf('toc_evil %s %s', $this->core->aim_normalize($user), $anon));
	} 

	/**
	 * aim_set_info: Set info for user (simple HTML)
	 * 
	 * @param string $info Simple HTML userinfo
	 * @access public 
	 * @return void 
	 * @proto void aim_set_info(string info)
	 */
	public function aim_set_info($info)
	{
		$this->core->aim_send_raw('toc_set_info ' . $this->core->aim_encode($info));
	} 

	/**
	 * aim_get_info: Get info for the specified user
	 * 
	 * @param string $user User to get info for
	 * @access public 
	 * @return void 
	 * @proto N/A
	 */
	public function aim_get_info($user)
	{
		$this->core->aim_send_raw('toc_get_info ' . $this->core->aim_normalize($user));
	} 

	/**
	 * aim_set_idle: Sets a user to idle
	 * 
	 * @param integer $seconds (optional) Time (in seconds) to idle user for
	 * @access public 
	 * @return void 
	 * @proto void aim_set_idle([integer seconds])
	 */
	public function aim_set_idle($seconds = 1)
	{
		$this->core->aim_send_raw('toc_set_idle ' . $seconds);
	} 

	/**
	 * aim_format_sn: Apply special formatting to screenname
	 * 
	 * @param string $new Newly formatted screenname
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_format_sn(string new_screenname)
	 */
	public function aim_format_sn($new)
	{
		$new = trim($new);
		if ((strlen($new) > 16)) {
			$this->core->aim_debug('Newly formatted screenname > 16 chars, or does not equal old screenname', AIM_WARN);
            return false;
		} else {
			$this->core->aim_send_raw(sprintf('toc_format_nickname %s', $this->core->aim_encode($new)));
            return true;
		}
        return false;
	}

} // End Utilities

/**
 * Buddy class (Buddy is all TOC buddylist management utils.)
 * 
 * @author Andrew Heebner <andrew@evilwalrus.com> 
 * @version $Revision: 1.11 $
 * @require PHP 5.0
 */
class Buddy
{

	protected $core;

	/**
	 * __construct: Buddy constructor
	 * 
	 * @param object $object Object to store for parent referencing
	 * @access public 
	 * @return void 
	 */
	public function __construct(TAC $object)
	{
		$this->core = $object;
	} 

	/**
	 * __destruct: Buddy destructor
	 * 
	 * @access private 
	 * @return void 
	 */
	protected function __destruct()
	{
		unset($this->core);
	} 

	/**
	 * __call: Buddy invalid method parser
	 * 
	 * @param string $method Invalid method called
	 * @access private 
	 * @return void 
	 * @throws TACException
	 */
	protected function __call($method)
	{
		throw new TACException('Invalid method called => (' . __CLASS__ . '::' . $method . ')');
	}

	/**
	 * aim_list_mode: Changes the buddylist mode
	 * 
	 * @param integer $mode Mode to set buddylist to
	 * @access public 
	 * @return void 
	 * @proto void aim_list_mode(integer mode)
	 */
	public function aim_list_mode($mode)
	{
        switch($mode) {
            case LIST_PERMIT_ALL:
            case LIST_DENY_ALL:
            case LIST_PERMIT_SOME:
            case LIST_DENY_SOME:
            case LIST_ALLOW_BUDDYLIST:
            case LIST_BLOCK_AIM:
                $this->core->aim_send_raw('toc2_set_pdmode ' . $mode);
                break;
            default:
                $this->core->aim_debug(sprintf('Supplied mode "\%s" to "%s" is not a valid buddylist mode', $mode, __FUNCTION__), AIM_WARN);
                break;
        }
	}

	/**
	 * aim_update_buddy: Update buddy status on buddylist (permit/deny) and pounce modes
	 *
     * @param string $buddy Buddy to update
	 * @param integer $mode Mode to set buddy to
	 * @access public 
	 * @return void 
	 * @proto void aim_update_buddy(string buddy, integer mode)
	 */
	public function aim_update_buddy($buddy, $mode)
	{
        $buddy = $this->core->aim_normalize($buddy);
        switch($mode) {
            case ADD_PERMIT:
                $this->core->aim_send_raw('toc2_add_permit ' . $this->core->aim_normalize($buddy));
                break;
            case REMOVE_PERMIT:
                $this->core->aim_send_raw('toc2_remove_permit ' . $this->core->aim_normalize($buddy));
                break;
            case ADD_DENY:
                $this->core->aim_send_raw('toc2_add_deny ' . $this->core->aim_normalize($buddy));
                break;
            case REMOVE_DENY:
                $this->core->aim_send_raw('toc2_remove_deny ' . $this->core->aim_normalize($buddy));
                break;
            case ADD_POUNCE:
                if (!in_array($buddy, $this->core->pounce['buddies'])) $this->core->pounce['buddies'][$buddy] = true;
                break;
            case REMOVE_POUNCE:
                if (in_array($buddy, $this->core->pounce['buddies'])) unset($this->core->pounce['buddies'][$buddy]);
                break;
            default:
                $this->core->aim_debug(sprintf('Supplied mode "\%s" to "%s" is not a valid buddy mode', $mode, __FUNCTION__), AIM_WARN);
                break;
        }
	} 

	/**
	 * aim_add_buddy: Add a buddy to the buddylist
	 * 
	 * @param string $buddy Buddy to add to buddylist
	 * @param string $group (optional) Group to add Buddy to
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_add_buddy(string buddy[, string group])
	 */
	public function aim_add_buddy($buddy, $group = 'Buddies')
	{
		if (!empty($buddy) && $buddy != '' && !is_null($buddy)) {
            $this->core->aim_send_raw(sprintf("toc2_new_buddies \"g:%s\nb:%s\n\"", $group, $this->core->aim_normalize($buddy)));
            return true;
		}
        return false;
	} 

	/**
	 * aim_remove_buddy: Remove buddies from buddylist
	 * 
	 * @param string $buddy Buddy to add to buddylist
     * @param string $group (optional) Group to remove Buddy from
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_remove_buddy(string buddy[, string group])
	 */
	public function aim_remove_buddy($buddy, $group = 'Buddies')
	{
		if (!empty($buddy) && $buddy != '' && !is_null($buddy)) {
            $this->core->aim_send_raw(sprintf('toc2_remove_buddy %s %s', $group, $this->core->aim_normalize($buddy)));
            return true;
		}
        return false;
	}

	/**
	 * aim_pounce_buddy: Sends IM upon buddy status change
	 * 
	 * @param string $buddy Buddy to pounce
     * @param string $group (optional) Message to send to pounced buddy
     * @param boolean $encode (optional) Encode pounce IM in UTF8 (TOC2.0) encoding
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_pounce_buddy(string buddy [, string message [, boolean encode]])
	 */
    public function aim_pounce_buddy($buddy, $message = 'You have been pounced', $encode = false)
    {
        $buddy = $this->core->aim_normalize($buddy);
        if (!empty($this->core->pounce['buddies'])) {
            if (isset($this->core->pounce['buddies'][$buddy]) && $this->core->pounce['buddies'][$buddy] == true) {
                $this->core->utilities->aim_send_im($buddy, $message, $encode);
                return true;
            }
        }
        return false;
    }

	/**
	 * aim_get_user_class: Builds user class array frm signon information
	 * 
     * @param string $class Buddy class to parse for information
	 * @access private
	 * @return array 
	 * @proto array aim_get_user_class(string class)
	 */
    public function aim_get_user_class($class)
    {
        // fill the array with defaults
        $data = array('aol'   =>  false,
                      'type'  =>  '',
                      'away'  =>  false);

        // get the user information now
        switch (strlen($class)) {
            case 2:
                // user is (not) an AOL user
                switch ($class{0}) {
                    case ' ':   break;
                    case 'A':   $data['aol'] = true;    break;
                }
                // user type
                switch ($class{1}) {
                    case ' ':   break;
                    case 'A':   $data['type'] = USER_TYPE_ADMIN;        break;
                    case 'U':   $data['type'] = USER_TYPE_UNCONFIRMED;  break;
                    case 'O':   $data['type'] = USER_TYPE_NORMAL;       break;
                }
                break;
            case 3:
                // user is away or on ignore
                switch ($class{0}) {
                    case ' ':   break;
                    case 'A':   $data['aol'] = true;    break;
                }
                // user type
                switch ($class{1}) {
                    case ' ':   break;
                    case 'A':   $data['type'] = USER_TYPE_ADMIN;        break;
                    case 'U':   $data['type'] = USER_TYPE_UNCONFIRMED;  break;
                    case 'O':   $data['type'] = USER_TYPE_NORMAL;       break;
                }
                // user status (away)
                switch ($class{2}) {
                    case '\0':  break;
                    case ' ':   break;
                    case 'U':   $data['away'] = true;   break;
                }
                break;
        }
        return $data;   
    }

} // end Buddy

/**
 * Chat class (Chat is all TOC chat utils.)
 * 
 * @author Andrew Heebner <andrew@evilwalrus.com> 
 * @version $Revision: 1.11 $
 * @require PHP 5.0
 */
class Chat
{

	protected $core;

	/**
	 * __construct: Chat constructor
	 * 
	 * @param object $object Object to store for parent referencing
	 * @access public 
	 * @return void 
	 */
	public function __construct(TAC $object)
	{
		$this->core = $object;
	} 

	/**
	 * __destruct: Chat destructor
	 * 
	 * @access private 
	 * @return void 
	 */
	protected function __destruct()
	{
		unset($this->core);
	} 

	/**
	 * __call: Chat invalid method parser
	 * 
	 * @param string $method Invalid method called
	 * @access private 
	 * @return void 
	 * @throws TACException
	 */
	protected function __call($method)
	{
		throw new TACException('Invalid method called => (' . __CLASS__ . '::' . $method . ')');
	} 

	/**
	 * aim_chat_invite: Invite a user to join a chat channel
	 * 
	 * @param integer $cid Channel ID to join
	 * @param mixed $nick User to invite to chat (can accept an array, or a single string)
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_chat_invite(integer chat_id, mixed user)
	 */
	public function aim_chat_invite($cid, $nick)
	{ 
		// first, check and see if we're being duped (duh =P)
		if (array_key_exists($cid, $this->core->user['chats'])) {
			$invitemsg = 'You have been requested to join %s';
			if (is_array($nick)) {
				foreach ($nick as $n) {
					$n = $this->core->aim_normalize($n);
					$this->core->aim_send_raw(sprintf('toc_chat_invite %s %s %s', $cid, $this->core->aim_encode(sprintf($invitemsg, $this->core->user['chats'][$cid])), $n));
					$this->core->aim_debug(sprintf('%s has been invited to join %s', $n, $this->core->user['chats'][$cid]));
                    return true;
				} 
			} else {
				$nick = $this->core->aim_normalize($nick);
				$this->core->aim_send_raw(sprintf('toc_chat_invite %s %s %s', $cid, $this->core->aim_encode(sprintf($invitemsg, $this->core->user['chats'][$cid])), $nick));
				$this->core->aim_debug(sprintf('%s has been invited to join "%s"', $nick, $this->core->user['chats'][$cid]));
                return true;
			} 
		} 
        return false;
	} 

	/**
	 * aim_chat_join_invite: Join a chat channel (when invited)
	 * 
	 * @param integer $cid Channel ID to join
	 * @access public 
	 * @return void 
	 * @proto void aim_chat_join_invite(integer chat_id)
	 */
	public function aim_chat_join_invite($cid)
	{
		$this->core->aim_send_raw(sprintf('toc_chat_accept %s', $cid));
	}

	/**
	 * aim_chat_create: Create a chat channel
	 * 
	 * @param integer $name Channel name to create
     * @param integer $exchange (optional) Channel exchange number (should always be 4)
	 * @access public 
	 * @return void 
	 * @proto void aim_chat_join_invite(string chatname [, integer exchange])
	 */
	public function aim_chat_create($name, $exchange = 4)
	{
		$this->core->aim_send_raw(sprintf('toc_chat_join %d "%s"', $exchange, $name));
	} 

	/**
	 * aim_chat_part: Leave a chat channel
	 * 
	 * @param integer $cid Channel ID to leave
	 * @access public 
	 * @return void 
	 * @proto void aim_chat_part(integer chat_id)
	 */
	public function aim_chat_part($cid)
	{
		$this->core->aim_send_raw(sprintf('toc_chat_leave %s', $cid));
	} 

	/**
	 * aim_chat_warn: Warn a user in a chat channel
	 *
     * @param integer $cid Channel ID
	 * @param string $user User to warn
	 * @param boolean $anon (optional) Warn anonymously
	 * @access public 
	 * @return void 
	 * @proto void aim_chat_warn(integer chat_id, string user [, boolean anonymous_warn])
	 */
	public function aim_chat_warn($cid, $user, $anon = false)
	{
		$this->core->aim_send_raw(sprintf('toc_chat_evil %s %s %s', $cid, $user, (($anon)?'anon':'norm')));
	} 

	/**
	 * aim_chat_send: Send message to channel
	 * 
	 * @param integer $cid Channel ID to send message to
	 * @param string $message Message to send to channel
     * @param string $enc (optional) Encode message via TOC2.0 (UTF-8)
	 * @access public 
	 * @return void 
	 * @proto void aim_chat_send(integer chat_id, string message [, boolean encode])
	 */
	public function aim_chat_send($cid, $message, $enc = false)
	{
        if ($enc === false) {
            $this->core->aim_send_raw(sprintf('toc_chat_send %s %s', $cid, $this->core->aim_encode($message)));
        } else {
            $this->core->aim_send_raw(sprintf('toc_chat_send_enc %s U %s', $cid, utf8_encode($this->core->aim_encode($message))));
        }
	} 

	/**
	 * aim_chat_whisper: Send message to channel user (whisper)
	 * 
	 * @param integer $cid Channel ID to send whisper to
	 * @param string $user User to whisper to
	 * @param string $message Message to send to channel user
     * @param string $enc (optional) Encode message via TOC2.0 (UTF-8)
	 * @access public 
	 * @return void 
	 * @proto void aim_chat_whisper(integer chat_id, string user, string message [, boolean encode])
	 * @deprecated Deprecated since TOC 2.0
	 */
	public function aim_chat_whisper($cid, $user, $message, $enc = false)
	{
        if ($enc === false) {
            $this->core->aim_send_raw(sprintf('toc_chat_whisper %s %s %s', $cid, $this->core->aim_normalize($user), $this->core->aim_encode($message)));
        } else {
            $this->core->aim_send_raw(sprintf('toc_chat_whisper_enc %s U %s %s', $cid, $this->core->aim_normalize($user), utf8_encode($this->core->aim_encode($message))));
        }
	}

} // End Chat

/**
 * Parser class (Parse Instant Messages)
 * 
 * @author Andrew Heebner <andrew@evilwalrus.com> 
 * @version $Revision: 1.11 $
 * @require PHP 5.0
 */
class Parser
{

	protected $core;

	/**
	 * __construct: Parser constructor
	 * 
	 * @param object $object Object to store for parent referencing
	 * @access public 
	 * @return void 
	 */
	public function __construct(TAC $object)
	{
		$this->core = $object;
	} 

	/**
	 * __destruct: Parser destructor
	 * 
	 * @access private 
	 * @return void 
	 */
	protected function __destruct()
	{
		unset($this->core);
	} 

	/**
	 * __call: Parser invalid method parser
	 * 
	 * @param string $method Invalid method called
	 * @access private 
	 * @return void 
	 * @throws TACException
	 */
	protected function __call($method)
	{
		throw new TACException('Invalid method called => (' . __CLASS__ . '::' . $method . ')');
	} 

	/**
	 * aim_register_handler: Register handlers for certain alerts
	 * 
	 * @access public 
	 * @return boolean 
	 * @proto boolean aim_register_handler(array handlers)
	 */
	public function aim_register_handler()
	{
		foreach (func_get_args() as $arg) {
			if (is_array($arg) && count($arg) >= 1) {
				foreach ($arg as $k => $v) {
                    if (empty($v[1]) || is_null($v[1]) || !isset($v[1])) $v[1] = CLIENT_DEFAULT;
                    $k = strtolower($k);
					$this->core->handlers[$k] = array('name' => $k, 'callback' => $v[0], 'type' => $v[1]);
				} 
			} else {
				$this->core->aim_debug('Empty/invalid array cannot be a handler in ' . __FUNCTION__, AIM_WARN);
			} 
		}
	}

	/**
	 * aim_parse_im: Parse IM for alerts and text and returns function
	 * 
	 * @param array $data Data feed to parse
	 * @access private 
	 * @return boolean 
	 * @throws TACException
	 * @proto boolean aim_parse_im(array im_data)
	 */
	private function aim_parse_im($data)
	{
		if (!empty($data) && is_array($data)) {
			@list($alert, $text) = explode(' ', $data['message'], 2);
			unset($data['message']);
			$alert = trim($alert);
			$text = trim($text);
			if (@$alert{0} == '!') {
				$alert = substr($alert, 1);
				$data['message_alert'] = $alert;
				$data['message_text'] = (!empty($text)) ? $text : null;
				if ($this->core->user['debug'] === true) print_r($data);
				if (array_key_exists(strtolower($alert), $this->core->handlers)) {
					$this->core->callbacks->{$this->core->handlers[strtolower($alert)]['callback']}($data);
                }
			} 
		} else {
			throw new TACException('Data stream to ' . __CLASS__ . '::' . __FUNCTION__ . ' is invalid');
		}
	}

	/**
	 * aim_parse_buddy_update: Parse data from update buddy command
	 * 
	 * @param array $data Data feed to parse
	 * @access private 
	 * @return void 
	 * @throws TACException
	 * @proto void aim_parse_buddy_update(array buddy_data)
	 */
    private function aim_parse_buddy_update($data)
    {
		if (!empty($data) && is_array($data)) {
            foreach ($this->core->handlers as $h) {
                if ($h['type'] == BUDDY_STATUS) {
                    $ret = $h['name']; break;
                }
            }
            // check first
            if (!empty($ret)) {
                $this->core->callbacks->{$this->core->handlers[$ret]['callback']}($data);
            } else {
                $this->core->aim_debug(__CLASS__ . '::' . __FUNCTION__ . ' encountered a missing BUDDY_STATUS callback', AIM_WARN);
            }
        } else {
            throw new TACException('Data stream to ' . __CLASS__ . '::' . __FUNCTION__ . ' is invalid');
        }
    }

	/**
	 * aim_parse_command: Parse commands via TAC::aim_recv
	 * 
	 * @param string $cmd Command issued
	 * @param string $args List of arguments associated with command
	 * @access public 
	 * @return void 
	 */
	public function aim_parse_command($cmd, $args)
	{
		switch ($cmd) {
			case 'SIGN_ON':
				if ($args == $this->core->conn['protocol']) $this->core->aim_debug('Protocol versions match ('.$this->core->conn['protocol'].'), continuing login..');
				break;

            case 'NEW_BUDDY_REPLY2':
            case 'INSERTED2':
            case 'UPDATED2':
            case 'DELETED2':
			case 'CONFIG2':
                if ($this->core->user['debug']) {
    				print $cmd.' ';
                    var_dump($args);
                }
				break;

			case 'ERROR':
                if (strstr($args, ':')) {
                    @list($errno, $errtxt) = explode(':', $args, 2);
                } else {
                    $errno = $args; $errtxt = null;
                }
                $this->core->errorhandler->handleError((int)$errno, $errtxt);
				break;

			case 'NICK':
				$this->core->aim_debug('You have successfully identified as ' . $args);
				break;

			case 'ADMIN_NICK_STATUS':
				if ($args == 0) $this->core->aim_debug('You have successfully reformatted your nick');
				break;

			case 'ADMIN_PASSWD_STATUS':
				if ($args == 0) $this->core->aim_debug('You have successfully changed your password');
				break;

			case 'GOTO_URL': 
				// only supported in graphical clients (PHP isn't one of them ;)
				break;

			case 'UPDATE_BUDDY2':
                $data = array();
                @list($data['screenname'], $data['online'], $data['evil'],
                      $data['signon'], $data['idle'], $data['class'],
                      $data['unknown']) = explode(':', $args, 7);
                $data['screenname'] = $this->core->aim_normalize($data['screenname']);
                $data['online']     = ($data['online'] == 'T') ? true : false;
                $data['class']      = $this->core->buddy->aim_get_user_class($data['class']);

                if ($this->core->user['debug']) {
    				print $cmd.' ';
                    var_dump($data);
                }

                // don't post our own information... duh?
                if ($data['screenname'] != $this->core->user['screenname']) {
                    if (!in_array($data['screenname'], $this->core->pounce['buddies'])) {
                        $this->core->pounce['buddies'][$data['screenname']] = false;
                    }
                    $this->aim_parse_buddy_update($data);
                }
				break;

			case 'EVILED':
				preg_match('/^(.+)\:(.*)$/', $args, $matches);
				$who = (empty($matches[2])) ? 'an anonymous user' : $matches[2];
				$this->core->aim_debug('You have just been warned (' . $matches[1] . '%) by ' . $who, AIM_RECV);
				if ($this->core->user['defensive'] === true && !empty($matches[2])) {
					$this->core->utilities->aim_send_im($matches[2], 'Fine, have it your way...', true);
					sleep(1);
					$this->core->utilities->aim_warn($matches[2]);
				} 
				break;
                
            case 'IM_IN_ENC2':
                // utf8_decode the data
                if ($this->core->user['debug']) {
    				print $cmd.' ';
                    var_dump($args);
                }
                break;

			case 'IM_IN2':
				$data = array();
				preg_match("/^([A-Za-z0-9\s]{3,16})\:(T|F)\:(T|F)\:(.*)$/", $args, $matches);
				$this->core->aim_debug('You have just recieved an IM from ' . $matches[1] . '' . (($matches[2] == 'T') ? ' (autoresponse)' : ''), AIM_RECV);
				$data['screenname']     = $this->core->aim_normalize($matches[1]);
				$data['autoresponse']   = ($matches[2] == 'T') ? true : false;
                $data['unknown']        = $matches[3];
				$data['message']        = trim(strip_tags($matches[4]));
				$data['message_type']   = AIM_MSG_IM;

                // Search for the away message callback
                // --------------------------------------------------------
                // If none is found, the bot dies... We should include this
                //  into the constructor somehow, and issue the error from
                //  there, letting the user know it's a required callback
                foreach ($this->core->handlers as $h) {
                    if ($h['type'] == CLIENT_AWAY) {
                        $message = '!'.$h['name']; break;
                    } else {
                        $this->core->aim_debug('No client away callback specified!', AIM_ERR);
                    }
                }

                // Issue the command
				if ($this->core->away['isaway'] === true && $data['message'] != $message) {
					$this->core->utilities->aim_send_im($matches[1], $this->core->away['message'], true, true);
				} else {
					$this->aim_parse_im($data);
				}
				break;

			case 'CHAT_JOIN':
				preg_match('/^(.+)\:(.*)$/', $args, $matches);
				$this->core->aim_debug('You have successfully joined "' . $matches[2] . '"');
				break;

			case 'CHAT_LEFT':
				$this->core->aim_debug('You have successfully left the chat');
				break;

            case 'CHAT_INVITE_ENC':
                // utf8_decode the data
                if ($this->core->user['debug']) {
    				print $cmd.' ';
                    var_dump($args);
                }
                break;

			case 'CHAT_INVITE':
				preg_match('/^(.+)\:(.+)\:(.+)\:(.*)$/', $args, $matches);
				$this->core->aim_debug('You have been invited to join "' . $matches[1] . '"');
				$this->core->user['chats'][$matches[2]] = $matches[1];
				$this->core->chat->aim_chat_join_invite($matches[2]);
				break;

            case 'CHAT_IN_ENC':
                // utf8_decode the data
                if ($this->core->user['debug']) {
    				print $cmd.' ';
                    var_dump($args);
                }
                break;

			case 'CHAT_IN':
				$data = array();
				preg_match('/^(.+)\:(.+)\:(T|F)\:(.*)$/', $args, $matches);
				$this->core->aim_debug($matches[2] . " has spoken in \"" . $this->core->user['chats'][$matches[1]] . "\"" . (($matches[3] == 'T')?' (whisper)':''), AIM_RECV);
				$data['screenname']     = $this->core->aim_normalize($matches[2]);
				$data['message']        = trim(strip_tags($matches[4]));
				$data['whisper']        = ($matches[3] == 'T') ? true : false;
				$data['cid']            = $matches[1];
				$data['message_type']   = AIM_MSG_CHAT;
				$this->aim_parse_im($data);
				break;

            case 'CHAT_UPDATE_BUDDY':
                if ($this->core->user['debug']) {
    				print $cmd.' ';
                    var_dump($args);
                }
                break;

			case 'PAUSE':
                $this->core->aim_debug('TAC has recieved a PAUSE command from the TOC server.  Any messages sent to this client will not be recieved until the PAUSE period is completed');
				break;

		} 
	}

} // End Parser

/**
 * TACException: catches errors and throws display()
 * 
 * @author Andrew Heebner <andrew@evilwalrus.com> 
 * @version $Revision: 1.11 $
 * @require PHP 5.0
 */
class TACException
{

    private $exception = '';

	/**
	 * __construct: Initializes variables
	 * 
	 * @param string $exception (optional) Exception text to send to console
	 * @access public 
	 * @return void 
	 */
    public function __construct($exception = 'Unknown Error')
    {
        $this->exception = $exception;
	} 

	/**
	 * display: Dies on exception instance
	 * 
	 * @access public 
	 * @return void 
	 * @proto void display(void)
	 */
	public function display()
	{
        debug_print_backtrace();
		die("\n(" . date('m/d/y @ h:i:sA', time()) . ") A TACException occured: " . $this->exception . "\n");
	}

} // End TACException

?>