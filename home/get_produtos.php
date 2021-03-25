<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    // Quantidade de Produtos
    $sql = "SELECT COUNT(produto_id) AS cont_produto FROM tb_produtos";
    $resultado = mysqli_query($link,$sql);
    $count_produtos = mysqli_fetch_array($resultado);

    echo '<tr>';
        echo '<td>Produtos</td>';
        echo '<td>'.$count_produtos['cont_produto'].'</td>';
    echo'</tr>';