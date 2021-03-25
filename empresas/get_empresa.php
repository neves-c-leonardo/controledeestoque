<?php
    require_once('../db/db_class.php'); 

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT * FROM tb_empresa";

    $resultado = mysqli_query($link,$sql);

    echo'<table class="mdl-data-table mdl-shadow--2dp">';
        echo'<thead>';
            echo'<tr>';
                echo '<th>Razão Social</th>';
                echo '<th>CNPJ</th>';
                echo '<th>IE</th>';
                echo '<th>E-mail</th>';
                echo '<th>Fone</th>';
                echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
    if($resultado){
        while($dados = mysqli_fetch_array($resultado)){
            //var_dump($dados);
            
                    echo '<tr>';
                        echo '<td>'.$dados['empresa_razaosocial'].'</td>';
                        echo '<td>'.$dados['empresa_cnpj'].'</td>';
                        echo '<td>'.$dados['empresa_ie'].'</td>';
                        echo '<td>'.$dados['empresa_email'].'</td>';
                        echo '<td>'.$dados['empresa_telefone'].'</td>';
                        echo '<td><button class="btn_user" id="btn_user" data-empresa_id="'.$dados['empresa_id'].'" data-empresa_nome="'.$dados['empresa_nome'].'" data-empresa_razaosocial="'.$dados['empresa_razaosocial'].'" data-empresa_cnpj="'.$dados['empresa_cnpj'].'" data-empresa_ie="'.$dados['empresa_ie'].'" data-empresa_email="'.$dados['empresa_email'].'" data-empresa_telefone="'.$dados['empresa_telefone'].'" data-empresa_cep="'.$dados['empresa_cep'].'" data-empresa_rua="'.$dados['empresa_rua'].'" data-empresa_numero="'.$dados['empresa_numero'].'" data-empresa_complemento="'.$dados['empresa_complemento'].'" data-empresa_bairro="'.$dados['empresa_bairro'].'" data-empresa_cidade="'.$dados['empresa_cidade'].'" data-empresa_uf="'.$dados['empresa_uf'].'" ><i class="material-icons">create</i></button></td>';
                    echo'</tr>';
        }
        echo'</tbody>';
    echo'</table>';
    } else{
        echo 'erro na consulta!';
    }
?>

<script type="text/javascript">
    $(document).ready( function(){
        $('.btn_user').click( function(){
            $('#lista_empresa').addClass("invisivel");
            $('#edit_empresa').addClass("visivel");

            var empresa_id = $(this).data('empresa_id');
            var empresa_nome = $(this).data('empresa_nome');
            var empresa_razaosocial = $(this).data('empresa_razaosocial');
            var empresa_cnpj = $(this).data('empresa_cnpj');
            var empresa_ie = $(this).data('empresa_ie');
            var empresa_email = $(this).data('empresa_email');
            var empresa_telefone = $(this).data('empresa_telefone');
            var empresa_cep = $(this).data('empresa_cep');
            var empresa_rua = $(this).data('empresa_rua');
            var empresa_numero = $(this).data('empresa_numero');
            var empresa_complemento = $(this).data('empresa_complemento');
            var empresa_bairro = $(this).data('empresa_bairro');
            var empresa_cidade = $(this).data('empresa_cidade');
            var empresa_uf = $(this).data('empresa_uf');

            $.ajax({
                method: 'post',
                data: {
                    empresa_id: empresa_id,
                    empresa_nome: empresa_nome,
                    empresa_razaosocial: empresa_razaosocial,
                    empresa_cnpj: empresa_cnpj,
                    empresa_ie: empresa_ie,
                    empresa_email: empresa_email,
                    empresa_telefone: empresa_telefone,
                    empresa_cep: empresa_cep,
                    empresa_rua: empresa_rua,
                    empresa_numero: empresa_numero,
                    empresa_complemento: empresa_complemento,
                    empresa_bairro: empresa_bairro,
                    empresa_cidade: empresa_cidade,
                    empresa_numero: empresa_numero},
                success: function(data){
                    $('#id').val(empresa_id);
                    $('#empresa_nome').val(empresa_nome);
                    $('#empresa_razaosocial').val(empresa_razaosocial);
                    $('#empresa_cnpj').val(empresa_cnpj);
                    $('#empresa_ie').val(empresa_ie);
                    $('#empresa_email').val(empresa_email);
                    $('#empresa_telefone').val(empresa_telefone);
                    $('#empresa_cep').val(empresa_cep);
                    $('#empresa_rua').val(empresa_rua);
                    $('#empresa_numero').val(empresa_numero);
                    $('#empresa_complemento').val(empresa_complemento);
                    $('#empresa_bairro').val(empresa_bairro);
                    $('#empresa_cidade').val(empresa_cidade);
                    $('#empresa_uf').val(empresa_uf);
                }
            });
        });
    });
</script>
