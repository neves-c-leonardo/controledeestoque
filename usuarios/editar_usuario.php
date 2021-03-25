<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $usuario = $_POST['id'];
    $ativo = $_POST['ativo'];
    $senha_editar = md5($_POST['senha_editar']);
    $permissao_editar = $_POST['permissao_editar'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    if($senha_editar == 'd41d8cd98f00b204e9800998ecf8427e'){
        $sql = "UPDATE tb_usuario SET usuario_ativo = '$ativo', permissao_id = $permissao_editar WHERE usuario_id = '$usuario';";
    }else{
        $sql = "UPDATE tb_usuario SET usuario_senha = '$senha_editar', usuario_ativo = '$ativo', permissao_id = $permissao_editar WHERE usuario_id = '$usuario';";
    }
    
    // Executa a query
    if(mysqli_query($link, $sql)){
        $usuario_logado = $_SESSION['usuario'];
        $descricao = 'Alterando dados do usuário: ' . $usuario .; 

        $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_usuario','$descricao','$usuario_logado')";

        if(mysqli_query($link, $sql)){
            header('Location: usuarios.php?editado=1');          
        } else { 
            header('Location: usuarios.php');      
        }
    } 
    else { 
        header('Location: usuarios.php');
    }


?>