<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $produto = $_POST['id'];
    $categoria_id = $_POST['select_produtos'];
    $produto_descricao = $_POST['produto_descricao'];
    $produto_codigodebarras = $_POST['produto_codigodebarras'];
    $produto_preco = $_POST['produto_preco'];
    $produto_estoquemin = $_POST['produto_estoquemin'];
    $produto_ativo = $_POST['ativo'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT produto_codigodebarras FROM tb_produtos WHERE produto_codigodebarras = '$produto_codigodebarras'";
    
    if($resultado = mysqli_query($link, $sql)){
        $dados = mysqli_fetch_array($resultado);
            $categoria = $categoria_id;
    
            if($categoria == '0'){
                $sql = "UPDATE tb_produtos SET produto_descricao = '$produto_descricao', produto_codigodebarras = '$produto_codigodebarras', produto_preco = '$produto_preco', produto_estoquemin = '$produto_estoquemin', produto_ativo = '$produto_ativo' WHERE produto_id = '$produto';";
            } else{
                $sql = "UPDATE tb_produtos SET categoria_id = '$categoria_id', produto_descricao = '$produto_descricao', produto_codigodebarras = '$produto_codigodebarras', produto_preco = '$produto_preco', produto_estoquemin = '$produto_estoquemin', produto_ativo = '$produto_ativo' WHERE produto_id = '$produto';";  
            }
            
            // Executa a query
            if(mysqli_query($link, $sql)){
                $usuario_logado = $_SESSION['usuario'];
                $descricao = 'Alteração no produto: ' . $produto_descricao; 

                $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                    VALUES('tb_produtos','$descricao','$usuario_logado')";

                if(mysqli_query($link, $sql)){
                    header('Location: produtos.php?editado=1');
                } else { 
                    echo 'Erro ao inserir log';            
                }
            } 
            else { 
                echo "Erro na conexão com o banco!";
            }
    }  else{
        echo 'Consulta não realizada!';
    }  

    
?>