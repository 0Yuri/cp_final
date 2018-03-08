<div class="w3-row" style="margin-bottom:5%">
  <h3>Perguntas</h3>

  <div class="w3-row topRepeater">
    <div class="w3-quarter">
      Enviada por
    </div>
    <div class="w3-quarter">
      Produto
    </div>
    <div class="w3-quarter">
      Data
    </div>
    <div class="w3-quarter">
      <p></p>
    </div>
  </div>
  <div ng-show="vm.status">
    <div class="w3-row repeater" ng-repeat="p in vm.perguntas">
      <div class="w3-quarter" style="text-transform:capitalize">
        {{p.nome}} {{p.sobrenome}}
      </div>
      <div class="w3-quarter">
        {{p.produto}}
      </div>
      <div class="w3-quarter">
        {{p.data}}
      </div>
      <div class="w3-quarter text-right" style="padding-right:20px">
        <i class="fa fa-reply" ui-sref="root.panel.answer({id: p.id})" aria-hidden="true"></i>
        <i class="fa fa-times" aria-hidden="true"></i>
      </div>
    </div>
    <div class="w3-row w3-padding-16">
      <button type="button" class="btn btn-default" ng-click="vm.setPage(-1)" ng-show="vm.pagina > 0">Anterior</button>
      <button type="button" class="btn btn-default" ng-click="vm.setPage(+1)" ng-show="vm.pagina < vm.paginas - 1">Próximo</button>
    </div>
  </div>
  <div class="w3-row w3-padding-16" ng-show="!vm.status">
    <h4>{{vm.error}}</h4>
  </div>
</div>
