<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_produtos ORDER BY produto_id";
    $resultado = mysqli_query($link,$sql);

    
    if($resultado){
            echo '<option value="0">Selecione...</option>';
        while($dados = mysqli_fetch_array($resultado)){
            echo '<option value="'.$dados['produto_id'].'">'.$dados['produto_id']. ' - ' . $dados['produto_descricao'] .'</option>';  
        }
    } else{
        echo 'Consulta não realizada!';
    }
?>