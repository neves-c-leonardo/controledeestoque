<?php
    require_once('../db/db_class.php');

    $usuario_nome = $_SESSION['usuario_nome'];
    $usuario_logado = $_SESSION['usuario'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "SELECT DATE_FORMAT(log_dtregistro,'%H:%i') AS data_registro FROM tb_log WHERE log_usuario = '$usuario_logado' ORDER BY log_dtregistro DESC limit 1";
    $resultado = mysqli_query($link, $sql);
    $dados = mysqli_fetch_array($resultado);

    $data_registro = $dados['data_registro'];
    date_default_timezone_set('America/Sao_Paulo');
    $data_atual = date('H:i');

    //convertendo data atual em minutos
    $var_data_atual = explode(":",$data_atual);
	$var_data_atual[0];
	$var_data_atual[1];		
	$var_minutos_da = ($var_data_atual[0] *60);
	$var_minutos_da = $var_minutos_da + $var_data_atual[1]; 
    
    //convertendo data registro em minutos
    $var_data_registro = explode(":",$data_registro);
	$var_data_registro[0];
	$var_data_registro[1];		
	$var_minutos_dr = ($var_data_registro[0] *60);
	$var_minutos_dr = $var_minutos_dr + $var_data_registro[1]; 

    // Buscando parametro de tempo de sessão
    $sql = "SELECT tempo_sessao FROM tb_parametros";
    $resultado = mysqli_query($link, $sql);
    $dados = mysqli_fetch_array($resultado);
    $tempo_sessao = $dados['tempo_sessao'];
    $tempo_limite = $tempo_sessao / 60;

    // Calculo de tempo do ultimo movimento
    $diferenca_minutos = ($var_minutos_da - $var_minutos_dr);
    $calcular_sobra = $diferenca_minutos/60;

    if($calcular_sobra >= $tempo_limite){
        $sql = "INSERT INTO tb_log(log_tabela,log_descricao,log_usuario)
            VALUES('tb_usuario','$usuario_nome saiu por inatividade, $diferenca_minutos minutos parado','$usuario_logado')";
        $resultado = mysqli_query($link, $sql);
        if($resultado){
            unset($_SESSION['usuario_id']);
            unset($_SESSION['usuario']);
            unset($_SESSION['usuario_nome']);

            header('Location: ../index.php?tempo_esgotado=1');
        } 
    }  
    
?>