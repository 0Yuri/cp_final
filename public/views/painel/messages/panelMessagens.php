<div class="w3-container" style="margin-bottom:5%">

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#recebidas">Recebidas</a></li>
    <li><a data-toggle="tab" href="#enviadas">Enviadas</a></li>
  </ul>

  <div class="tab-content">

    <!-- Recebidas -->
    <div id="recebidas" class="tab-pane fade in active">
      <div class="w3-row headerRepeater w3-padding-16">
        <div class="w3-third">
          Enviado por
        </div>
        <div class="w3-third">
          Assunto
        </div>
        <div class="w3-third">
          Data de envio
        </div>
      </div>
      <div ng-show="vm.recebidas_error">
        <div class="w3-row headerRepeater w3-padding-16" ng-repeat="mensagem in vm.recebidas" style="text-transform:capitalize">
          <div class="w3-third">
            {{mensagem.name}} {{mensagem.last_name}}
          </div>
          <div class="w3-third">
            <a ui-sref="root.panel.view_message({id: mensagem.id})">
              {{mensagem.subject}}
            </a>
          </div>
          <div class="w3-third">
            {{mensagem.sent_at}}
          </div>
        </div>
      </div>
      <div class="w3-row" ng-show="!vm.recebidas_error">
        <h4>{{vm.error_1}}</h4>
      </div>
      <!-- Botões -->
      <div class="w3-row w3-padding-16">
        <button type="button" class="w3-button w3-round-large" ng-show="vm.pagina_recebida > 0" ng-click="vm.setPage('recebida', -1)">Anterior</button>
        <button type="button" class="w3-button w3-round-large" ng-show="vm.pagina_recebida < vm.paginas_recebidas" ng-click="vm.setPage('recebida', +1)">Próximo</button>
      </div>
    </div>

    <!-- Enviadas -->
    <div id="enviadas" class="tab-pane fade">
      <div class="w3-row headerRepeater w3-padding-16">
        <div class="w3-third">
          Enviado para
        </div>
        <div class="w3-third">
          Assunto
        </div>
        <div class="w3-third">
          Data de envio
        </div>
      </div>
      <div class="w3-row headerRepeater w3-padding-16" ng-repeat="mensagem in vm.enviadas" style="text-transform:capitalize" ng-show="vm.enviadas_error">
        <div class="w3-third">
          {{mensagem.name}} {{mensagem.last_name}}
        </div>
        <div class="w3-third">
          <a ui-sref="root.panel.view_message({id: mensagem.id})">
            {{mensagem.subject}}
          </a>
        </div>
        <div class="w3-third">
          {{mensagem.sent_at}}
        </div>
      </div>
      <div class="w3-row" ng-show="!vm.enviadas_error">
        <h4>{{vm.error_2}}</h4>
      </div>

      <!-- Botões -->
      <div class="w3-row w3-padding-16">
        <button type="button" class="w3-button w3-round-large" ng-show="vm.pagina_enviada > 0" ng-click="vm.setPage('enviada', -1)">Anterior</button>
        <button type="button" class="w3-button w3-round-large" ng-show="vm.pagina_enviada < vm.paginas_enviadas" ng-click="vm.setPage('enviada', +1)">Próximo</button>
      </div>
    </div>
  </div>



</div>
