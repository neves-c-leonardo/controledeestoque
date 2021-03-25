<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: index.php?erro=1');
    }

    include('../funcoes/tempo_sessao.php');

    
    $editado = isset($_GET['editado']) ? $_GET['editado'] : 0;
    $cadastrado = isset($_GET['cadastrado']) ? $_GET['cadastrado'] : 0;
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Produtos - Cadastre seu Produtos Agora</title>

    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>#versao{margin: auto;} #versao p{font-size: 12px;}</style>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script type="text/javascript">

      var qtd_registro = 10; // quantidade de registro por página
      var pagina = 1;

      $(document).ready(function (){
        paginacao(pagina, qtd_registro);
      });

      function paginacao(pagina, qtd_registro){
        var dados = {
          pagina: pagina,
          qtd_registro: qtd_registro
        }
        $.post('get_produtos.php', dados, function(data){
              $('#lista_produtos').html(data);
          });
      }

      $(document).ready( function(){
        $.ajax({
          url: "get_prod_cat.php",
          success: function(data){
            $('#lista_prod_cat').html(data);
            $('#lista_prod_cat2').html(data);
          }
        });
      });

      $(document).ready( function(){
        $('#btn_add').click( function(){
          $('#lista_produtos').addClass("invisivel");
          $('#btn_add').addClass("invisivel");
          $('#create_produto').addClass("visivel");
        });
      });

      $(function() {
        $('.produto_preco').maskMoney({ decimal: '.', thousands: '', precision: 2 });
      })

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
          <span class="mdl-layout-title">Produtos</span>
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
          <a class="mdl-navigation__link menu_ativo" href="produtos.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">list</i>Produtos</a>
          <a class="mdl-navigation__link" href="../estoque/estoque.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">view_in_ar</i>Mov. de Estoque</a>
          <a class="mdl-navigation__link" href="../perfil/perfil.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Perfil</a>
          <a class="mdl-navigation__link" href="../empresas/empresa.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Empresa</a>
        </nav>

        <span id="versao"></span>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">
        <?php 
          if($editado == 1){
            echo '<p style="color:green; text-align:center;">Produto <b>alterado</b> com Sucesso!</p>';
          } elseif($cadastrado == 1){
            echo '<p style="color:green; text-align:center;">Produto <b>cadastrado</b> com Sucesso!</p>';
          } 
        ?>
        <div id="lista_produtos" class="list-group">

        </div>

        <div class="invisivel container_cproduto demo-card-square mdl-card mdl-shadow--2dp" id="create_produto">
            <form id="cadastrar_produto" method="POST" action="cadastro_produto.php">
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="select_tipo" for="lista_prod_cat">Categoria</label><br>
                <select class="select_tipo" name="lista_prod_cat" id="lista_prod_cat">
                    
                </select>     
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_descricao">Descrição</label>
                <input class="input_style"  type="text" id="produto_descricao" name="produto_descricao" required>                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_codigodebarras">Código de Barras</label>
                <input class="input_style" type="text" id="produto_codigodebarras" name="produto_codigodebarras" required>                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_preco">Preço</label>
                <input class="input_style produto_preco" type="text" name="produto_preco">
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_estoquemin">Estoque Minimo</label>
                <input class="input_style" type="numeric" id="produto_estoquemin" name="produto_estoquemin">                
              </div>
              <div class="mdl-card__actions">
                <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="btn_inclui">
                  Inserir
              </button>
              </div>
            </form>
          </div>
          <div class="invisivel container_aproduto demo-card-square mdl-card mdl-shadow--2dp" id="edit_produto">
            <form id="editar_produto" method="POST" action="editar_produto.php">
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="id">Produto</label>
                <input class="input_style id" type="text" id="id" name="id" readonly=“true”>                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="select_tipo" for="select_produtos">Categoria</label><br>
                <select class="select_tipo" name="select_produtos" id="lista_prod_cat2">
                </select>
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_descricao">Descrição</label>
                <input class="input_style produto_descricao" type="text" id="produto_descricao" name="produto_descricao" required>                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_codigodebarras">Código de Barras</label>
                <input class="input_style produto_codigodebarras" type="text" id="produto_codigodebarras" name="produto_codigodebarras" required>                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_preco">Preço</label>
                <input class="input_style produto_preco" type="text" name="produto_preco" id="produto_preco">                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="label_input" for="produto_estoquemin">Estoque Minimo</label>
                <input class="input_style produto_estoquemin" type="numeric" id="produto_estoquemin" name="produto_estoquemin">                
              </div>
              <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="select_tipo" for="ativo">Ativo</label><br>
                  <select class="select_tipo ativo" name="ativo" id="ativo">
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                  </select>               
              </div>
              <div class="mdl-card__actions">
              <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="btn_altera">
                  Alterar
              </button>
              </div>
            </form>
          </div>
          <button class="btn_add" id="btn_add"><i class="material-icons">add</i></button>
        </main>
    </div>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>
