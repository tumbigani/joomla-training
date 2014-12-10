<?php
/**
 * class for database connectivity
 */
class Db
{
	protected $db_host = "localhost";

	protected $db_user = "root";

	protected $db_pwd = "tailored";

	protected $db_name = "employee_db";

	public $connect = "";
	/**
	 * [connect to  database]
	 *
	 * @return  void
	 */
	public function connect()
	{
		$connect = new mysqli($this->db_host, $this->db_user, $this->db_pwd, $this->db_name);

		if (mysqli_connect_errno())
		{
			printf("connection failed" . mysqli_connect_errno());
			exit();
		}
		else
		{
		}

		return $connect;
	}

	/**
	 * [query execute query in database]
	 *
	 * @param   string  $qry  sql query
	 *
	 * @return  void
	 */
	public function query($qry)
	{
		$obj = new Db;
		mysqli_query($obj->connect(), $qry);
		printf("Record inserted");
	}

	/**
	 * [selquery for fetch record in table]
	 *
	 * @param   string  $qry  sql select query
	 *
	 * @return  array        array of records
	 */
	public function selquery($qry)
	{
		$obj2 = new Db;
		$arr = mysqli_query($obj2->connect(), $qry);

		return $arr;
	}


}