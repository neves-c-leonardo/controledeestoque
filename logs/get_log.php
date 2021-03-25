<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $pagina = filter_input(INPUT_POST,'pagina', FILTER_SANITIZE_NUMBER_INT);
    $qtd_registro = filter_input(INPUT_POST,'qtd_registro', FILTER_SANITIZE_NUMBER_INT);
    // Calcular o inicio visualização
    $inicio = ($pagina * $qtd_registro) - $qtd_registro;
   

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    // resto da conexão com o banco

    $sql = "SELECT * FROM tb_log ORDER BY log_id DESC LIMIT $inicio , $qtd_registro";
    $resultado = mysqli_query($link,$sql);

    echo'<table class="mdl-data-table mdl-shadow--2dp">';
        echo'<thead>';
            echo'<tr>';
                echo'<th>ID</th>';
                echo'<th>Descrição</th>';
                echo'<th>Tabela</th>';
                echo'<th>Usuário</th>';
                echo'<th>Data Registro</th>';
                echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
    if($resultado){
        while($dados = mysqli_fetch_array($resultado)){
            //var_dump($dados);
            
                    echo '<tr>';
                        echo '<td>'.$dados['log_id'].'</td>';
                        echo '<td>'.$dados['log_descricao'].'</td>';
                        echo '<td>'.$dados['log_tabela'].'</td>';
                        echo '<td>'.$dados['log_usuario'].'</td>';
                        echo '<td>'.$dados['log_dtregistro'].'</td>';
                    echo'</tr>';
                
        }
        echo'</tbody>';
    echo'</table>';

    // Paginação
    $sql_pg = "SELECT COUNT(log_id) AS count_log FROM tb_log";
    $resultado_pg = mysqli_query($link,$sql_pg);
    $row_pg = mysqli_fetch_assoc($resultado_pg);
  
    // Quantidade de páginas
    $ultima_pg = ceil($row_pg['count_log'] / $qtd_registro);
    
    if($ultima_pg != 1){
        echo "<div class='paginacao'>";
        for($i=1;$i<=$ultima_pg;$i++){
            echo "<a href='#' class='paginacao' onclick='paginacao($i, $qtd_registro)'> $i </a>";
        }
        echo "</div>";
    }

    } else{
        echo 'Consulta não realizada!';
    }

    

?>