<div class="text-center no-padding" style="height:100%;width:100%;">

  <div class="w3-row root-background-image" style="background-repeat:">

    <div class="col-md-10 col-md-offset-1 no-padding">

      <!-- Header Section -->
      <div class="w3-row">
        <header class="fixed-header">
  				<div class="w3-container w3-white">
  					<div class="w3-row">
              <div class="w3-col m3 w3-hide-small">
                <a href="<?php echo $_SERVER['HTTP_HOST'] ?>" title="crescendo e passando">
                  <img src="{{imgFolder}}site/header/logo.png" height="125">
                </a>
              </div>
              <div class="w3-col m5 w3-hide-small">
                <img src="{{imgFolder}}site/header/frase.png" height="55" style="margin-top:30px">
              </div>
              <div class="w3-col m4">
                <!-- Search section -->
                <div class="w3-row" style="margin-top:15px">
                  <div class="input-group">
                    <input type="text" required ng-model="vm.pesquisa" class="form-control bg-color-2y placeholder-black flat-input" placeholder="O que você procura?">
                    <div class="input-group-btn">
                      <button class="btn bg-color-2y" type="button" ui-sref="root.search({pesquisa:vm.pesquisa})">
                        <i class="glyphicon glyphicon-search"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <!--  Header Buttons section -->
                <div class="w3-row w3-right">

                  <!-- Deslogado -->
                  <div class="w3-bar w3-padding-16" ng-show="!vm.session_status">
                    <div class="w3-bar-item">
                      <a ui-sref=".signup">
                        <span class="fa fa-user"></span> Cadastro
                      </a>
                    </div>
                    <div class="w3-bar-item">
                      <a data-toggle="modal" data-target="#loginModal">
                        <span class="fa fa-sign-in"></span> Entrar
                      </a>
                    </div>
                    <div class="w3-bar-item">
                      <a ui-sref="root.checkout.cart">
                        <span class="fa fa-shopping-bag"></span> Sacolinha
                        <span class="badge-sacola badge " ng-bind="vm.numero_carrinho"></span>
                      </a>
                    </div>
                  </div>

                  <!-- Logado -->
                  <div class="w3-bar w3-padding-16" ng-show="vm.session_status">
                    <div class="w3-bar-item">
                      <a ui-sref="root.panel.dashboard">
                        <span class="fa fa-user"></span> Meu painel
                      </a>
                    </div>
                    <div class="w3-bar-item">
                      <a ng-click="vm.logout();">
                        <span class="fa fa-sign-out"></span> Sair
                      </a>
                    </div>
                    <div class="w3-bar-item">
                      <a ui-sref="root.checkout.cart">
                        <span class="fa fa-shopping-bag"></span> Sacolinha
                        <span class="badge-sacola badge" ng-bind="vm.numero_carrinho"></span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Barra de navegação -->
          <nav class="no-margin"> <!-- navbar -->
            <div class="container-fluid"> <!-- navbar-content-container -->
              <div class="row _navbar"> <!-- navbar-options-row -->
                <div class="w3-bar">
                  <div></div>
                  <div class="w3-dropdown-hover">
                    <a class="w3-button" ui-sref="root.showProducts({category_id:0})">PRODUTOS</a>
                    <div class="w3-dropdown-content w3-bar-block w3-card-4">
                      <a ng-repeat="categoria in vm.produtos" ui-sref="root.showProducts({category_id: categoria.id, page_number:1})" class="w3-bar-item w3-button">{{categoria.name}}</a>
                    </div>
                  </div>
                  <a ui-sref="root.stores" class="w3-bar-item w3-button">LOJINHAS</a>
                  <a class="w3-bar-item w3-button">QUERO COMPRAR</a>
                  <a class="w3-bar-item w3-button">QUERO VENDER</a>
                  <a ui-sref="root.help" class="w3-bar-item w3-button">AJUDA</a>
                  <!--  -->
                </div>
              </div> <!-- END navbar-options-row -->
              <div class="row w3-white"> <!-- navbar-decoration-row -->
                <div class="navbar-decoration"></div>
              </div><!-- END navbar-decoration-row -->
            </div> <!-- END affix-content-container -->
          </nav> <!-- END navbar -->
        </header>
      </div>

      <!-- Content of pages -->
      <div class="w3-row w3-white">
        <div class="margin-top-content base no-padding" style="margin-top:230px;padding-bottom: 20px;height:100%;width:100%">
          <ui-view></ui-view>
        </div>
      </div>

      <!-- Footer Section -->
      <div class="w3-row">
        <footer class="base-padding bg-color-2y">
  				<div class="w3-row">
            <div class="rt-msg">
              <img style="width:100%;height:240px;margin:0;" src="{{imgFolder}}site/footer/msg.png">
            </div>
  				</div>
          <div class="w3-row">
            <div class="w3-twothird footer-links" style="padding-left:10%">
              <!--ABOUT US MODAL-->
  						<a href="#" data-toggle="modal" data-target="#AboutUsModal">Sobre nós</a><br>
  						<a href="#" data-toggle="modal" data-target="#HowToBuyModal">Como comprar</a><br>
  						<a href="#" data-toggle="modal" data-target="#HowToSellModal">Como vender</a><br>
  						<a ui-sref="root.faq">Dúvidas mais comuns</a><br>
  						<a ui-sref="root.contact">Entre em contato</a><br>
            </div>
  					<div class="w3-third">
  						<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fcrescendoepassando%2F&tabs&width=340&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
  					</div>
          </div>
          <div class="w3-row">
            ©2017 - Crescendo e Passando - Todos os direitos reservados - CNPJ 27.739.282/0001-08 <br>
  					<a href="#" data-toggle="modal" data-target="#TermsAndConditionsModal">Termos e Condições de Uso</a> | <a ui-sreef="root.home.policy" data-toggle="modal" data-target="#PrivacyPolicyModal">Política de Privacidade</a> | <a href="#" data-toggle="modal" data-target="#ContactUsModal">Entre em contato</a>
          </div>
  			</footer>
      </div>

    </div>
  </div>
</div>

<!-- LOGIN MODAL -->
<modal class="text-center" modal-id="loginModal" modal-type="sm" modal-title="Login">
	<form name="Form" ng-submit="vm.login(vm.input)">
		<label>Email</label>
		<input type="text" name="Email" class="form-control" ng-model="vm.input.email" placeholder="Seu email" required>
		<br>
		<div ng-if="vm.Form.$submitted && vm.Form.Email.$invalid">
				<span ng-if="vm.Form.Email.$error.required">Este campo é obrigatório</span>
				<span ng-if="vm.Form.Email.$error.email">Este não é um email valido</span>
			</div>
		<label>Senha</label>
		<input type="password" name="Password" class="form-control" ng-model="vm.input.password" placeholder="Sua senha" required>
		<br>
		<div ng-if="vm.Form.$submitted && vm.Form.Password.$invalid">
				<span ng-if="vm.Form.Password.$error.required">Este campo é obrigatório</span>
			</div>
		<button class="btn btn-default btn-block" type="submit">Acessar</button>
	</form>
</modal>

<!-- TERMS AND CONDITIONS MODAL -->
<modal class="text-center" modal-id="TermsAndConditionsModal" modal-type="md" modal-title="Termos e Condições de Uso">
	<?php
		readfile('modal-content/TermsAndConditionsContent.html');
	 ?>
</modal>

<!-- PRIVACY POLICY MODAL -->
<modal class="text-center" modal-id="PrivacyPolicyModal" modal-type="md" modal-title="Política de Privacidade">
	<?php
		readfile('modal-content/PrivacyPolicyModalContent.html');
	 ?>
</div>
</modal>
<!--ABOUT US MODAL-->
<modal class="text-center" modal-id="AboutUsModal" modal-type="md" modal-title="Sobre Nós">
	<?php
		readfile('modal-content/AboutUsModal.html');
	 ?>
</modal>
<!--HOW TO BUY MODAL-->
<modal class="text-center" modal-id="HowToBuyModal" modal-type="md" modal-title="Como Comprar">
	<?php
		readfile('modal-content/HowToBuyModal.html');
	 ?>
</modal>
<!--HOW TO SELL MODAL-->
<modal class="text-center" modal-id="HowToSellModal" modal-type="md" modal-title="Como Vender">
	<?php
		readfile('modal-content/HowToSellModal.html');
	 ?>
</modal>
<!--FREQUENT QUESTIONS MODAL-->
<modal class="text-center" modal-id="FrequentQuestionsModal" modal-type="md" modal-title="Dúvidas mais comuns">
	<?php
		readfile('modal-content/FrequentQuestionsModal.html');
	 ?>
</modal>
