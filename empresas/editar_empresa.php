<?php
    session_start();

    require_once('../db/db_class.php'); 

    $empresa_id = $_POST['id'];
    $empresa_nome = $_POST['empresa_nome'];
    $empresa_razaosocial = $_POST['empresa_razaosocial'];
    $empresa_cnpj = $_POST['empresa_cnpj'];
    $empresa_ie = $_POST['empresa_ie'];
    $empresa_email = $_POST['empresa_email'];
    $empresa_telefone = $_POST['empresa_telefone'];
    $empresa_cep = $_POST['empresa_cep'];
    $empresa_rua = $_POST['empresa_rua'];
    $empresa_numero = $_POST['empresa_numero'];
    $empresa_complemento = $_POST['empresa_complemento'];
    $empresa_bairro = $_POST['empresa_bairro'];
    $empresa_cidade = $_POST['empresa_cidade'];
    $empresa_uf = $_POST['empresa_uf'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "UPDATE tb_empresa SET empresa_nome = '$empresa_nome', empresa_razaosocial = '$empresa_razaosocial', empresa_cnpj = '$empresa_cnpj', empresa_ie = '$empresa_ie', empresa_email = '$empresa_email', empresa_telefone = '$empresa_telefone', empresa_cep = '$empresa_cep', empresa_rua = '$empresa_rua', empresa_numero = '$empresa_numero ', empresa_complemento = '$empresa_complemento', empresa_bairro = '$empresa_bairro', empresa_cidade = '$empresa_cidade', empresa_uf = '$empresa_uf' WHERE empresa_id = '$empresa_id';";

    // Executa a query
    if(mysqli_query($link, $sql)){
        $usuario_logado = $_SESSION['usuario'];
        $descricao = 'Alterado os dados da empresa';

        $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_categoria','$descricao','$usuario_logado')";

        if(mysqli_query($link, $sql)){
            header('Location: empresa.php?editado=1');
        } else { 
            echo 'Erro ao inserir log';            
        }
    } 
    else { 
        echo "Erro na conexão com o banco!";
    }

?>