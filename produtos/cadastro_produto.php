<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $categoria_id = $_POST['lista_prod_cat'];
    $produto_descricao = $_POST['produto_descricao'];
    $produto_codigodebarras = $_POST['produto_codigodebarras'];
    $produto_preco = $_POST['produto_preco'];
    $produto_estoquemin = $_POST['produto_estoquemin'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT produto_codigodebarras FROM tb_produtos WHERE produto_codigodebarras = '$produto_codigodebarras'";
    
    if($resultado = mysqli_query($link, $sql)){
        $dados = mysqli_fetch_array($resultado);
        if(strlen($dados['produto_codigodebarras']) > 0){
            echo 'Código de barras já existe!';
        } else{
            $sql = "INSERT INTO tb_produtos(categoria_id,produto_descricao,produto_codigodebarras,produto_preco,produto_estoqueatual,produto_estoquemin,produto_imagem_url,produto_ativo)
            VALUES ($categoria_id,'$produto_descricao','$produto_codigodebarras',$produto_preco,0,'$produto_estoquemin','X','S')";
        
            if(mysqli_query($link, $sql)){
                $usuario_logado = $_SESSION['usuario'];
                $descricao = 'Cadastrou o produto ' . $produto_descricao; 

                $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                        VALUES('tb_produtos','$descricao','$usuario_logado')";

                if(mysqli_query($link, $sql)){
                    header('Location: produtos.php');
                } else { 
                    echo 'Erro ao inserir log';            
                }
            } 
            else { 
                echo "Erro na conexão com o banco!";
            }
        }
    }  else{
        echo 'Consulta não realizada!';
    }  

    die();
?>