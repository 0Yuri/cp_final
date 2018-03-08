<div class="w3-container w3-padding-16">
  <!-- Lado esquerdo - Informações do vendedor -->
  <div class="col-sm-3 w3-padding-16">
    <div class="row">
      <img class="w3-round" src="{{imgFolder}}/stores/logo/{{vm.loja.profile_image}}" height="200px" width="200px" alt="Foto de perfil do vendedor">
    </div>
    <div class="row w3-padding">
      <b>{{vm.loja.name}}</b>
      <ul class="w3-ul">
        <li>{{vm.produtos_vendidos}} PRODUTOS VENDIDOS</li>
      </ul>
    </div>
  </div>
  <!-- Lado direito - Informações do banner, promoção e lista de produtos da loja -->
  <div class="col-sm-9">
    <div class="row">
      <!-- Banner da loja -->
      <img class="w3-round" src="{{imgFolder}}stores/banner/{{vm.loja.banner_image}}" height="200px" width="100%" alt="Banner da loja">
    </div>
    <div class="row">
      <!--  Alerta cinza -->
      <div class="w3-panel w3-leftbar w3-light-grey">
        <p class="w3-xlarge w3-serif">
          <i>"{{vm.loja.description}}"</i>
        </p>
      </div>
    </div>
    <div class="row">
      <p>Nossos Produtos</p>
      <div ng-repeat="produto in vm.produtos">
        <div class="col-md-4 col-xs-6 min-margin w3-left-align">
          <a ui-sref="root.product(produto)">
            <div class="w3-card-4 product-box">
              <div class="product-img-box">
                <img class="img-responsive no-margin" src="{{imgFolder}}site/products/{{produto.imagem}}" width="auto">
              </div>
              <div class="w3-row-padding product-info-box">
                  <b>{{produto.name}}</b> <br>
                  Para {{produto.gender}}
              </div>
              <div class="w3-row-padding product-price-box">
                <span class="bold" style="color:#87CEEB">R$ {{produto.price}}</span> <br>
                <span class="bold" style="color:#fec860">12x R$ 00,00</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
