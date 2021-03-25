<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    // Quantidade de Usuários Cadastrados
    $sql = "SELECT versao FROM tb_parametros";
    $resultado = mysqli_query($link,$sql);
    $dados = mysqli_fetch_array($resultado);
    echo '<p>Versão: '.$dados['versao'].'</p>';
?>