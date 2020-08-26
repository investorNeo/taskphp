<?php


namespace core;


abstract class Model implements \ArrayAccess { // $task->id => $task[id]
	protected $db;
	protected $table;
	private $dataResult = [];


	public function __construct( $select = false ) {
		// Подключаемся к базе
		$this->db = DB::connect();

		// имя таблицы
		$modelName   = get_class( $this );
		$arrExp      = explode( '\\', $modelName );
		$tableName   = strtolower( $arrExp[1] );
		$this->table = $tableName;

		// обработка запроса
		$sql = $this->_getSelect( $select ) ?: '';
		$this->_getResult( "SELECT * FROM {$this->table}{$sql};" );
		// "SELECT * FROM tasks ORDER BY id ASC LIMIT 3 OFFSET 0"

	}

	public function validate( $value ) {
		$value = trim( $value );
		$value = stripslashes( $value );
		$value = strip_tags( $value );
		$value = htmlspecialchars( $value );

		return $value;
	}

	// получить имя таблицы
	public function getTableName() {
		return $this->table;
	}

	// получить все записи
	public function getAllRows() {
		if ( empty( $this->dataResult ) ) {
			return [];
		}

		return $this->dataResult;
	}

	// получить одну запись
	public function getOneRow() {
		if ( empty( $this->dataResult ) ) {
			return false;
		}

		return $this->dataResult[0];
	}

	// извлечь из базы данных одну запись
	public function fetchOne(): bool {
		if ( empty( $this->dataResult ) ) {
			return false;
		}
		foreach ( $this->dataResult[0] as $key => $val ) {
			$this->$key = $val;
		}

		return true;
	}

	// получить запись по id
	public function getRowById( $id ) {
		$db   = $this->db;
		$stmt = $db->query( "SELECT * from {$this->table} WHERE id = {$id}" );

		return $stmt->fetch();
	}

	// запись в базу данных
	public function save() {
		$arrayAllFields = array_keys( $this->fieldsTable() );
		$arraySetFields = array();
		$arrayData      = array();
		foreach ( $arrayAllFields as $field ) {
			if ( ! empty( $this->$field ) ) {
				$arraySetFields[] = $field;
				$arrayData[]      = $this->$field;
			}
		}
		$forQueryFields = implode( ', ', $arraySetFields );
		$rangePlace     = array_fill( 0, count( $arraySetFields ), '?' );
		$forQueryPlace  = implode( ', ', $rangePlace );

		try {
			$db     = $this->db;
			$stmt   = $db->prepare( "INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)" );
			$result = $stmt->execute( $arrayData );
		} catch ( \PDOException $e ) {
			echo 'Error : ' . $e->getMessage();
			echo '<br/>Error sql : ' . "'INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)'";
			exit();
		}

		return $result;
	}

	// составление запроса к базе данных
	private function _getSelect( $select ) {
		$querySql = '';
		if ( is_array( $select ) ) {
//			Сбор sql запроса с соблюдением порядка операторов
			$allQuery = array_keys( $select );
			// $select       = array(
			// 	'order'  => $current_sort,
			// 	'limit'  => 3,
			// 	'offset' => $offset
			// );
			//  => ['order', 'limit', 'offset']
			array_walk( $allQuery, function ( &$val ) {
				$val = strtoupper( $val );
			} );
			// ['order', 'limit', 'offset'] => ['ORDER', 'LIMIT', 'OFFSET']

			if ( in_array( 'WHERE', $allQuery, true ) ) {
				foreach ( $select as $key => $val ) {
					if ( strtoupper( $key ) === 'WHERE' ) {
						$querySql .= ' WHERE ' . $val; // $val ==  "name = 'John' and id = 1"

				}
			}

			// '' => " WHERE name = 'John'"

			if ( in_array( 'GROUP', $allQuery, true ) ) {
				foreach ( $select as $key => $val ) {
					if ( strtoupper( $key ) === 'GROUP' ) {
						$querySql .= ' GROUP BY ' . $val;
					}
				}
			}

			if ( in_array( 'ORDER', $allQuery, true ) ) {
				foreach ( $select as $key => $val ) {
					if ( strtoupper( $key ) === 'ORDER' ) {
						$querySql .= ' ORDER BY ' . $val;
					}
				}
			}
			//  '' => " ORDER BY id ASC"

			if ( in_array( 'LIMIT', $allQuery, true ) ) {
				foreach ( $select as $key => $val ) {
					if ( strtoupper( $key ) === 'LIMIT' ) {
						$querySql .= ' LIMIT ' . $val;
					}
				}
			}
			// " ORDER BY id ASC" => " ORDER BY id ASC LIMIT 3"

			if ( in_array( 'OFFSET', $allQuery, true ) ) {
				foreach ( $select as $key => $val ) {
					if ( strtoupper( $key ) === 'OFFSET' ) {
						$querySql .= ' OFFSET ' . $val;
					}
				}
			}
		}
		}
		// " ORDER BY id ASC LIMIT 3" => " ORDER BY id ASC LIMIT 3 OFFSET 0"
		return $querySql;
	}


	/**
	 * Выполнение запроса к базе данных
	 *
	 * @param $sql string
	 *
	 * @return array
	 */
	private function _getResult( string $sql ): array {
		try {
			$db               = $this->db;
			$stmt             = $db->query( $sql );
			$rows             = $stmt->fetchAll();
			$this->dataResult = $rows;
		} catch ( \PDOException $e ) {
			echo 'Error : ' . $e->getMessage();
			echo '<br>Error sql : ' . $sql;
			exit();
		}

		return $rows;
	}


	/**
	 * Обновление записи. Происходит по ID
	 *
	 * @return bool
	 */
	public function update($arrayAllFields =[]): bool {
		$arrayForSet    = array();
		foreach ( $arrayAllFields as $field ) {
			if (  $this->$field !== null ) {
				if ( strtoupper( $field ) === 'ID' ) {
					$whereID = $this->$field;
				} else {
					$arrayForSet[] = "{$field}='{$this->$field}'";
				}
			}
		}
		if ( empty( $arrayForSet ) ) {
			echo "Array data table `$this->table` empty!";
			exit;
		}
		if ( empty( $whereID ) ) {
			echo "ID table `$this->table` not found!";
			exit;
		}

		$strForSet = implode( ', ', $arrayForSet );

		try {
		$db   = $this->db;
		$stmt = $db->prepare( "UPDATE ($this->table) SET {$strForSet} WHERE `id` = :whereID;" );
			$stmt->bindParam(':whereID', $whereID);
		$result = $stmt->execute();
		} catch ( \PDOException $e ) {
			echo 'Error : ' . $e->getMessage();
			echo '<br/>Error sql : ' . "'UPDATE {$this->table} SET {$strForSet} WHERE `id` = {$whereID}'";
			exit();
		}

		return $result;
	}



	public function offsetExists( $offset ): bool {
		return isset( $this->$offset );
	}


	public function offsetGet( $offset ) {
		return $this->$offset;
	}


	public function offsetSet( $offset, $value ) {
		$this->$offset = $value;
	}


	public function offsetUnset( $offset ) {
		unset( $this->$offset );
	}

	abstract public function fieldsTable();

}
