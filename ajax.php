<?php
include('conexion.php');
if (isset($_POST['action'])) {
    $documento=$_POST['documento'];
    $tipodocumento=$_POST['tipodocumento'];
    $nrcuota=$_POST['nrcuota'];
  // echo json_encode(array('documento' => $documento, 'nrcuota' => $nrcuota,'tipodocumento' => $tipodocumento));
   $sql = "EXEC GeneraCrono @documento ='".$documento. "', @tipodoc ='" .$tipodocumento. "', @NroCuotas ='" .$nrcuota."'";

$stmt = sqlsrv_prepare( $conn, $sql);
if( !$stmt ) {
    echo json_encode(array("error"=>"preparar"));
    die( print_r( sqlsrv_errors(), true));
}
    $ejecutarsql =sqlsrv_execute( $stmt );
    if($ejecutarsql === false ) {
         echo json_encode(array("error"=>sqlsrv_errors()));
         // die( print_r( sqlsrv_errors(), true));
          
    }
    else
    {
        $arreglo=array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           array_push($arreglo,array(
               "FechaVencimiento"=>$row['FeVence'],
               "Capital"=>$row['Importe'],
               "Interes"=>$row['Interes'],
               "Igv"=>$row['IgvInteres'],
               "Cuota"=>$row['ValorCuota'],

            ));
          // echo $row['TipoDoc'];
            //echo $row['LastName'].", ".$row['FirstName']."<br />";
        }
        echo json_encode($arreglo);
    }

}

?>