<?php
$serverName = "DESKTOP-IR5ETQ8"; //serverName\instanceName
$connectionInfo = array( "Database"=>"TenebrosaOLTP", "UID"=>"sa", "PWD"=>"pablo156324");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

$sql = "SELECT nrodias,descripcion FROM formapago WHERE formaPago <>'C'";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


?>