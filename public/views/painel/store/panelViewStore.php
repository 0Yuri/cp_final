<div class="w3-row">
  <div class="w3-third w3-left">
    <div class="w3-row">
      <img class="w3-round" src="{{imgFolder}}/stores/logo/{{vm.minhaloja.profile_image}}" style="width:250px;height:250px;">
    </div>
    <div class="w3-row w3-padding">
      <div class="w3-row w3-padding-16">
        Nome:<br>{{vm.minhaloja.name}}
      </div>
      <div class="w3-row w3-padding-16">
        Descrição:<br>{{vm.minhaloja.description}}
      </div>
    </div>
  </div>
  <div class="w3-twothird w3-left">
    <div class="w3-row w3-padding-16">
      <img class="w3-round" src="{{imgFolder}}/stores/banner/{{vm.minhaloja.banner_image}}" width="100%" height="250px">
    </div>
    <div class="w3-row">
      <button ng-if="vm.store_status" class="w3-button w3-round-large bg-color-2y" ui-sref="root.create_product">Adicionar produto</button>
      <button ng-show="vm.store_status" class="w3-button w3-round-large bg-color-2y" ui-sref="root.panel.store.update">Editar minha lojinha</button>
      <button ng-show="vm.store_active" class="w3-button w3-round-large bg-color-2y" ng-click="vm.mudarStatus()">Desativar lojinha</button>
      <button ng-show="!vm.store_active" class="w3-button w3-round-large bg-color-2y" ng-click="vm.mudarStatus()">Ativar lojinha</button>
    </div>

    <div class="w3-row w3-padding-16">
      <h3>Gerencie seus produtos</h3>
      <div ng-show="vm.produtos_lista">
        <ul class="list-group">
          <div class="w3-row">
            <li class="list-group-item" ng-repeat="produto in vm.produtos_lista">
              <div class="w3-row">
                <div class="col-sm-1">
                  <img id="preview-image" class="img-responsive img-rounded" src="{{imgFolder}}site/products/{{produto.imagem}}">
                </div>
                <div class="col-sm-3">
                  <a ui-sref="root.product(produto)">{{produto.name}}</a>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                  <button class="btn" ui-sref="root.panel.edit_product(produto)" style="background-color:transparent"><i class="fa fa-pencil"> Editar</i></button>
                  <button class="btn" style="background-color:transparent">
                    <i class="fa fa-times" ng-click="vm.toggleProduct(produto)">
                      <span ng-show="produto.status == 'desativado'">Ativar</span>
                      <span ng-show="produto.status == 'ativado'">Desativar</span>
                    </i>
                  </button>
                </div>
              </div>
            </li>
          </div>
        </ul>
        <div class="w3-padding-16">
          <button type="button" class="btn btn-default" ng-click="vm.setPage(-1)" ng-show="vm.pagina > 0">Anterior</button>
          <button type="button" class="btn btn-default" ng-click="vm.setPage(+1)" ng-show="vm.pagina < (vm.paginas - 1)">Próximo</button>
        </div>
      </div>
      <div ng-show="!vm.produtos_lista">
        {{vm.msg}}
      </div>
    </div>
  </div>
</div>
