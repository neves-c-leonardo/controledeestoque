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
    $usuario_id = $_SESSION['usuario_id'];
    

        $sql = "SELECT * 
        FROM tb_usuario AS u 
        INNER JOIN tb_permissao AS p 
        WHERE u.permissao_id = p.permissao_id ORDER BY usuario_id DESC LIMIT $inicio , $qtd_registro";
    
   
    $resultado = mysqli_query($link,$sql);

    echo '<table class="mdl-data-table mdl-shadow--2dp">';
            echo '<thead>';
              echo '<tr>';
                echo '<th>Código Cliente</th>';
                echo '<th>Nome</th>';
                echo '<th>Usuário</th>';
                echo '<th>E-mail</th>';
                echo '<th>Telefone</th>';
                echo '<th>ativo</th>';
                echo '<th>Permissão</th>';
                echo '<th>Data Registro</th>';
                echo '<th></th>';
              echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
              
    if($resultado){
        while($dados = mysqli_fetch_array($resultado)){
            //var_dump($dados);
            echo '<tr>';
                echo '<td id="teste">'.$dados['usuario_id'].'</td>';
                echo '<td>'.$dados['usuario_nome'].'</td>';
                echo '<td>'.$dados['usuario'].'</td>';
                echo '<td>'.$dados['usuario_email'].'</td>';
                echo '<td>'.$dados['usuario_fone'].'</td>';
                echo '<td>'.$dados['usuario_ativo'].'</td>';
                echo '<td>'.$dados['permissao_descricao'].'</td>';
                echo '<td>'.$dados['usuario_dtregistro'].'</td>';
                echo '<td><button type="button" class="btn_user" id="btn_user" 
                data-permissao_id="'.$dados['permissao_id'].'" 
                data-usuario_ativo="'.$dados['usuario_ativo'].'"
                data-usuario_id="'.$dados['usuario_id'].'"
                data-usuario_nome="'.$dados['usuario_nome'].'"
                ><i class="material-icons">create</i></button></td>';
            echo'</tr>';
        }
    } else{
        echo 'Consulta não realizada!';
    }

        echo '</tbody>';
    echo '</table>';
    // Paginação
    $sql_pg = "SELECT COUNT(usuario_id) AS count_usuario FROM tb_usuario";
    $resultado_pg = mysqli_query($link,$sql_pg);
    $row_pg = mysqli_fetch_assoc($resultado_pg);
  
    // Quantidade de páginas
    $ultima_pg = ceil($row_pg['count_usuario'] / $qtd_registro);   
    
    if($ultima_pg != 1){
        echo "<div class='paginacao'>";
        for($i=1;$i<=$ultima_pg;$i++){
            echo "<a href='#' class='paginacao' onclick='paginacao($i, $qtd_registro)'> $i </a>";
        }
        echo "</div>";
    }
    
?>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    
<script type="text/javascript">
    $(document).ready( function(){
        $('.btn_user').click( function(){
            $('#list_usuarios').addClass("invisivel");
            $('#btn_add').addClass("invisivel");
            $('#edit_user').addClass("visivel");

            var permissao_id = $(this).data('permissao_id');
            var usuario_ativo = $(this).data('usuario_ativo');
            var usuario_nome = $(this).data('usuario_nome');
            var usuario_id = $(this).data('usuario_id');
            
            $.ajax({
                method: 'post',
                data: {
                    permissao: permissao_id,
                    ativo:usuario_ativo,
                    usuario_nome:usuario_nome,
                    usuario:usuario_id},
                success: function(data){
                    $('#permissao').val(permissao_id);
                    $('#ativo').val(usuario_ativo);
                    $('#id').val(usuario_id + ' - ' + usuario_nome);
                }
            });
        });
    });
</script>
