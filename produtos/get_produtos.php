<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $pagina = filter_input(INPUT_POST,'pagina', FILTER_SANITIZE_NUMBER_INT);
    $qtd_registro = filter_input(INPUT_POST,'qtd_registro', FILTER_SANITIZE_NUMBER_INT);
    // Calcular o inicio visualização
    $inicio = ($pagina * $qtd_registro) - $qtd_registro;

    $usuario_id = $_SESSION['usuario_id'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_produtos AS p INNER JOIN tb_categoria AS c WHERE p.categoria_id = c.categoria_id    
    ORDER BY p.produto_id DESC LIMIT $inicio , $qtd_registro";

    $resultado = mysqli_query($link,$sql);

    echo'<table class="mdl-data-table mdl-shadow--2dp">';
        echo'<thead>';
            echo'<tr>';
                echo '<th>Cód. Produto</th>';
                echo '<th>Descrição</th>';
                echo '<th>Categoria</th>';
                echo '<th>Código de Barras</th>';
                echo '<th>Preço</th>';
                echo '<th>Estoque</th>';
                echo '<th>Ativo</th>';
                echo '<th></th>';
                echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
    if($resultado){
        while($dados = mysqli_fetch_array($resultado)){
            //var_dump($dados);
            
                    echo '<tr>';
                        echo '<td>'.$dados['produto_id'].'</td>';
                        echo '<td>'.$dados['produto_descricao'].'</td>';
                        echo '<td>'.$dados['categoria_descricao'].'</td>';
                        echo '<td>'.$dados['produto_codigodebarras'].'</td>';
                        echo '<td>'.$dados['produto_preco'].'</td>';
                        echo '<td>'.$dados['produto_estoqueatual'].'</td>';
                        echo '<td>'.$dados['produto_ativo'].'</td>';
                        echo '<td><button class="btn_user" id="btn_user"
                        data-produto_id="'.$dados['produto_id'].'" data-produto_descricao="'.$dados['produto_descricao'].'" data-categoria_id="'.$dados['categoria_id'].'" data-produto_codigodebarras="'.$dados['produto_codigodebarras'].'" data-produto_preco="'.$dados['produto_preco'].'" data-produto_estoquemin="'.$dados['produto_estoquemin'].'" data-produto_ativo="'.$dados['produto_ativo'].'"><i class="material-icons">create</i></button></td>';
                    echo'</tr>';
        }
        echo'</tbody>';
    echo'</table>';

    // Paginação
    $sql_pg = "SELECT COUNT(produto_id) AS count_produto FROM tb_produtos";
    $resultado_pg = mysqli_query($link,$sql_pg);
    $row_pg = mysqli_fetch_assoc($resultado_pg);
  
    // Quantidade de páginas
    $ultima_pg = ceil($row_pg['count_produto'] / $qtd_registro);
    
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
            $('#lista_produtos').addClass("invisivel");
            $('#btn_add').addClass("invisivel");
            $('#edit_produto').addClass("visivel");

            var produto_id = $(this).data('produto_id');
            var produto_descricao = $(this).data('produto_descricao');
            var categoria_id = $(this).data('categoria_id');
            var produto_codigodebarras = $(this).data('produto_codigodebarras');
            var produto_preco = $(this).data('produto_preco');
            var produto_estoquemin = $(this).data('produto_estoquemin');
            var produto_ativo = $(this).data('produto_ativo');

            $.ajax({
                method: 'post',
                data: {
                    produto_id: produto_id,
                    produto_descricao: produto_descricao,
                    categoria_id: categoria_id,
                    produto_codigodebarras: produto_codigodebarras,
                    produto_preco: produto_preco,
                    produto_estoquemin: produto_estoquemin,
                    produto_ativo: produto_ativo},
                success: function(data){
                    $('.id').val(produto_id);
                    $('.produto_descricao').val(produto_descricao);
                    $('#lista_prod_cat2').val(categoria_id);
                    $('.produto_codigodebarras').val(produto_codigodebarras);
                    $('.produto_preco').val(produto_preco);
                    $('.produto_estoquemin').val(produto_estoquemin);
                    $('.ativo').val(produto_ativo);
                }
            });
        });
    });
</script>
