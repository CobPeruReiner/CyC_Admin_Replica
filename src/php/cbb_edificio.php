
<?php 
        require_once("clsContacto.php");
        //echo sizeof($var);
			
        echo '<option></option>';
        for ($i=1; $i <= $_REQUEST['id'] ; $i++) { 
            
                $var = clsContacto::listar_detalle(utf8_decode($_REQUEST['dep']),$i);
                //echo $var[0];
                if (sizeof($var)==1){
             	   echo "<option value=".$i." disabled >Un. Inmobiliaria ".$i."</option>";
                }else{
                    echo "<option value=".$i."  >Un. Inmobiliaria ".$i."</option>";
                }
         }
         
		

?>

