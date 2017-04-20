<?php

function dbQuery($sql){
	$mysql = new mysqli(sql_server, sql_user, sql_pass, sql_database );
	$result = $mysql->query($sql);

	if ($result === FALSE) {
		return FALSE;
	}
	elseif (preg_match("/INSERT/", $sql) && $result) {
		return $mysql->insert_id;
	}
	else{
		if ($result === TRUE ) {
			return TRUE;
		}
		else{
			$result_array = array();
			while ($i = $result->fetch_assoc()) {
				array_push($result_array, $i);
			}
			return $result_array;
		}
	}
}

?>