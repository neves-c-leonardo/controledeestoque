<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $categoria_descricao = $_POST['categoria_descricao'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    if(strlen($categoria_descricao) > 0){
        $sql = "INSERT INTO tb_categoria(categoria_descricao)
        VALUES ('$categoria_descricao')";

        // Executa a query
        if(mysqli_query($link, $sql)){
            $usuario_logado = $_SESSION['usuario'];
            $descricao = 'Cadastrou a categoria ' . $categoria_descricao; 

            $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                VALUES('tb_categoria','$descricao','$usuario_logado')";
            if(mysqli_query($link, $sql)){
                header('Location: categoria.php?cadastrado=1');
            } else { 
                echo 'Erro ao inserir log';            
            }
        } 
        else { 
            echo "Erro na conexão com o banco!";
        }
    } else{
        echo "Erro no cadastro";
    }
    die();
?>