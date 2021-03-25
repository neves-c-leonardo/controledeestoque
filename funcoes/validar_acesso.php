<?php

    session_start();

    require_once('../db/db_class.php');

    $user = $_POST['usuario']; 
    $senha = md5($_POST['senha']); 


    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_usuario WHERE usuario = '$user' AND usuario_senha = '$senha'";

    $resultado = mysqli_query($link, $sql);

    if($resultado){
        $dados_usuario = mysqli_fetch_array($resultado);

        $ativo = $dados_usuario['usuario_ativo'];
        $permissao = $dados_usuario['permissao_id'];

        if($ativo == 'N'){      
            $_SESSION['usuario'] = $dados_usuario['usuario'];
            $usuario_nome = $_SESSION['usuario_nome'];
            $usuario_logado = $_SESSION['usuario'];

            $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_usuario','$usuario_nome tentou entrar no sistema - Ativo = N','$usuario_logado')";
            
            if(mysqli_query($link, $sql)){
                header('Location: ../index.php?erro=2');
            } else { 
                echo 'Erro ao inserir log';            
            }
        } 
        elseif($permissao == 1){
            $_SESSION['usuario_id'] = $dados_usuario['usuario_id'];
            $_SESSION['usuario'] = $dados_usuario['usuario'];
            $_SESSION['usuario_nome'] = $dados_usuario['usuario_nome'];
            $_SESSION['usuario_senha'] = $dados_usuario['usuario_senha'];
            $_SESSION['usuario_email'] = $dados_usuario['usuario_email'];
            $_SESSION['usuario_fone'] = $dados_usuario['usuario_fone'];

            $usuario_nome = $_SESSION['usuario_nome'];
            $usuario_logado = $_SESSION['usuario'];

            $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_usuario','$usuario_nome Entrou no sistema ADM','$usuario_logado')";
            
            if(mysqli_query($link, $sql)){
                header('Location: ../home/home_adm.php');
            } else { 
                echo 'Erro ao inserir log';            
            }
        }
        elseif(isset($dados_usuario['usuario'])){

            $_SESSION['usuario_id'] = $dados_usuario['usuario_id'];
            $_SESSION['usuario'] = $dados_usuario['usuario'];
            $_SESSION['usuario_nome'] = $dados_usuario['usuario_nome'];
            $_SESSION['usuario_senha'] = $dados_usuario['usuario_senha'];
            $_SESSION['usuario_email'] = $dados_usuario['usuario_email'];
            $_SESSION['usuario_fone'] = $dados_usuario['usuario_fone'];

            $usuario_id = $_SESSION['usuario_id'];
            $usuario_logado = $_SESSION['usuario'];
            $usuario_nome = $_SESSION['usuario_nome'];

            $sql = "SELECT * 
                    FROM tb_usuario AS u 
                    INNER JOIN tb_permissao AS p 
                    WHERE u.permissao_id = p.permissao_id 
                    AND u.usuario_id = $usuario_id";

            $resultado = mysqli_query($link, $sql);

            if($resultado){
                $dados_usuario = mysqli_fetch_array($resultado);
                $_SESSION['permissao_descricao'] = $dados_usuario['permissao_descricao'];
                
            } else{
                echo 'Dados não carregados!';
            }          

            $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_usuario','$usuario_nome Entrou no sistema','$usuario_logado')";
            if(mysqli_query($link, $sql)){
                header('Location: ../home/home.php');
            } else { 
                echo 'Erro ao inserir log';            
            }
        } 
        else{
            header('Location: ../index.php?erro=1');
        }
    }else{
        echo "Erro na execução da consulta! Procure pelo admin do site";
    }
?>