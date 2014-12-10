<?php
/**
 * Class for connect to database
 */
class Db
{
	/**
	 * [connect to database]
	 *
	 * @param   string  $db_host  server host name
	 * @param   string  $db_user  user name
	 * @param   string  $db_pwd   password of user
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
