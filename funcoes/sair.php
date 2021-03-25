<?php
    session_start();

    require_once('../db/db_class.php');

    $usuario_nome = $_SESSION['usuario_nome'];
    $usuario_logado = $_SESSION['usuario'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_usuario','$usuario_nome Saiu do sistema','$usuario_logado')";
    mysqli_query($link, $sql);
    

    unset($_SESSION['usuario_id']);
    unset($_SESSION['usuario']);
    unset($_SESSION['usuario_nome']);

    header('Location: ../index.php');
    
?>