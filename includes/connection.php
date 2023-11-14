<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=XXXXXDATABASE_NAMEXXXXXX', 'XXXXUSERXXXX', 'XXXXXXXPASSWORDXXXXXXX');
} catch (PDOException $e) {
	exit('Database error.');
}

?>
