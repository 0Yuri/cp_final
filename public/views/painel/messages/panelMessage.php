<div class="w3-container" style="margin-bottom:5%">
  <div class="w3-row" style="padding-left:10%;padding-right:10%" ng-show="vm.msg_error">
    <h4>Visualizando mensagem</h4>
    <div class="w3-row">
      <label>
        Autor:
      </label>
      <input type="text" class="w3-input w3-round w3-border" style="text-transform:capitalize" value="{{vm.mensagem.name}} {{vm.mensagem.last_name}}" disabled>
    </div>
    <div class="w3-row">
      <label>
        Assunto:
      </label>
      <input type="text" class="w3-input w3-round w3-border" style="text-transform:capitalize" value="{{vm.mensagem.subject}}" disabled>
    </div>
    <div class="w3-row">
      <label>
        Mensagem:
      </label>
      <textarea class="w3-input w3-round w3-border" rows="8" cols="80" ng-model="vm.mensagem.content" disabled></textarea>
    </div>

    <div class="w3-row w3-padding-16">
      <label>
        Resposta:
      </label>
      <textarea class="w3-input w3-round w3-border" rows="8" cols="80" ng-model="vm.mensagem.resposta" placeholder="Digite sua resposta aqui"></textarea>
    </div>
    <div class="w3-row">
      <button type="button" class="btn btn-default">Responder</button>
      <button type="button" class="btn btn-default">Apagar Mensagem</button>
    </div>
  </div>
  <div class="w3-row" ng-show="!vm.msg_error">
    <h5>{{vm.error}}</h5>
  </div>
</div>
