<?php

/********************************************
 * PHP Newsletter 5.1.2
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class DB {
	public $dbh = null;
	public $config;
	public $tablename;
	public $where;
	public $order;
	public $pnumber;
	public $group;
	public $parameters = '*';
	public $page;

	public function __construct($config){
		$this->config = $config;
		$this->openConnection();
	}

	function __destruct() {
        if (isset($this->dbh)){             
            $this->closeConnection();  
        }
    }

	/**
	 * @return mysqli|null
	 * @throws Exception
	 */
	public function openConnection(){
		$config = $this->config;
		
		if (is_null($this->dbh)) {
			
            $this->dbh = new mysqli($config["host"], $config["user"], $config["passwd"], $config["name"], isset($config['port']) && !empty($config['port']) ? $config['port'] : 3306);
			
            if (mysqli_connect_errno()) {
                $this->dbh = null;				
				echo "<!DOCTYPE html>";
                echo "<html>";
                echo "<head>";
                echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
                echo "<title>SQL error</title>";
                echo "</head>";
                echo "<body>";
                echo "<p>An error occurred while accessing SQL database!</p>";
                echo "<p>" . mysqli_connect_error() . "</p>";
                echo "</body>";
                echo "</html>";
				exit;			
            } else {
                mysqli_report(MYSQLI_REPORT_ERROR);
            }
			
			if ($config["charset"] != '') { 
				$this->dbh->query("SET NAMES ".$config["charset"]."");
			}
			
			$this->dbh->query("SET sql_mode = (SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
			$this->dbh->query("SET sql_mode = (SELECT REPLACE(@@sql_mode,'NO_ZERO_DATE',''))");
        }
        return $this->dbh;
	}

	public function closeConnection() {
		if (!is_null($this->dbh)) {
			$this->dbh->close();
		}
	}

	/**
	 * @param $tbl
	 * @return string
	 */
	public function getTableName($tbl) {
		$config = $this->config;
        return ".`" . $config["prefix"] . $tbl . "`";
    }

	/**
	 * @return array|int
	 * @throws ExceptionSQL
	 */
	public function get_page()
	{
		if (empty($this->page)) $this->page = 1;
		$total = $this->get_total();
		$number = (int)($total / $this->pnumber);
		if ((float)($total / $this->pnumber) - $number != 0) $number++;
		if ($this->page <= 0 || $this->page > $number) return 0;

		$arr = array();
		$first = ($this->page - 1) * $this->pnumber;

		$query = "SELECT " . $this->parameters . " FROM " . $this->tablename . "
					" . $this->where . "
					" . $this->group . "
					" . $this->order . "
					LIMIT " . $first . ", " . $this->pnumber . "";

		$result = $this->dbh->query($query);

		if (!$result) {
			throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");
		}

		if ($result->num_rows){
			while($arr[] = $result->fetch_array());
		}
		
		$result->close();

		unset($arr[count($arr) - 1]);

		return $arr;
	}

	/**
	 * @param string $parameters
	 * @return mixed
	 * @throws ExceptionSQL
	 */
	public function get_total($parameters = '*')
	{
		$query = "SELECT COUNT($parameters) FROM " . $this->tablename . "
									   " . $this->where . "
									   " . $this->order . "";

		$tot = $this->dbh->query($query);

		if (!$tot) {
			throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");
		}

		$count = $tot->fetch_row();

		return $count[0];
	}

	/**
	 * @param $str
	 * @return mixed
	 */
	public function escape($str)
	{
		return $this->dbh->real_escape_string($str);
	}

	/**
	 * @param $result
	 * @return mixed
	 */
	public function getRecordCount($result){
		return $result->num_rows;
	}

	/**
	 * @param $result
	 * @param string $mode
	 * @return bool
	 */
	public function getRow($result, $mode = 'array') {
		if ($result) {
			if ($mode == 'array') {
				return $result->fetch_array();
			}
			elseif ($mode == 'assoc') {
				return $result->fetch_assoc();
			}
			elseif ($mode == 'row') {
				return $result->fetch_row();
			} else {
				return false;
			}
		}
	}

	/**
	 * @param string $parameters
	 * @param $from
	 * @param string $where
	 * @param string $group
	 * @param string $order
	 * @param string $limit
	 * @return mixed
	 * @throws ExceptionSQL
	 */
	public function select($parameters = '*', $from, $where = '', $group = '', $order = '', $limit = '') {
		$query = "SELECT " . $parameters . " FROM " . $from . " 
					" . $where . "
					" . $group . "
					" . $order . "
					" . $limit . "";
					
		$result = $this->dbh->query($query);
		
		if (!$result) {
			throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");
		}
		
		return $result;
	}

	/**
	 * @param $result
	 * @return array
	 */
	public function getColumnArray($result)	{
		$arr = array();
		
		if ($this->getRecordCount($result) > 0)	{
			while($arr[] = $this->getRow($result));
		}
		
		unset($arr[count($arr) - 1]);
		
		return $arr;
	}

	/**
	 * @param $fields
	 * @param $table
	 * @param string $where
	 * @return bool
	 * @throws ExceptionSQL
	 */
	public function update($fields, $table, $where = "") {
	
		if (!$table && !is_null($this->dbh))
			return false;
		else {
			if (!is_array($fields))
				$flds = $fields;
			else {
				$flds = '';
				
				foreach ($fields as $key => $value) {
					if (!empty ($flds))
						$flds .= ",";
					$flds .= $key . "=";
					$value = $this->escape($value);
					$flds .= "'" . $value . "'";
				}
			}
			
			$where = ($where != "") ? "WHERE " . $where : "";
			$query = "UPDATE " . $table . " SET " . $flds . " " . $where . "";
			
			if($this->dbh->query($query))
				return true;
			else
				throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");
		}
	}

	/**
	 * @param $query
	 * @return bool
	 * @throws ExceptionSQL
	 */
	public function querySQL($query) {
		if ($query) {
			$result = $this->dbh->query($query);
			if (!$result)
				throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");
			else
				return $result;
		}
		else
			return false;
	}

	/**
	 * @param $data
	 * @param $table
	 * @return mixed
	 * @throws ExceptionSQL
	 */
	public function insert($data, $table) {
        $columns = "";
        $values = "";
		
        foreach ($data as $column => $value) {
			$value = $this->escape($value);
            $columns .= $columns ? ', ' : '';
            $columns .= "`$column`";
            $values  .= $values 	? ', ' : '';
            $values  .= "'$value'";
        }
		
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        if (!$this->dbh->query($sql)) throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");

        return $this->dbh->insert_id;
    }

	/**
	 * @param $table
	 * @param string $where
	 * @param string $fields
	 * @return bool
	 * @throws ExceptionSQL
	 */
	public function delete($table, $where = '', $fields = '') {
		if (!$table)
			return false;
		else {
			$where = ($where != "") ? "WHERE ".$where."" : "";
			
			$query = "DELETE " . $fields . " FROM " . $table . " " . $where . "";
			$result = $this->dbh->query($query);
			
			if (!$result)
				throw new ExceptionSQL($this->dbh->error, $query, "Error executing SQL query!");
			else
				return true;			
		}
	}
}