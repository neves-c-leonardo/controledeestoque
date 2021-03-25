<?php
    session_start();

    require_once('../db/db_class.php'); 

    $categoria = $_POST['id'];
    $categoria_adescricao = $_POST['categoria_adescricao'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $descricao_1 = $categoria_adescricao;

    $sql = "UPDATE tb_categoria SET categoria_descricao = '$categoria_adescricao' WHERE categoria_id = '$categoria';";

    // Executa a query
    if(mysqli_query($link, $sql)){
        $usuario_logado = $_SESSION['usuario'];
        $descricao = 'Mudado a descrição da categoria de ' . $descricao_1 . ' para ' . $categoria_adescricao;

        $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_categoria','$descricao','$usuario_logado')";

        if(mysqli_query($link, $sql)){
            header('Location: categoria.php?editado=1');
        } else { 
            echo 'Erro ao inserir log';            
        }
    } 
    else { 
        echo "Erro na conexão com o banco!";
    }

?>