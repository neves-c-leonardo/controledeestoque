<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $usuario = $_SESSION['usuario_id'];
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_fone = $_POST['usuario_fone'];
    $usuario_senha = md5($_POST['usuario_senha']);

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $email_existe = false;

    $sql = "SELECT * FROM tb_usuario WHERE usuario_email = '$usuario_email' ";

    if($resultado = mysqli_query($link,$sql)){
        $dados = mysqli_fetch_array($resultado);

        if(isset($dados['usuario_email'])){

            $sql = "SELECT * FROM tb_usuario WHERE usuario_id = '$usuario' ";

            if($resultado = mysqli_query($link,$sql)){
                $dados = mysqli_fetch_array($resultado);
                $aux_email = $dados['usuario_email'];

                if($aux_email == $usuario_email){
                    $email_existe = false;
                } else{
                    $email_existe = true;
                }
            } 
        }

    } else{
        echo 'Erro ao tentar localizar o registro de e-mail';
    }

    if($email_existe){
        $retorno_get = '';
        if($email_existe){
            header('Location: eperfil.php?erro_email=1');
        }
    } else{
        if($usuario_senha == 'd41d8cd98f00b204e9800998ecf8427e'){
            $sql = "UPDATE tb_usuario SET usuario_nome = '$usuario_nome', usuario_email = '$usuario_email', 
            usuario_fone = '$usuario_fone' WHERE usuario_id = '$usuario';";
        }else{
            $sql = "UPDATE tb_usuario SET usuario_nome = '$usuario_nome', usuario_email = '$usuario_email', 
            usuario_fone = '$usuario_fone', usuario_senha = '$usuario_senha' WHERE usuario_id = '$usuario';"; 
        }
        // Executa a query
        if(mysqli_query($link, $sql)){
            $usuario_logado = $_SESSION['usuario'];
            $usuario_nome= $_SESSION['usuario_nome'];

            $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                VALUES('tb_usuario','$usuario_nome alterou os dados do perfil','$usuario_logado')";

            if(mysqli_query($link, $sql)){
                header('Location: perfil.php?editado=1');
            } else { 
                echo 'Erro ao inserir log';            
            }
        } 
        else { 
            echo "Erro na conexão com o banco!";
        }
    } 

?>