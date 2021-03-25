<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    // Quantidade de Usuários Cadastrados
    $sql = "SELECT COUNT(usuario_id) AS cont_usuario FROM tb_usuario";
    $resultado = mysqli_query($link,$sql);
    $count_usuarios = mysqli_fetch_array($resultado);

    // Quantidade de Logs
    $sql = "SELECT COUNT(log_id) AS cont_log FROM tb_log";
    $resultado = mysqli_query($link,$sql);
    $count_logs = mysqli_fetch_array($resultado);

    // Quantidade de Produtos
    $sql = "SELECT COUNT(produto_id) AS cont_produto FROM tb_produtos";
    $resultado = mysqli_query($link,$sql);
    $count_produtos = mysqli_fetch_array($resultado);

    // Quantidade de Categorias
    $sql = "SELECT COUNT(categoria_id) AS cont_categoria FROM tb_categoria";
    $resultado = mysqli_query($link,$sql);
    $count_categorias = mysqli_fetch_array($resultado);

    // Quantidade de Movimentação
    $sql = "SELECT COUNT(estoque_id) AS conte_estoque FROM tb_estoque";
    $resultado = mysqli_query($link,$sql);
    $count_movestoque = mysqli_fetch_array($resultado);

    echo '<tr>';
        echo '<td>Usuários</td>';
        echo '<td>'.$count_usuarios['cont_usuario'].'</td>';
    echo'</tr>';   
    echo '<tr>';
        echo '<td>Logs</td>';
        echo '<td>'.$count_logs['cont_log'].'</td>';
    echo'</tr>';
    echo '<tr>';
        echo '<td>Produtos</td>';
        echo '<td>'.$count_produtos['cont_produto'].'</td>';
    echo'</tr>';
    echo '<tr>';
        echo '<td>Categorias</td>';
        echo '<td>'.$count_categorias['cont_categoria'].'</td>';
    echo'</tr>';
    echo '<tr>';
        echo '<td>Movimentações</td>';
        echo '<td>'.$count_movestoque['conte_estoque'].'</td>';
    echo'</tr>';
?>