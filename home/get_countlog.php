<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    // Quantidade de Usuários Cadastrados
    $sql = "SELECT log_usuario, COUNT(log_id) AS count_log FROM tb_log GROUP BY 1 ORDER BY count_log DESC";
    $resultado = mysqli_query($link,$sql);

    if($resultado){
        for ($i = 1; $i <= 5; $i++) {
            $count_log = mysqli_fetch_array($resultado);
            echo '<tr>';
                echo '<td>'.$count_log['log_usuario'].'</td>';

                echo '<td>'.$count_log['count_log'].'</td>';
            echo'</tr>'; 
        }
    } else{
        echo 'Consulta não realizada!';
    }
?>