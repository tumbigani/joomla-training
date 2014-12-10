<?php
/**
 * Class for connectivity of database
 */
class Db
{
	protected $db_host = "localhost";

	protected $db_user = "root";

	protected $db_pwd = "tailored";

	protected $db_name = "shopping";

	public $connect = "";

	/**
	 * [connect to database]
	 *
	 * @return  void
	 */
	public function connect()
	{
		$connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pwd, $this->db_name);

		if (mysqli_connect_errno())
		{
			printf("connection failed" . mysqli_connect_errno());
			exit();
		}

		return $connect;
	}
	/**
	 * [qry for execute sql query]
	 *
	 * @param   string  $qry  sql query
	 *
	 * @return  array        fetch record in table
	 */
	public function qry($qry)
	{
		$ary = mysqli_query($this->connect(), $qry);
		return $ary;

	}
}
