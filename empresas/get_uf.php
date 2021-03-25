<?php
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_uf";

    $resultado = mysqli_query($link,$sql);

    if($resultado){
            echo '<option value="">UF</option>';
        while($dados = mysqli_fetch_array($resultado)){
            echo '<option value="'.$dados['uf'].'">'.$dados['uf'].'</option>';  
        }
    } else{
        echo 'Consulta não realizada!';
    }
?>