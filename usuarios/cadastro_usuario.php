<?php
    session_start();

    require_once('../db/db_class.php'); 

    $permissao = $_POST['permissao'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $fone = $_POST['fone'];
    $user = $_POST['user'];
    $senha = md5($_POST['senha']);

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $usuario_existe = false;
    $email_existe = false;

    // Verificar se o usuário já existe
    $sql = "SELECT * FROM tb_usuario WHERE usuario = '$user' ";
    if($resultado = mysqli_query($link,$sql)){
       $dados = mysqli_fetch_array($resultado);
        if(isset($dados['usuario'])){
            $usuario_existe = true;
        }
    } else{
        echo 'Erro ao tentar localizar o registro de usuario';
    }

    // Verificar se o e-mail já existe
    $sql = "SELECT * FROM tb_usuario WHERE usuario_email = '$email' ";
    if($resultado = mysqli_query($link,$sql)){
       $dados = mysqli_fetch_array($resultado);
        if(isset($dados['usuario_email'])){
            $email_existe = true;
        }
    } else{
        echo 'Erro ao tentar localizar o registro de e-mail';
    }

    if($usuario_existe || $email_existe){
        $retorno_get = '';

        if($usuario_existe){
            $retorno_get.= "erro_usuario=1&";
        }

        if($email_existe){
            $retorno_get.= "erro_email=1&"; 
        }

        header('Location: cusuarios.php?'.$retorno_get);
    }else{  
        $sql = "INSERT INTO tb_usuario(permissao_id,usuario_nome,usuario_email,usuario_fone,usuario,usuario_senha,usuario_ativo)
        VALUES ('$permissao','$nome','$email','$fone','$user','$senha','S')";

        // Executa a query
        if(mysqli_query($link, $sql)){
            $usuario_logado = $_SESSION['usuario'];
            $descricao = 'Foi inserido o usuário ' . $user . ' ao sistema'; 

            $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                VALUES('tb_usuario','$descricao','$usuario_logado')";

            if(mysqli_query($link, $sql)){
                header('Location: usuarios.php');
            } else { 
                echo 'Erro ao inserir log';            
            }
        } 
        else { 
            echo "Erro na conexão com o banco!";
        }
    }

?>