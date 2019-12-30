<?

class DB {

	function __construct () {
		$this->DB = new mysqli('localhost', '', '', '');

		foreach ($_POST as $key=>$value) {
			if (is_array($value)) {
				if ($value['id']) $this->update($key, $value);
				else $this->insert($key, $value);
			}
		}

	}

	function select ($table, $where) {

		foreach ($where as $key=>$value) {
			$pairs[] = "`$key` = '$value'";
		}

		if ($pairs) $where=' WHERE '. implode(' AND ', $pairs);

		$rows=$this->DB->query("SELECT * FROM `{$table}`" . $where);

		while($row = $rows->fetch_assoc()) {
			$result[$row['id']] = $row;
		}

		return $result;

	}

	function insert ($table, $values) {

		foreach ($values as $key=>$value) {
			$fields[] = "`$key`";
			$fieldValues[] = "'$value'";
		}
		$this->DB->query("INSERT INTO `{$table}` (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $fieldValues) . ")");

	}

	function update ($table, $values) {

		foreach ($values as $key=>$value) {
			$pairs[] = "`$key` = '$value'";
		}
		$this->DB->query("UPDATE `{$table}` SET " . implode(', ', $pairs) . " WHERE `id` = {$values['id']}");

	}

	function __destruct () {
		$this->DB->close();
	}

}

$DB = new DB;