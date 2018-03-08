<div class="w3-container">
  <div class="w3-padding-16">
    <!-- Produto's info (Imagem, nome, descricao, estado, preco e botoes de compra e favoritar) -->
    <div class="w3-row">
      <!-- Foto do produto -->
      <div class="w3-half">
        <div class="w3-row">
          <img src="{{imgFolder}}site/products/{{vm.produto.profile_image}}" width="250px" height="250px">
        </div>
        <div class="w3-row">
          <img src="{{imgFolder}}site/products/{{imagem.filename}}" class="w3-image w3-round-large" width="200px" height="200px" ng-repeat="imagem in vm.produto.imagens" style="margin-right:2%">
        </div>
      </div>
      <!-- Informações do produto -->
      <div class="w3-half">
        <div class="w3-row">
          <h2>{{vm.produto.name}}</h2>
        </div>
        <div class="w3-row">
          R$ {{vm.produto.price | number: 2 }} à vista ou <br> em até 12x de R$ {{vm.produto.price / 12 | number: 2 }}
        </div>
        <div class="w3-row">
          <label>Estado:</label>
          {{vm.produto.quality}}
        </div>
        <!-- Quantidade -->
        <div class="w3-row">
          <div class="w3-third w3-hide-small"><p></p></div>
          <div class="w3-third" style="padding:0% 10%">
            Quantidade
            <input type="number" ng-model="vm.produto.quantity" required class="w3-input w3-border w3-round " min=1>
          </div>
        </div>
        <div class="w3-row w3-padding-16">
          <span>Gostou? Adicione nos seus favoritos</span><br>
          <button type="button" name="button"><i class="fa fa-heart" ng-click="vm.favoritar()"></i></button>
        </div>

        <div class="w3-row w3-padding-16">
          <button type="button" ng-click="vm.adicionarCarrinho(vm.produto)" class="btn btn-default">Adicionar ao carrinho</button>
        </div>
      </div>
    </div>

    <div class="w3-row" style="padding: 1% 5% 1% 5%">
      <div class="panel panel-default">
        <div class="panel-heading">
          Descrição
        </div>
        <div class="panel-content w3-padding-16">
          {{vm.produto.description}}
        </div>
      </div>
    </div>

    <div class="w3-row" style="padding: 1% 5% 1% 5%">
      <div class="w3-row text-left">
        <h5>Está com dúvidas? Pergunte ao vendedor!</h5>
        <div class="panel panel-default">
          <div class="panel-heading">
            Perguntas
          </div>
          <div class="panel-content w3-padding">
            <div class="w3-row w3-padding-16" ng-repeat="pergunta in vm.perguntas" ng-show="vm.perguntas.length > 0">
              <p>{{pergunta.question}} {{pergunta.created_at}}</p>
              <p style="padding-left:2%">{{pergunta.answer}}</p>
              <hr>
            </div>
            <div class="w3-row text-center" ng-show="vm.perguntas.length <= 0" style="padding: 3px 0">
              <p>Nenhuma pergunta foi realizada no produto, seja o primeiro!</p>
            </div>
          </div>
        </div>
        <div>
          <form ng-submit="vm.perguntar(vm.question)">
            <div class="w3-row">
              <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.question.content" placeholder="Digite sua pergunta">
            </div>
            <div class="w3-row w3-padding-16">
              <button type="submit" class="btn btn-default">Perguntar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <hr>
    <div class="w3-row">
      <h4>Temos algumas sugestões de produtos para você :)</h4>
      <div class="w3-row">
        <div id="productCarousel" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner text-left">
            <div class="item active">
              <div ng-repeat="j in [1,2,3,4]">
                <a href="#">
                  <div class="col-md-2 w3-card padding-20" ng-class="(j==1)?'col-md-offset-2':'hidden-sm hidden-xs'">
                    <img class="img-responsive no-margin" src="{{imgFolder}}site/products/ex.png">
                    Nome do Produto <br>
                    Marca: Lorem<br>
                    <span style="color:#87CEEB">R$ 00,00</span> <br>
                    <span style="color:#fec860">12x R$ 00,00</span> <br>
                  </div>
                </a>
              </div>
            </div>
            <div class="item">
              <div ng-repeat="j in [1,2,3,4]">
                <a href="#">
                  <div class="col-md-2 w3-card padding-20" ng-class="(j==1)?'col-md-offset-2':'hidden-sm hidden-xs'">
                    <img class="img-responsive no-margin" src="{{imgFolder}}site/products/ex.png">
                    Nome do Produto <br>
                    Marca: Lorem<br>
                    <span style="color:#87CEEB">R$ 00,00</span> <br>
                    <span style="color:#fec860">12x R$ 00,00</span> <br>
                  </div>
                </a>
              </div>
            </div>


            <!-- Left and right controls -->
            <a class="left carousel-control" href="#productCarousel" target="_blank" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#productCarousel" target="_blank" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </div>
</div>
