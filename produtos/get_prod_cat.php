<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_categoria ORDER BY categoria_id";
    $resultado = mysqli_query($link,$sql);

    if($resultado){
            echo '<option value="0">Selecione...</option>';
        while($dados = mysqli_fetch_array($resultado)){
            echo '<option value="'.$dados['categoria_id'].'">'.$dados['categoria_descricao'].'</option>';  
        }
    } else{
        echo 'Consulta não realizada!';
    }
?>