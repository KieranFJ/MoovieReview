<?php

/* SQL Handler
 *
 * SqlHandler script that takes query passed to it, connects to the database and
 * outputs the recieved data into a two dimensional array. This is then returned
 * to the script that called it.
 * 
 * Creator - Kevin Woodard
 *
 * Last updated 17/05/11
 * by Kieran Foxley-Jones
 *
 * Notes:
 * SELECT queries are output as a two dimensonal array
 */

define('sql_host', '127.0.0.1');
define('sql_username', 'root'); //CHANGE THESE!!!
define('sql_password', '');
define('sql_database', 'userdb');

define('site_name', 'MovieReviewSite');
define('site_email', 'KieranF-J@blueyonder.co.uk');
define('site_erroremail', 'KieranF-J@blueyonder.co.uk');
define('developerIPAddress', '192.168.0.1');

/**
 * SQL Handler Abstract Class
 *
 */
abstract class sqlHandler
{
	/**
	 * Container for the SQL link
	 *
	 * @var resource
	 */
        private static $sql;

        /**
         * Gets an instance of sql
         *
         * @return sql
         */
        public static function getDB()
        {
                if(self::$sql instanceof sql)
                {
                        return self::$sql;
                }
                else
                {
                        self::$sql = new sql;
                        self::$sql->host = sql_host;
                        self::$sql->username = sql_username;
                        self::$sql->password = sql_password;
                        self::$sql->db = sql_database;
                        self::$sql->connectToDatabase();

                        return self::$sql;
                }
        }
}

/**
 * SQL Class
 *
 */
class sql
{
	/**
	 * Resource Identifier
	 *
	 * @var resource
	 */
	public $mySQLLink;
	
	/**
	 * Host domain or IP
	 *
	 * @var string
	 */
	public $host;
	
	/**
	 * SQL Username
	 *
	 * @var string
	 */
	public $username;
	
	/**
	 * SQL Password
	 *
	 * @var string
	 */
	public $password;
	
	/**
	 * SQL Default DB
	 *
	 * @var string
	 */
	public $db;
	
	/**
	 * Constructor - Nothing here yet just a holder
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * Connects to the MySQL Database
	 *
	 */
	public function connectToDatabase()
	{
		$this->mySQLLink = mysql_connect($this->host, $this->username, $this->password);
		$this->selectDB();
		
		try
		{
			if(!$this->mySQLLink)
			{		
				throw new Exception('MySQL error: '.mysql_error($this->mySQLLink));
			}
		}
		catch (Exception $e)
		{
			errorHandler::processError(&$e);
		}
	}
	
	/**
	 * Select the default database
	 *
	 */
	public function selectDB()
	{
		try
		{
			if(mysql_select_db($this->db, $this->mySQLLink) == false)
			{		
				throw new Exception("MySQL error: ".mysql_error($this->mySQLLink));
			}
		}
		catch (Exception $e)
		{
			errorHandler::processError(&$e);
		}	
	}
	
	/**
	 * Run a SELECT query
	 *
	 * @param string $query
	 * @param bool $catch_error
	 * @return array
	 */
	function select($query, $catch_error = true)
	{	
		$result = mysql_query($query, $this->mySQLLink);
	
		try
		{
			if(strlen(mysql_error($this->mySQLLink)) > 0)
			{		
				throw new Exception("MySQL error: ".mysql_error($this->mySQLLink)."\n\n".$query);
			}
		}
		catch (Exception $e)
		{
			if($catch_error)
			{
				errorHandler::processError(&$e);
			}
		}
		
		if(!is_resource($result))
		{
			return array();
		}

                $results_array = null;
		$x = 0;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{		
			$newline = array();
				
			foreach($line as $k => $v)
			{
				if(is_string($v))
				{
					$newline[$k] = stripslashes($v);
				}
				else
				{
					$newline[$k] = $v;	
				}
			}
			$results_array[$x] = $newline;
			$x++;
		}
		
		return $results_array;		
	}
	
	/**
	 * Run an INSERT, CREATE or DELETE query
	 *
	 * Returns the last inserted ID
	 * 
	 * @param string $query
	 * @param bool $catch_error
	 * @return int
	 */
	function insert($query, $catch_error = true)
	{
		$result = mysql_query($query, $this->mySQLLink);
	
		try
		{
			if(strlen(mysql_error($this->mySQLLink)) > 0)
			{
				throw new Exception("MySQL error: ".mysql_error($this->mySQLLink)."\n\n".$query);
			}
		}
		catch (Exception $e)
		{
			if($catch_error)
			{
				errorHandler::processError(&$e);
			}
		}		
		
		if(strtoupper(substr($query,0,6)) == "INSERT")
		{
			return mysql_insert_id($this->mySQLLink);
		}
		elseif(strtoupper(substr($query,0,6)) == "UPDATE")
		{
			return mysql_affected_rows($this->mySQLLink);			
		}
	} 
	
	/**
	 * Runs an UPDATE statement
	 * 
	 * Returns the number of effected rows
	 *
	 * @param string $query
	 * @param bool $catch_error
	 * @return int
	 */
	function update($query, $catch_error = true)
	{

		$result = mysql_query($query, $this->mySQLLink);
	
		try
		{
			if(strlen(mysql_error($this->mySQLLink)) > 0)
			{
				throw new Exception("MySQL error: ".mysql_error($this->mySQLLink)."\n\n".$query);
			}
		}
		catch (Exception $e)
		{
			if($catch_error)
			{
				errorHandler::processError(&$e);
			}
		}		
		
		return mysql_affected_rows($this->mySQLLink);
	}
}

/**
 * Error handler
 *
 */
class errorHandler
{	
	/**
	 * Process the error!
	 *
	 * @param error object $e
	 */
	static function processError(&$e)
	{		
		$message = $e->getMessage()."\n";
		$message .= "Line ".$e->getLine()." in ".$e->getFile();
		
		$message .= "\n\nBacktrace\n========\n".self::parse_backtrace(debug_backtrace())."\n";
		$message .= "\n\nSession\n========\n".var_export($_SESSION, true)."\n";
		
		if($_SERVER['REMOTE_ADDR'] == developerIPAddress)
		{
			echo '<pre>';
			echo $message;
			echo '</pre>';
		}
		elseif(!isset($_SERVER['REMOTE_ADDR']))
		{
			echo "\n";
			echo $message;
			echo "\n";
		}
		else
		{	
			$strFrom = "From: \"".site_name."\" <".site_email.">\n";
			$strSubject = "[".site_name."] An Error has Occured";	
			$strBody .= "Message: ".$message."\n";
			mail(site_erroremail, $strSubject, $strBody, $strFrom);			

			echo '<html><head><title>An Error has Occured</title></head><body style="font-family: Tahoma; font-size: 12px;">';
			echo '<h1>An Error has Occured</h1>';
			echo '<p>An error has occured and this page cannot be displayed. This might be a temporary problem, so please try again soon. We have been notified of this error and apologise for any inconvience this may have caused.</p>';
			echo '</body></html>';
			exit;
		}
	}
	
	/**
	 * Bactrace of the error
	 *
	 * @param string $raw
	 * @return string
	 */
    static function parse_backtrace($raw)
    { 

	$output = ""; 
	
	foreach($raw as $entry)
	{ 
        $output.="\nFile: ".$entry['file']." (Line: ".$entry['line'].")\n"; 
        $output.="Function: ".$entry['function']."\n"; 
       // $output.="Args: ".implode(", ", $entry['args'])."\n"; 
	} 
	
		return $output; 
	} 
}
?>