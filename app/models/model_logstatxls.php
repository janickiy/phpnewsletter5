<?php

class Model_logstatxls extends Model
{
	public function getTimelog($id_log)
	{
		if (is_numeric($id_log)) {
			$query = "SELECT time FROM " . core::database()->getTableName('log') . " WHERE id_log=" . $id_log;
			$result = core::database()->querySQL($query);
			$row = core::database()->getRow($result);
			return $row['time'];
		}
	}
	
	public function getTotalfaild($id_log)
	{
		if (is_numeric($id_log)) {
			$query = "SELECT COUNT(*) FROM " . core::database()->getTableName('ready_send') . " WHERE id_log=" . $id_log . " AND success='no'";
			$result = core::database()->querySQL($query);
			$row = core::database()->getRow($result, 'assoc');
			return $row['COUNT(*)'];
		}
	}
	
	public function getTotaltime($id_log)
	{
		if (is_numeric($id_log)) {
			$query = "SELECT *,sec_to_time(UNIX_TIMESTAMP(max(time)) - UNIX_TIMESTAMP(min(time))) as totaltime FROM " . core::database()->getTableName('ready_send') . " WHERE id_log=" . $id_log;
			$result = core::database()->querySQL($query);
			$row = core::database()->getRow($result);
			return $row['totaltime'];
		}
	}
	
	public function getLogList($id_log)
	{
		if(is_numeric($id_log)) {
			$query = "SELECT *, a.time as time FROM " . core::database()->getTableName('ready_send') . " a
			LEFT JOIN " . core::database()->getTableName('users') . " b ON b.id_user=a.id_user
			LEFT JOIN " . core::database()->getTableName('template') . " s ON s.id_template=a.id_template
			WHERE id_log=" . $id_log;

			$result = core::database()->querySQL($query);
			return core::database()->getColumnArray($result);
		}
	}

	public function getTotalread($id_log)
	{
		if(is_numeric($id_log)) {
			$query = "SELECT COUNT(*) FROM " . core::database()->getTableName('ready_send') . " WHERE id_log=" . $id_log . " AND readmail='yes'";
			$result = core::database()->querySQL($query);
			$total = core::database()->getRow($result, 'assoc');
			return $total['COUNT(*)'];
		}
	}	
}