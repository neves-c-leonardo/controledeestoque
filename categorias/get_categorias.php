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

    $sql = "SELECT * FROM tb_categoria ORDER BY categoria_id DESC LIMIT $inicio , $qtd_registro";

    $resultado = mysqli_query($link,$sql);

    echo'<table class="mdl-data-table mdl-shadow--2dp">';
        echo'<thead>';
            echo'<tr>';
                echo '<th>Cód. Categoria</th>';
                echo '<th>Descrição</th>';
                echo '<th></th>';
                echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
    if($resultado){
        while($dados = mysqli_fetch_array($resultado)){
            //var_dump($dados);
            
                    echo '<tr>';
                        echo '<td>'.$dados['categoria_id'].'</td>';
                        echo '<td>'.$dados['categoria_descricao'].'</td>';
                        echo '<td><button class="btn_user" id="btn_user" 
                        data-categoria_id="'.$dados['categoria_id'].'"
                        data-categoria_descricao="'.$dados['categoria_descricao'].'"
                        ><i class="material-icons">create</i></button></td>';
                    echo'</tr>';
        }
        echo'</tbody>';
    echo'</table>';

    // Paginação
    $sql_pg = "SELECT COUNT(categoria_id) AS count_categoria FROM tb_categoria";
    $resultado_pg = mysqli_query($link,$sql_pg);
    $row_pg = mysqli_fetch_assoc($resultado_pg);
  
    // Quantidade de páginas
    $ultima_pg = ceil($row_pg['count_categoria'] / $qtd_registro);
    
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

<script type="text/javascript">
    $(document).ready( function(){
        $('.btn_user').click( function(){
            $('#lista_categoria').addClass("invisivel");
            $('#btn_add').addClass("invisivel");
            $('#edit_categoria').addClass("visivel");

            var categoria_id = $(this).data('categoria_id');
            var categoria_descricao = $(this).data('categoria_descricao');
            
            $.ajax({
                method: 'post',
                data: {
                    categoria_id: categoria_id,
                    ativo:categoria_descricao},
                success: function(data){
                    $('#id').val(categoria_id);
                    $('#categoria_adescricao').val(categoria_descricao);
                }
            });
        });
    });
</script>
