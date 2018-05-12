<?php
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$mysqli->set_charset("utf8");
	
	function showDate($time) {
		return date('d/m/y | H:i', $time);
	}


	
	//Core

    function select($table, $id = 0) {
        if ($id > 0) {
            $query = "SELECT * FROM `$table` WHERE `id`=$id";
            return getRow($query);
        }
        else {
            $query = "SELECT * FROM `$table` ORDER BY `id` DESC";
            return getTable($query);
        }

    }

	function getCell($query) {
		global $mysqli;
		$result_set = $mysqli->query($query);
		if (is_null($result_set) || !$result_set->num_rows) return false;
		$arr = array_values($result_set->fetch_assoc());
		$result_set->close();
		return $arr[0];
	}
	
	function getRow($query) {
		global $mysqli;
		$result_set = $mysqli->query($query);
		if (is_null($result_set)) return false;
		$row = $result_set->fetch_assoc();
		$result_set->close();
		return $row;
	}
	
	function getCol($query) {
		global $mysqli;
		$result_set = $mysqli->query($query);
		if (is_null($result_set)) return false;
		$row = $result_set->fetch_assoc();
		$result_set->close();
		if ($row) return array_values($row);
		return false;
	}
	
	function getTable($query) {
		global $mysqli;
		$result_set = $mysqli->query($query);
		if (is_null($result_set)) return false;
		$result = array();
		while (($row = $result_set->fetch_assoc()) != false) {
			$result[] = $row;
		}
		$result_set->close();
		return $result;
	}
	
	function addRow($table, $data) {
		global $mysqli;
		$query = "INSERT INTO `$table` (";
		foreach ($data as $key => $value) $query .= "`$key`,";
		$query = substr($query, 0, -1);
		$query .= ") VALUES (";
		foreach ($data as $value) {
			if (is_null($value)) $query .= "null,";
			else $query .= "'".$mysqli->real_escape_string($value)."',";
		}
		$query = substr($query, 0, -1);
		$query .= ")";
		$result_set = $mysqli->query($query);
		if (!$result_set) return false;
		return $mysqli->insert_id;
	}
	
	function setRow($table, $id, $data) {
		if (!is_numeric($id)) exit;
		global $mysqli;
		$query = "UPDATE `$table` SET ";
		foreach ($data as $key => $value) {
			$query .= "`$key` = ";
			if (is_null($value)) $query .= "null,";
			else $query .= "'".$mysqli->real_escape_string($value)."',";
		}
		$query = substr($query, 0, -1);
		$query .= " WHERE `id` = '$id'";
		return $mysqli->query($query);
	}
	
	function deleteRow($table, $id) {
		if (!is_numeric($id)) exit;
		global $mysqli;
		$query = "DELETE FROM `$table` WHERE `id`='$id'";
		return $mysqli->query($query);
	}
	
	function xss($data) {
		if (is_array($data)) {
			$escaped = array();
			foreach ($data as $key => $value) {
				$escaped[$key] = xss($value);
			}
			return $escaped;
		}
		return trim(htmlspecialchars($data));
	}
	
	function redirect($link) {
		header("Location: $link");
		exit;
	}
	
	function hashSecret($str) {
		return md5($str.SECRET);
	}
	
?>