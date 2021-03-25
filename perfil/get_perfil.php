<?php
    session_start();
    
    require_once('../db/db_class.php'); 

    $usuario_id = $_SESSION['usuario_id'];
    $usuario_nome = $_SESSION['usuario_nome'];
    $usuario_email = $_SESSION['usuario_email'];
    $usuario_fone = $_SESSION['usuario_fone'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_usuario WHERE usuario_id = '$usuario_id' ";
    $resultado = mysqli_query($link,$sql);

    echo'<table class="mdl-data-table mdl-shadow--2dp">';
        echo'<thead>';
            echo'<tr>';
                echo '<th>Nome</th>';
                echo '<th>E-mail</th>';
                echo '<th>Telefone</th>';
                echo '<th></th>';
                echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
    if($resultado){
        while($dados = mysqli_fetch_array($resultado)){
            //var_dump($dados);
            
                    echo '<tr>';
                        echo '<td>'.$dados['usuario_nome'].'</td>';
                        echo '<td>'.$dados['usuario_email'].'</td>';
                        echo '<td>'.$dados['usuario_fone'].'</td>';
                        echo '<td><button class="btn_user" id="btn_user" data-usuario_nome="'.$dados['usuario_nome'].'" data-usuario_email="'.$dados['usuario_email'].'" data-usuario_fone="'.$dados['usuario_fone'].'" ><i class="material-icons">create</i></button></td>';
                    echo'</tr>';
        }
        echo'</tbody>';
    echo'</table>';
    } else{
        echo 'erro na consulta!';
    }
?>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> 
<script type="text/javascript">
    $(document).ready( function(){
        $('.btn_user').click( function(){
            $('#lista_perfil').addClass("invisivel");
            $('#edit_perfil').addClass("visivel");

            var usuario_nome = $(this).data('usuario_nome');
            var usuario_email = $(this).data('usuario_email');
            var usuario_fone = $(this).data('usuario_fone');
            
            $.ajax({
                method: 'post',
                data: {
                    usuario_nome: usuario_nome,
                    usuario_email: usuario_email,
                    usuario_fone: usuario_fone},
                success: function(data){
                    $('#usuario_nome').val(usuario_nome);
                    $('#usuario_email').val(usuario_email);
                    $('#usuario_fone').val(usuario_fone);
                }
            });
        });
    });
</script>
