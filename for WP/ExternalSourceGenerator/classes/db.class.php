<?php
class db {
	function ExecQuery( $query ) {
		$res = mysql_query( $query );
		$i = 0;
		if ( is_bool($res) ) {
			$result['count'] = 0;
		} else {
			$result['count'] = mysql_num_rows( $res );
			while ( $row = mysql_fetch_array( $res ) )	{
				$rowArr[$i++] = $row;
			}
			$result['rows'] = $rowArr;
			mysql_free_result( $res );
		}
		return $result;
	}

	function GenWhere( $wr, $orAnd = 'AND' ) {
		$where = '';
		foreach ( $wr as $field => $value ) {
			if ( strlen( $where ) > 0 ) $where .= ' '.$orAnd.' ';
			if ( preg_match( '/^(NOT\s)?NULL$/', $value ) ) {
				$where .= ' `'.$field.'` IS '.mysql_real_escape_string( $value ).'';
			} else {
				$where .= ' `'.$field.'`=\''.mysql_real_escape_string($value).'\'';
			}
		}
		$result = ' WHERE '.$where;
		return $result;
	}

	function genInsert( $ins ) {
		foreach ( $ins as $field => $value ) {
			if ( strlen( $fields ) > 0 ) $fields .= ', ';
			if ( strlen($values) > 0 ) $values .= ', ';
			$fields .= '`'.$field.'`';
			if ( $value != 'NULL' ) {
				$values .= "'".mysql_real_escape_string( $value )."'";
			} else {
				$values .= "".mysql_real_escape_string( $value )."";
			}
		}
		$result = ' ('.$fields.') VALUES ('.$values.')';
		return $result;
	}

	function genUpdate( $upd ) {
		foreach ( $upd as $field => $value ) {
			if ( strlen( $set ) > 0 ) $set .= ', ';
			if ( $value != 'NULL' ) {
				$set .= ' `'.$field.'`=\''.mysql_real_escape_string( $value ).'\'';
			} else {
				$set .= ' `'.$field.'`='.mysql_real_escape_string( $value );
			}
		}
		return $set;
	}
}
?>