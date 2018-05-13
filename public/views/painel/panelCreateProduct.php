<div class="w3-container">
  <h3>Criando produto</h3>
  <form ng-submit="vm.criarProduto()">
    <div class="w3-row">
      <label>
        <img class="w3-round w3-border" ng-show="!filepreview" src="{{imgFolder}}/site/products/ex.png" width="250px" height="250px">
        <img class="w3-round w3-border" ng-src={{filepreview}} ng-show="filepreview" width="250px" height="250px">
        <input type="file" file-model="myFile" filepreview="filepreview" fileinput="myFile" style="display:none">
      </label>
    </div>
    <div class="w3-row">
      <div class="col-sm-3">
        <label>Nome do produto:</label>
        <input type="text" required ng-model="vm.field.name" class="w3-input w3-round w3-border" placeholder="Digite o nome do produto">
      </div>
      <div class="col-sm-2">
        <label>Público Alvo:</label>
        <select class="w3-select w3-border w3-round" required ng-model="vm.field.gender">
          <option value="" disabled selected>Selecione o público</option>
          <option value="meninos">Para Meninos</option>
          <option value="meninas">Para Meninas</option>
          <option value="papai">Para os papais</option>
          <option value="mamae">Para as mamães</option>
        </select>
      </div>
      <div class="col-sm-3">
        <label>Categoria:</label>
        <select class="w3-select w3-border w3-round" required ng-model="vm.field.category_id">
          <option value="" disabled selected>Selecione a categoria</option>
          <option value="{{categoria.id}}" ng-repeat="categoria in vm.categorias">{{categoria.name}}</option>
        </select>
      </div>
      <div class="col-sm-2">
        <label>Marca:</label>
        <select class="w3-select w3-border w3-round" required ng-model="vm.field.brand_id">
          <option value="" disabled selected>Selecione a marca</option>
          <option value="{{marca.id}}" ng-repeat="marca in vm.marcas">{{marca.name}}</option>
        </select>
      </div>
      <div class="col-sm-2">
        <label>Estoque:</label>
        <input type="number" required ng-model="vm.field.stock" class="w3-input w3-round w3-border">
      </div>
    </div>
    <div class="w3-row">
      <div class="col-sm-12">
        <label class="w3-left">Descreva o seu produto:</label>
        <textarea class="w3-input w3-round w3-border" rows="8" cols="80" required ng-model="vm.field.description" placeholder="Descrição do produto"></textarea>
      </div>
    </div>
    <div class="w3-row">
      <div class="col-sm-3">
        <label>Qualidade do produto:</label>
        <select class="w3-select w3-round w3-border" required ng-model="vm.field.quality">
          <option value="" disabled selected>Selecione a qualidade</option>
          <option value="Novo">Novo/Nunca usado</option>
          <option value="Bom estado">Bom estado</option>
          <option value="Com marcas de uso">Com marcas de uso</option>
        </select>
      </div>
      <div class="col-sm-3">
        <label>Tem Desconto?</label>
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
      <div class="col-sm-3">
        <label>Preço do produto:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.field.price" placeholder="Este valor será o anunciado no produto.">
      </div>
      <div class="col-sm-3">
        <label>Preço original:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.field.original_price" placeholder="O valor pago por você na compra do produto.">
      </div>
    </div>
    <div class="w3-row">
      <div class="col-sm-4">
        <label>Formas de entrega:</label><br>
        <input type="checkbox" class="w3-check" name="shipping" value="shipping" ng-model="vm.field.shipping"> Envio por correios
        <input type="checkbox" class="w3-check" name="local" value="local" ng-model="vm.field.local"> Retirar no local
      </div>
      <div class="col-sm-2">
        <label>Altura(cm):</label>
        <input type="number" class="w3-input w3-round w3-border" required ng-model="vm.field.height" placeholder="100">
      </div>
      <div class="col-sm-2">
        <label>Largura(cm):</label>
        <input type="number" class="w3-input w3-round w3-border" required ng-model="vm.field.width" placeholder="100">
      </div>
      <div class="col-sm-2">
        <label>Comprimento(cm):</label>
        <input type="number" class="w3-input w3-round w3-border" required ng-model="vm.field.length" placeholder="100">
      </div>
      <div class="col-sm-2">
        <label>Peso(g):</label>
        <input type="number" class="w3-input w3-round w3-border" required ng-model="vm.field.weight" placeholder="100">
      </div>
    </div>
    <div class="w3-row">
      <span class="tooltip noTooltipAttributes" style="opacity:100!important">
        Precisa de Ajuda?
        <span class="tooltiptext">
          Para evitar erros de logística, medidas em centímetros e peso em gramas, caso não possa expressar o valor específico, arredondar é uma opção.
        </span>
      </span>
    </div>
    <div class="w3-row w3-padding-16">
      <button type="submit" class="btn btn-default">Criar produto</button>
    </div>
    <div class="w3-row">
      {{vm.msg_error}}
    </div>
  </form>

</div>
