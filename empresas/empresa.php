<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: ../index.php?erro=1');
    }

    include('../funcoes/tempo_sessao.php');
    
    $editado = isset($_GET['editado']) ? $_GET['editado'] : 0;

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Empresa - Dados da Empresa</title>

    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>#versao{margin: auto;} #versao p{font-size: 12px;}</style>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <script type="text/javascript">
        $(document).ready( function(){
        $.ajax({
          url: "get_empresa.php",
          success: function(data){
            $('#lista_empresa').html(data);
          }
        });
      });

      function listaversao(){
          $.ajax({
                url: "../funcoes/get_versao.php",
                success: function(data){
                $('#versao').html(data);
                }
            });
        }
        listaversao();
    </script>

  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

      <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Empresa</span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <a href="../funcoes/sair.php"><li class="mdl-menu__item">Sair</li></a>
          </ul>
        </div>
      </header>

      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
          <div>
            <?= "<p>Usuário " . $_SESSION['usuario_id'] . ' <br> ' . $_SESSION['usuario_nome'] . '<br>' . $_SESSION['permissao_descricao'] . "(a)</p>" ?>
          </div>
        </header>

        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="../home/home.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">leaderboard</i>Dashboard</a>
          <a class="mdl-navigation__link" href="../categorias/categoria.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">category</i>Categoria</a>
          <a class="mdl-navigation__link" href="../produtos/produtos.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">list</i>Produtos</a>
          <a class="mdl-navigation__link" href="../estoque/estoque.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">view_in_ar</i>Mov. de Estoque</a>
          <a class="mdl-navigation__link" href="../perfil/perfil.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Perfil</a>
          <a class="mdl-navigation__link menu_ativo" href="empresa.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Empresa</a>
        </nav>

        <span id="versao"></span>
      </div>

      <main class="mdl-layout__content mdl-color--grey-100">
        <?php 
          if($editado == 1){
            echo '<p style="color:green; text-align:center;">Empresa <b>alterada</b> com Sucesso!</p>';
          } 
        ?>
        <div id="lista_empresa" class="list-group">

        </div>
        
        <div class="invisivel container_empresa demo-card-square mdl-card mdl-shadow--2dp" id="edit_empresa">
          
          <form id="editar_empresa" method="POST" action="edicao/editar_empresa.php">
            <div class="invisivel campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="id">id</label>
              <input class="input_style"  type="text" id="id" name="id">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_nome">Nome</label>
              <input class="input_style"  type="text" id="empresa_nome" name="empresa_nome">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_razaosocial">Razão Social</label>
              <input class="input_style"  type="text" id="empresa_razaosocial" name="empresa_razaosocial">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_cnpj">CNPJ</label>
              <input class="input_style"  type="text" id="empresa_cnpj" name="empresa_cnpj">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_ie">Inscrição Estadual</label>
              <input class="input_style"  type="text" id="empresa_ie" name="empresa_ie">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_email">E-mail</label>
              <input class="input_style"  type="email" id="empresa_email" name="empresa_email">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_telefone">Fone</label>
              <input class="input_style"  type="fone" id="empresa_telefone" name="empresa_telefone">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_cep">CEP</label>
              <input class="input_style"  type="text" id="empresa_cep" name="empresa_cep">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_rua">Rua</label>
              <input class="input_style"  type="text" id="empresa_rua" name="empresa_rua">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_numero">Número</label>
              <input class="input_style"  type="text" id="empresa_numero" name="empresa_numero">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_complemento">Complemento</label>
              <input class="input_style"  type="text" id="empresa_complemento" name="empresa_complemento">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_bairro">Bairro</label>
              <input class="input_style"  type="text" id="empresa_bairro" name="empresa_bairro">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="empresa_cidade">Cidade</label>
              <input class="input_style empresa_cidade" type="text" id="empresa_cidade" name="empresa_cidade">
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input select_uf" for="empresa_uf">UF</label><br>
                  <select class="select_uf" name="empresa_uf" id="empresa_uf">
                    
                </select>
              </label>
            </div>
            <div class="mdl-card__actions">
              <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Editar
             </button>
            </div>
          </form>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>
