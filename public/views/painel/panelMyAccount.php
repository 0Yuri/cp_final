<div class="w3-content w3-padding-large">
  <h3>Minha conta</h3><hr>
  <!-- Nome,sobrenome e email -->
  <form ng-submit="vm.atualizarDados()">
    <div class="w3-row">
      <div class="col-sm-4">
        <label>Nome:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.name">
      </div>
      <div class="col-sm-4">
        <label>Sobrenome:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.last_name">
      </div>
      <div class="col-sm-4">
        <label>Email:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.email" disabled>
      </div>
    </div>
    <!-- Data de nascimento, ddds + telefones -->
    <div class="w3-row">
      <div class="col-sm-4">
        <label>Data de nascimento:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.birthdate" mask="99-99-9999">
      </div>
      <div class="col-sm-1">
        <label>DDD</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.ddd_1" mask="99">
      </div>
      <div class="col-sm-3">
        <label>Telefone</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.tel_1" mask="999999999">
      </div>
      <div class="col-sm-1">
        <label>DDD</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.ddd_2" mask="99">
      </div>
      <div class="col-sm-3">
        <label>Telefone</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.tel_2" mask="999999999">
      </div>
    </div>
    <!-- RG, Tipo de pessoa e cpf ou cnpj -->
    <div class="w3-row">
      <div class="col-sm-2">
        <label>RG</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.rg" disabled>
      </div>
      <div class="col-sm-4">
        <label>CPF:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.user.cpf" mask="99999999999" disabled>
      </div>
    </div>
    <!-- Botão -->
    <div class="w3-row w3-padding-16">
      <button type="submit" class="btn btn-default">Atualizar dados</button>
    </div>

    <h5>{{vm.msg_status}}</h5>
  </form>


</div>
