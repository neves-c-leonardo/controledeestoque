<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $produto = $_POST['lista_prod'];
    $quantidade = $_POST['quantidade'];
    $estoque_tipo = $_POST['estoque_tipo'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT produto_estoqueatual FROM tb_produtos WHERE produto_id = $produto";
    $resultado = mysqli_query($link, $sql);

    $dados_produtos = mysqli_fetch_array($resultado);

    $estoque_atual = $dados_produtos['produto_estoqueatual'];

    // Verificar se foi informado o campo "QUANTIDADE"
    if($quantidade >= 0){
        // ENTRADA NO ESTOQUE
        if($estoque_tipo == 'E'){
            $estoque_descricao = 'Entrada de Estoque Manual';
            $soma = $estoque_atual + $quantidade;

            $sql = "UPDATE tb_produtos SET produto_estoqueatual = $soma WHERE produto_id = $produto";

            // Executa a query
            if(mysqli_query($link, $sql)){

                $sql = "INSERT INTO tb_estoque(produto_id,estoque_tipo,estoque_descricao,estoque_quant)
                    VALUES('$produto','$estoque_tipo','$estoque_descricao','$quantidade')";

                if(mysqli_query($link, $sql)){
                    $usuario_logado = $_SESSION['usuario'];
                    $descricao = 'Entrou ' . $quantidade . ' produtos referente ao produto de cód.:' . $produto; 
        
                    $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                        VALUES('tb_produtos e tb_estoque','$descricao','$usuario_logado')";
        
                    if(mysqli_query($link, $sql)){
                        header('Location: estoque.php?movimentacao=1');
                    } else { 
                        echo 'Erro ao inserir log';            
                    }
                } else { 
                    header('Location: estoque.php?movimentacao_erro2=2');
                }
            } 
            else { 
                echo "Erro na conexão com o banco 2°!";
            }
        } elseif ($estoque_tipo == 'S'){

            $subtracao = $estoque_atual - $quantidade;

            if($subtracao < 0){
                header('Location: estoque.php?movimentacao_erro=1');
                
                $usuario_logado = $_SESSION['usuario'];
                $descricao = 'Usuário ' . $usuario_logado . ' tentou fazer uma saida';

                $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                        VALUES('tb_estoque','$descricao','$usuario_logado')";

                mysqli_query($link, $sql);

            } else{
                $estoque_descricao = 'Saida de Estoque Manual';

                $sql = "UPDATE tb_produtos SET produto_estoqueatual = $subtracao WHERE produto_id = $produto";
                
                // Executa a query
                if(mysqli_query($link, $sql)){

                    $sql = "INSERT INTO tb_estoque(produto_id,estoque_tipo,estoque_descricao,estoque_quant)
                        VALUES('$produto','$estoque_tipo','$estoque_descricao','$quantidade')";

                    if(mysqli_query($link, $sql)){
                        $usuario_logado = $_SESSION['usuario'];
                        $descricao = 'Saiu ' . $quantidade . ' produtos referente ao produto de cód.:' . $produto; 
            
                        $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
                            VALUES('tb_produtos e tb_estoque','$descricao','$usuario_logado')";
            
                        if(mysqli_query($link, $sql)){
                            header('Location: estoque.php?movimentacao=1');
                        } else { 
                            echo 'Erro ao inserir log';            
                        }
                    } else { 
                    echo "Erro na conexão com o banco 3°!";
                    }
                } 
                else { 
                    echo "Erro na conexão com o banco 4°!";
                }
            }
        } else{
            echo "Tipo de movimentação não existe";
        }
    } else{
        header('Location: estoque.php?movimentacao_erro3=1');
    }
?>