<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sql Server</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>

  

<style>
     body {
          background-color: #3D9970;
     }
     .padre
     {
          display:flex;
          justify-content:center;
          align-items:center;
     }
     .margincard{
          margin-top:20px;
     }
</style>
<body>
<?php include('conexion.php'); ?>
<div class="padre">
<div class="card margincard" style="width: 50rem;">
     <div class="card-body">
     <h5 class="card-title">Sql Server - Php</h5>
     <div class="row">
          <div class="col-md-3">
          <div class="form-check">
               <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="F">
               <label class="form-check-label" for="flexRadioDefault1">
                    Factura
               </label>
          </div>
          <div class="form-check">
               <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked value="B">
               <label class="form-check-label" for="flexRadioDefault2">
                    Boleta de Venta
               </label>
          </div></div>
          <div class="col-md-3">
               <label for="" class="required">Documento</label>
               <input type="text" name="documento" id="documento" class="form-control">
          </div>
          <div class="col-md-3">
          <label for="" class="required">Nro Cuotas</label>
          <select class="form-select"  id="nrocuota" name="nrcocuota">
              
               <?php while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                         echo '<option value="'.$row['nrodias'].'">'.$row['descripcion'].'</option>';
                    }
               ?>
          </select>
          </div>
          <div class="col-md-3">
          <br>
          <button id="button" class="btn btn-primary">Enviar</button>
          </div>
     </div>
     <br><br>
     <div class="row">
          <table id="table_id" class="display">
          <thead>
               <tr>
                    <th>F.Vencimiento</th>
                    <th>Capital</th>
                    <th>Interes</th>
                    <th>Igv</th>
                    <th>Cuota</th>
               </tr>
          </thead>
          <tbody>

          </tbody>
          </table>
     </div>     
     </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    } );
    $('#button').click(function(){
         tipodocumento=$('input:radio[name=flexRadioDefault]:checked').val()
         documento=$("#documento").val();
         nrcuota=$( "#nrocuota option:selected" ).val();
         if(tipodocumento.length==0 || documento.length==0 || nrcuota.length==0)
         {
          toastr.error("Error","Falta ingresar datos");
         }
         else
         {
          $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: {
                 action: "insert",
                 documento: documento,
                 tipodocumento:tipodocumento,
                 nrcuota:nrcuota
            },
            success: function(response)
            {
                 var jsonData = JSON.parse(response);
                 //console.log(jsonData);
                 if(jsonData.error===undefined)
                 {
                    //console.log("entro")
                    var t = $('#table_id').DataTable();
                    jsonData.forEach((value, index, array) => {
                         t.row.add( [ value.FechaVencimiento.date,
                                      value.Capital,
                                      parseFloat(value.Interes),
                                      parseFloat(value.Igv),
                                      value.Cuota
                    ] ).draw( false );

                    });
                    
 
                 }
                 else{
                    toastr.error(jsonData.error[0].message,"Error")  
                 }
                 
           }
       });
         }
         //("exito","exito")
  
    });
} );

</script>
</body>
</html>