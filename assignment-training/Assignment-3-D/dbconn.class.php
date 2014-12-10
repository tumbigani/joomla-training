<?php
/**
 * Class for database connectivity
 */
class Db
{

	/**
	 * [connect description]
	 *
	 * @param   string  $db_host  server host name
	 * @param   string  $db_user  server user name
	 * @param   string  $db_pwd   server password
	 * @param   string  $db_name  database name
	 *
	 * @return  void
	 */
	public function connect($db_host,$db_user,$db_pwd,$db_name)
	{
		$connect = new mysqli($db_host, $db_user, $db_pwd, $db_name);

		if (mysqli_connect_errno())
		{
			printf("connection failed");
			exit();
		}
		else
		{
			printf("connection successfullly");
		}
	}
}
