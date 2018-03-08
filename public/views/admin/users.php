<div class="w3-row">
  <div class="w3-row">
    <label>Lista de usuários</label>
    <div class="w3-row w3-padding-16">
      <form ng-submit="vm.pesquisarUsuario(vm.info)">
        <input type="text" class="w3-round w3-border" required ng-model="vm.info.name">
        <button type="submit" class="w3-button w3-border w3-round">Pesquisar</button>
      </form>
    </div>
    <div class="w3-row w3-light-gray w3-padding-16">
      <div class="w3-quarter">
        Nome:
      </div>
      <div class="w3-quarter">
        CPF:
      </div>
      <div class="w3-quarter">
        Data de cadastro:
      </div>
      <div class="w3-quarter">
        Ações
      </div>
    </div>
    <div>
      <div class="w3-row w3-padding-16" ng-repeat="user in vm.usuarios">
        <div class="w3-quarter">
          {{user.name}} {{user.last_name}}
        </div>
        <div class="w3-quarter">
          {{user.cpf}}
        </div>
        <div class="w3-quarter">
          {{user.created_at}}
        </div>
        <div class="w3-quarter">
          <button type="button" class="btn btn-default" ng-click="vm.visualizarUsuario(user)">
            <i class="fa fa-external-link" title="Visualizar"><span class="w3-hide-small w3-hide-medium">Ver Detalhes</span></i>
          </button>
          <button type="button" class="btn btn-default" ng-click="vm.banirUsuario(user)">
            <i class="fa fa-ban" title="Banir"><span class="w3-hide-small w3-hide-medium">Banir</span></i>
          </button>
          <button type="button" class="btn btn-default" ng-click="vm.desbanirUsuario(user)">
            <i class="fa fa-ban" title="Banir"><span class="w3-hide-small w3-hide-medium">Desbanir</span></i>
          </button>
        </div>
        <br>
        <hr>
      </div>
    </div>
    <div class="w3-row w3-padding-16" ng-show="vm.usuarios.length <= 0">
      Nenhum resultado foi encontrado.
    </div>
  </div>
  <div class="w3-row" ng-show="vm.user">
    <h3>Informações do usuário</h3>
    <div class="w3-row">
      <label>Nome:</label>
      {{vm.user.name}} {{vm.user.last_name}}
    </div>
    <div class="w3-row">
      <label>CPF:</label>
      {{vm.user.cpf}}
    </div>
    <div class="w3-row">
      <label>RG:</label>
      {{vm.user.rg}}
    </div>
    <div class="w3-row">
      <label>Gênero:</label>
      <span ng-show="vm.user.gender == 'male'">Homem</span>
      <span ng-show="vm.user.gender == 'female'">Mulher</span>
    </div>
    <div class="w3-row">
      <label>Email:</label>
      {{vm.user.email}}
    </div>
    <div class="w3-row">
      <label>Telefone principal:</label>
      ({{vm.user.ddd_1}}) {{vm.user.tel_1}}
    </div>
    <div class="w3-row">
      <label>Telefone secundário:</label>
      ({{vm.user.ddd_2}}) {{vm.user.tel_2}}
    </div>
    <div class="w3-row">
      <label>Cadastrado em:</label>
      {{vm.user.created_at}}
    </div>
    <div class="w3-row">
      <label>Rua:</label>
      {{vm.user.street}} - Número: {{vm.user.number}}
    </div>
    <div class="w3-row">
      {{vm.user.complement}}
    </div>
    <div class="w3-row">
      <label>Referência</label>
      {{vm.user.reference}}
    </div>
    <div class="w3-row">
      {{vm.user.cep}}, {{vm.user.neighborhood}} - {{vm.user.city}} - {{vm.user.UF}}
    </div>
  </div>
</div>
