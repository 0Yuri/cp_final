<div class="w3-container" style="padding-bottom:15%">
  <h3>Lojas</h3>  
  <div ng-show="vm.lojas.length > 0">    
    <div class="w3-card-4 w3-round w3-hover-shadow w3-left text-center" style="width:18%;margin-left:2%;margin-bottom:2%" ng-repeat="loja in vm.lojas" ui-sref="root.store(loja)">
      <div class="w3-row">
        <img src="{{imgFolder}}stores/logo/{{loja.profile_image}}" class="w3-round" width="200px" height="200px">
      </div>
      <div class="w3-row w3-padding">
        <p>{{loja.name}}</p>
      </div>
    </div>
  </div>
  <div ng-show="vm.lojas.length == 0">
    <h3>{{vm.msg}}</h3>
  </div>
</div>
