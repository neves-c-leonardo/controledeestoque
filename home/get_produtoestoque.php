<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    // Quantidade de Usuários Cadastrados
    $sql = "SELECT produto_id, produto_descricao, produto_estoqueatual, produto_estoquemin FROM tb_produtos GROUP BY 1 ORDER BY produto_estoqueatual";
    $resultado = mysqli_query($link,$sql);
    

    if($resultado){ 
        for ($i = 0; $i <= 12; $i++) {
            $dados = mysqli_fetch_array($resultado);

            $estoquemin = $dados['produto_estoquemin'];
            $estoqueatual = $dados['produto_estoqueatual'];
            
            if($estoqueatual <= ($estoquemin + 5)){
                echo '<tr>';
                    echo '<td>'.$dados['produto_id'].'</td>';
                    echo '<td>'.$dados['produto_descricao'].'</td>';
                    echo '<td>'.$dados['produto_estoqueatual'].'</td>';
                    echo '<td>'.$dados['produto_estoquemin'].'</td>';
                echo'</tr>'; 
            }
        }
    } else{
        echo 'Consulta não realizada!';
    }
?>