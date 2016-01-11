<?php

class DB {
	private $_db;

	public function __construct() {
		// mysqli(hostname, username, password, database_name);
		@$this->_db = new mysqli("localhost", "root", "", "test");

		if ( mysqli_connect_errno() ) {
			$error_code    = $this->_db->connect_errno;
			$error_message = $this->_db->connect_error;


			echo "ERROR: $error_code <br />";
			echo "Message: $error_message";
			exit;
		}
	}

	/*
	 	Syntax of parameters
			- fields have many options 
				1. ['*'] 
			 	2. ['field1', 'field2', ... , 'fieldN']
		 	- condition have many options too
		 		1. ['field', 'operator', 'value']
		 		2.  [
		 				['field1', 'operator', 'value'],
		 				['field2', 'operator', 'value'],
		 				... ,
		 				['fieldN', 'operator', 'value']
		 			]
	
	*/
	public function select($fields, $condition="") {
		try {
			$query = "SELECT ";

			// fields
			if ( $fields[0] == "*" ) {
				$query .= "*";
			} else {
				foreach ( $fields as $f ) {
					$query .= "`$f`" . ",";
				}
				
				$query = trim($query, ',');
			}
			$query .= " FROM " . $this->table;

			// condition
			if ( $condition != "" ) {
				$query .= " WHERE ";
				for ( $i = 0; $i < count($condition); $i+=2 ) {
					$query .= $condition[$i][0] . $condition[$i][1] . "'" . $this->_db->real_escape_string($condition[$i][2]) . "'";

					if ( !empty( $condition[$i+1] ) ) {
						$query .= " " . $condition[$i+1] . " ";
					} else {
						break;
					}
				}
			}
			// echo $query;

			$result = $this->_db->query($query);

			if ( $result != false ) {
				if ( $result->num_rows > 0 ) {
					while ( $row = $result->fetch_assoc() ) {
						$rows[] = $row;
					}

					$result->free();
					return $rows;
				} else {
					error_log( "Mysql 0 row result." );
					return null;
				}
			} else {
				error_log( "Error: You have an error in your SQL syntax." );
				return false;
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			return false;
		}
	}

	/*
	 	Syntax of parameters
			- fields
			 	1. ['field1', 'field2', ... , 'fieldN']
		 	- values have many options
		 		1. ['value1', 'value2', ... , 'valueN']
		 		2.  [
		 				['value1', 'value2', 'valueN'],
		 				['value1', 'value2', 'valueN'],
		 				... ,
		 				['valueN', 'valueN', 'valueN']
		 			]
	
	*/
	public function insert($fields, $values) {
		try {
			// fields
			$query = "INSERT INTO " . $this->table . "(";
			foreach ( $fields as $f ) {
				$query .= "`$f`" . ",";
			}
			$query = trim($query, ',');
			$query .= ") VALUES";

			// values
			if ( !is_array($values[0]) ) { // if one-dimensional array
				$query .= "(";
				foreach ( $values as $v ) {
					$query .= "'" . $this->_db->real_escape_string($v) . "'" . ",";
				}
				$query = trim($query, ",");
				$query .= ")";
			} else {
				foreach ( $values as $v ) {
					$query .= "(";
					foreach ($v as $v2) {
						$query .= "'" . $this->_db->real_escape_string($v2) . "'" . ",";
					}
					$query = trim($query, ",");
					$query .= "),";
				}
				$query = trim($query, ",");
			}

			// echo $query;

			$result = $this->_db->query($query);

			if ( $result != false ) {
				if ( $result > 0 ) {
					return true;
				} else {
					error_log( "0 row Affected." );
					return null;
				}
			} else {
				error_log( "Error: You have an error in your SQL syntax." );
				return false;
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			return false;
		}	
	}

	/*
	 	Syntax of parameters
			- fields
			 	1. ['field1', 'field2', ... , 'fieldN']
		 	- values
		 		1. ['value1', 'value2', ... , 'valueN']
		 	- condition have many options
		 		1. ['field', 'operator', 'value']
		 		2.  [
		 				['field1', 'operator', 'value'],
		 				['field2', 'operator', 'value'],
		 				... ,
		 				['fieldN', 'operator', 'value']
		 			]
	
	*/
	public function update($fields, $values, $condition="") {
		try {
			// fields
			$query = "UPDATE " . $this->table . " SET ";
			for ( $i = 0 ; $i < count($fields) && count($values); $i++ ) {
				$query .= $fields[$i] . "=" . "'" . $this->_db->real_escape_string($values[$i]) . "'" . ",";
			}
			$query = trim($query, ',');

			// condition
			if ( $condition != "" ) {
				$query .= " WHERE ";

				for ( $i = 0; $i < count($condition); $i+=2 ) {
					$query .= $condition[$i][0] . $condition[$i][1] . "'" . $this->_db->real_escape_string($condition[$i][2]) . "'";

					if ( !empty( $condition[$i+1] ) ) {
						$query .= " " . $condition[$i+1] . " ";
					} else {
						break;
					}
				}
			}

			// echo $query;

			$result = $this->_db->query($query);

			if ( $result != false ) {
				if ( $result > 0 ) {
					return true;
				} else {
					error_log( "0 row Affected." );
					return null;
				}
			} else {
				error_log( "Error: You have an error in your SQL syntax." );
				return false;
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			return false;
		}	
	}

	/*
		Syntax of parameter
		- condition have many options
			1. ['field', 'operator', 'value']
			2.  [
					['field1', 'operator', 'value'],
					['field2', 'operator', 'value'],
					... ,
					['fieldN', 'operator', 'value']
				]
	*/
	public function delete($condition="") {
		try {
			$query = "DELETE FROM " . $this->table;

			// condition
			if ( $condition != "" ) {
				$query .= " WHERE ";

				for ( $i = 0; $i < count($condition); $i+=2 ) {
					$query .= $condition[$i][0] . $condition[$i][1] . "'" . $this->_db->real_escape_string($condition[$i][2]) . "'";

					if ( !empty( $condition[$i+1] ) ) {
						$query .= " " . $condition[$i+1] . " ";
					} else {
						break;
					}
				}
			}

			// echo $query;

			$result = $this->_db->query($query);

			if ( $result != false ) {
				if ( $result > 0 ) {
					return true;
				} else {
					error_log( "0 row Affected." );
					return null;
				}
			} else {
				error_log( "Error: You have an error in your SQL syntax." );
				return false;
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			return false;
		}	
	}
}