<div class="w3-container">
  <h3>Editando produto</h3>
  <div class="w3-row">
    <form ng-submit="vm.alterarProduto(vm.produto)">
      <!-- Basic Info        -->
      <div class="w3-row w3-padding-16">
        <!-- Profile Image -->
        <div class="w3-display-container w3-left">
          <div class="w3-display-topright">
            <button type="button" class="btn btn-default" ng-click="vm.uploadProfile(vm.produto)">Enviar</button>
          </div>
          <label>
            <img class="productImage" ng-show="!profilepreview" src="{{imgFolder}}/site/products/{{vm.produto.profile_image.filename}}" width="250px" height="250px">
            <img class="productImage" ng-src={{profilepreview}} ng-show="profilepreview" width="250px" height="250px">
            <input type="file" file-model="profilePic" filepreview="profilepreview" fileinput="profilePic" style="display:none">
          </label>
        </div>
        <!-- Extra images -->
        <div class="w3-display-container w3-left" ng-repeat="imagem in vm.produto.imagens">
          <div class="w3-display-topright">
            <button type="button" class="btn btn-default" title="Remover esta imagem" ng-click="vm.removerImagem(imagem)">X</button>
          </div>
          <img src="{{imgFolder}}site/products/{{imagem.filename}}" class="productImage">
        </div>
        <!-- Add images -->
        <div class="w3-display-container w3-left" ng-show="vm.produto.imagens.length <= 4">
          <div class="w3-display-topright">
            <button type="button" ng-click="vm.uploadSimple(vm.produto)">Enviar</button>
          </div>
          <label>
            <input type="file" file-model="extraPhoto" filepreview="extraPreview" fileinput="extraPhoto" style="display:none">
            <img ng-show="!extraPreview" src="{{imgFolder}}site/products/add_image.png" alt="adicionarNova" style="width:250px;height:250px">
            <img ng-show="extraPreview" ng-src="{{extraPreview}}" width="250px" height="250px">
          </label>
        </div>
      </div>
      <div class="w3-row">
        <h5>Informações Básicas</h5>
        <div class="w3-quarter">
          <label>Nome:</label>
          <input type="text" required ng-model="vm.produto.name" class="w3-input w3-border w3-round">
        </div>
        <div class="w3-quarter" style="padding-left: 2%">
          <label>Categoria:</label>
          <select class="w3-select w3-round w3-border" required ng-model="vm.produto.category_id">
            <option value="" selected disabled>Selecione uma categoria</option>
            <option ng-value="categoria.id" ng-repeat="categoria in vm.categorias">{{categoria.name}}</option>
          </select>
        </div>
        <div class="w3-quarter" style="padding-left: 2%">
          <label>Marca:</label>
          <select class="w3-select w3-round w3-border" required ng-model="vm.produto.brand_id">
            <option value="" selected disabled>Selecione uma marca</option>
            <option ng-value="marca.id" ng-repeat="marca in vm.marcas">{{marca.name}}</option>
          </select>
        </div>
        <div class="w3-quarter" style="padding-left: 2%">
          <label>Estoque:</label>
          <input type="number" required ng-model="vm.produto.stock" class="w3-input w3-border w3-round">
        </div>
      </div>
      <div class="w3-row">
        <label>Descrição:</label>
        <textarea required ng-model="vm.produto.description" rows="8" cols="80" class="w3-input w3-round w3-border"></textarea>
      </div>
      <div class="w3-row">
        <div class="w3-col l2">
          <label>Gênero:</label>
          <select class="w3-select w3-round w3-border" required ng-model="vm.produto.gender">
            <option value="" disabled selected>Selecione o gênero</option>
            <option value="meninos">Para Meninos</option>
            <option value="meninas">Para Meninas</option>
            <option value="papai">Para papais</option>
            <option value="mamae">Para mamães</option>
          </select>
        </div>
        <div class="w3-col l3" style="padding-left: 2%">
          <label>Qualidade:</label>
          <select class="w3-select w3-round w3-border" required ng-model="vm.produto.quality">
            <option value="" disabled selected>Selecione a qualidade</option>
            <option value="Novo">Nunca usado</option>
            <option value="Bom estado">Em bom estado</option>
            <option value="Com marcas de uso">Com marcas de uso</option>
          </select>
        </div>
        <div class="w3-col l2" style="padding-left:2%">
          <label>Tem desconto?</label>
          <select class="w3-select w3-round w3-border" required ng-model="vm.produto.discount">
            <option value="" selected disabled>Selecione um desconto</option>
            <option value="5">5% de desconto</option>
            <option value="10">10% de desconto</option>
            <option value="15">15% de desconto</option>
            <option value="20">20% de desconto</option>
            <option value="25">25% de desconto</option>
            <option value="30">30% de desconto</option>
            <option value="50">50% de desconto</option>
            <option value="60">60% de desconto</option>
            <option value="80">80% de desconto</option>
          </select>
        </div>
        <div class="w3-col l2" style="padding-left: 2%">
          <label>Preço de venda:</label>
          <input type="text" required ng-model="vm.produto.price" class="w3-input w3-round w3-border">
        </div>
        <div class="w3-col l2" style="padding-left: 2%">
          <label>Preço Original:</label>
          <input type="text" required ng-model="vm.produto.original_price" class="w3-input w3-round w3-border">
        </div>
      </div>
      <hr>
      <!-- Logistics Info(Medidas e forma de envio) -->
      <div class="w3-row">
        <h5>Medidas</h5>
        <div class="w3-quarter">
          <label>Altura(cm):</label>
          <input type="text" required ng-model="vm.produto.height" class="w3-input w3-border w3-round">
        </div>
        <div class="w3-quarter" style="padding-left: 2%">
          <label>Largura(cm):</label>
          <input type="text" required ng-model="vm.produto.width" class="w3-input w3-border w3-round">
        </div>
        <div class="w3-quarter" style="padding-left: 2%">
          <label>Comprimento(cm):</label>
          <input type="text" required ng-model="vm.produto.length" class="w3-input w3-border w3-round">
        </div>
        <div class="w3-quarter" style="padding-left: 2%">
          <label>Peso(g):</label>
          <input type="text" required ng-model="vm.produto.weight" class="w3-input w3-border w3-round">
        </div>
      </div>
      <hr>
      <!-- Formas de envio -->
      <div class="w3-row">
        <h5>Formas de envio:</h5>
        <div class="w3-half">
          <label>O comprador vai poder retirar no local? <br>Sim?</label><br>
          <input type="checkbox" class="w3-check" ng-true-value=1 ng-false-value=0 ng-model="vm.produto.local">
        </div>
        <div class="w3-half">
          <label>O comprador terá opção de pagar o envio e receber na sua casa? <br>Sim?</label><br>
          <input type="checkbox" class="w3-check" ng-true-value=1 ng-false-value=0 ng-model="vm.produto.shipping">
        </div>
      </div>
      <hr>
      <div class="w3-row w3-padding">
        <button type="submit" class="btn btn-primary">Alterar produto</button>
      </div>
    </form>
  </div>
</div>
