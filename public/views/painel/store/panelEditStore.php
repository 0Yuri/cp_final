<div class="w3-row">
  <div class="w3-row">
    <form ng-submit="vm.updateStore(vm.loja)">
      <div class="w3-row w3-padding-16">
        <div class="w3-quarter">
          <div class="w3-display-container">
            <label>
              <img class="w3-border" ng-show="!filepreview" src="{{imgFolder}}stores/logo/{{vm.loja.profile_image}}" width="250px" height="250px">
    					<img class="w3-border" ng-src="{{filepreview}}" ng-show="filepreview" width="250px" height="250px">
    					<input type="file" file-model="myFile" filepreview="filepreview" fileinput="myFile" style="display:none;">
    				</label>
            <div class="w3-display-middlebottom  w3-padding-16">
              <button type="button" class="btn btn-default w3-round" ng-click="vm.changePic(vm.loja)">Enviar nova logo</button>
            </div>
          </div>
        </div>
        <div class="w3-rest w3-display-container">
          <label style="width:100%">
            <img class="w3-round" ng-show="!banner_preview" src="{{imgFolder}}stores/banner/{{vm.loja.banner_image}}" height="250px" width="100%">
            <img class="w3-round" ng-src="{{banner_preview}}" ng-show="banner_preview" width="100%" height="250px">
            <input type="file" file-model="bannerFile" filepreview="banner_preview" fileinput="bannerFile" style="display:none;">
          </label>
          <div class="w3-display-middlebottom w3-padding-16">
            <button type="button" class="btn btn-default" ng-click="vm.changeBanner(vm.loja)">Enviar novo banner</button>
          </div>
        </div>
      </div>
      <div class="w3-row">
        <div class="w3-third w3-mobile" style="padding-right:2%">
          <label>Nome da loja:</label>
          <input type="text" required ng-model="vm.loja.name" class="w3-input w3-border w3-round" placeholder="Digite o nome da sua lojinha">
        </div>
        <div class="w3-rest w3-mobile">
          <div class="w3-third" style="padding-right:2%">
            <label>DDD:</label>
            <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.loja.ddd" mask="99" placeholder="99">
          </div>
          <div class="w3-rest">
            <label>Telefone:</label>
            <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.loja.phone" mask="999999999" placeholder="999999999">
          </div>
        </div>
        <div class="w3-row">
          <label>Descricão:</label>
          <textarea rows="8" cols="80" class="w3-input w3-border w3-round" required ng-model="vm.loja.description" placeholder="Digite a descrição da sua lojinha"></textarea>
        </div>
        <div class="w3-row w3-padding-16">
          <button type="submit" class="btn btn-default">Atualizar</button>
        </div>
      </div>
    </div>
  </form>
</div>
