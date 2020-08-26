<?php


require_once __DIR__ . '/core/DB.php';

use core\DB;

$pdo = DB::connect();


function getMigrationFiles( $pdo ) {
	$dir      = __DIR__ . '/migration/';
	$allFiles = glob( $dir . '*.sql' );

	$query = $pdo->query("SHOW TABLES LIKE 'versions';");
	$data = $query->fetchAll();

	if ( !count($data) ) {
		return $allFiles;
	}
	$versionsFiles = array();
	$data  = $pdo->query( 'SELECT `name` FROM `versions`;' );
	foreach ( $data as $row ) {
		array_push( $versionsFiles, $dir.$row['name'] );
	}

	return array_diff( $allFiles, $versionsFiles );
}


function migrate( $pdo, $file ) {
	$command = file_get_contents($file);
	$pdo->exec($command);

	$baseName = basename($file);
	$query = $pdo->prepare('INSERT INTO `versions` (`name`) VALUES(:basename)');
	$query->bindParam(':basename',$baseName, PDO::PARAM_STR);
	$query->execute();
}

$files = getMigrationFiles( $pdo );

if ( empty( $files ) ) {
	echo 'Base in a action state'.PHP_EOL;
} else {
	foreach ( $files as $file ) {
		migrate( $pdo, $file );
	}
	echo 'Migration complite upload'.PHP_EOL;
}

