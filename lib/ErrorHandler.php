<?php

/**
 * TAC ErrorHandler class
 *
 * $Id: ErrorHandler.php,v 1.3 2003/11/25 05:48:46 andrew Exp $
 * $Author: andrew $
 */

/**
 * ErrorHandler is TAC's custom error handler class
 *
 * @author Andrew Heebner <andrew@evilwalrus.com>
 * @version $Revision: 1.3 $
 * @require PHP 5.0
 */
class ErrorHandler
{

    protected $core;

	public $error = array(
        // General Errors
        901 => array('text' => 'The requested user "%s" was not currently available.',
                     'type' => ERR_WARN),
		902 => array('text' => 'Warning of the user "%s" not currently available.',
                     'type' => ERR_WARN),
		903 => array('text' => 'A message has been dropped, you are exceeding the server speed limit.',
                     'type' => ERR_WARN),

        // Misc Errors
		911 => array('text' => 'Error validating input.',
                     'type' => ERR_WARN),
		912 => array('text' => 'Invalid account.',
                     'type' => ERR_FATAL),
		913 => array('text' => 'Error encountered while processing request.',
                     'type' => ERR_WARN),
		914 => array('text' => 'Service unavailable.',
                     'type' => ERR_WARN),

        // Chat Errors
		950 => array('text' => 'Chat in "%s" is unavailable.',
                     'type' => ERR_WARN),

        // IM and Info Errors
		960 => array('text' => 'You are sending messages too fast to "%s".',
                     'type' => ERR_WARN),
		961 => array('text' => 'You missed an im from "%s" because it was too big.',
                     'type' => ERR_WARN),
		962 => array('text' => 'You missed an im from "%s" because it was sent too fast.',
                     'type' => ERR_WARN),

        // Directory Errors
		970 => array('text' => 'Failure.',
                     'type' => ERR_WARN),
		971 => array('text' => 'Too many matches.',
                     'type' => ERR_WARN),
		972 => array('text' => 'Need more qualifiers.',
                     'type' => ERR_WARN),
		973 => array('text' => 'Directory service temporarily unavailable.',
                     'type' => ERR_WARN),
		974 => array('text' => 'Email lookup restricted.',
                     'type' => ERR_WARN),
		975 => array('text' => 'Keyword Ignored.',
                     'type' => ERR_WARN),
		976 => array('text' => 'No Keywords.',
                     'type' => ERR_WARN),
		977 => array('text' => 'Language not supported.',
                     'type' => ERR_WARN),
		978 => array('text' => 'Country not supported.',
                     'type' => ERR_WARN),
		979 => array('text' => 'Failure unknown: "%s".',
                     'type' => ERR_WARN),

        // Authorization Errors
		980 => array('text' => 'Incorrect nickname or password.',
                     'type' => ERR_FATAL),
		981 => array('text' => 'The service is temporarily unavailable.',
                     'type' => ERR_FATAL),
		982 => array('text' => 'Your warning level is currently too high to sign on.',
                     'type' => ERR_FATAL),
		983 => array('text' => 'You have been connecting and disconnecting too frequently.  Wait 10 minutes and try again.',
                     'type' => ERR_FATAL),
		989 => array('text' => 'An unknown signon error has occurred: "%s".',
                     'type' => ERR_FATAL)
    );

    /**
     * __construct: ErrorHandler constructor
     *
     * @param object $object Object for parent referencing
     * @access public
     * @return void
     */
    public function __construct($object)
    {
        $this->core = &$object;
    }

   /**
    * __destruct: ErrorHandler destructor
    *
    * @access private
    * @return void
    */
    private function __destruct()
    {
        unset($this->core);
    }
    
    /**
     * __call: ErrorHandler invalid method parser
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

    /**
     * handleError: Handle the error number passed
     *
     * @param integer $errno Error number to reference
     * @param string $errtxt (optional) Error text to replace into error
     * @access public
     * @return void
     * @throws TOCException
     */
    public function handleError($errno, $errtxt = null)
    {
        if (array_key_exists($errno, $this->error)) {
            $out = (is_null($errtxt)) ? 'Error text not available.' : sprintf($this->error[$errno]['text'], $errtxt);
            switch ($this->error[$errno]['type']) {
                case ERR_FATAL:
                    throw new TACException($out);
                    break;
                case ERR_WARN:
                    $this->core->aim_debug('WARNING: ' . $out, AIM_WARN);
                    break;
            }
        }
    }

} // end ErrorHandler

?>