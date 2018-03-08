<div class="w3-row">
  <div class="w3-third panel panel-default" style="padding:2px">
    <h3>R$ {{vm.saldo.disponivel | number: 2}}</h3>
    Saldo disponível
  </div>
  <div class="w3-third panel panel-default" style="padding:2px">
    <h3>R$ {{vm.saldo.futuro | number: 2}}</h3>
    Lançamentos futuros
  </div>
  <div class="w3-third panel panel-default" style="padding:2px">
    <h3>R$ {{vm.saldo.indisponivel | number: 2}}</h3>
    Saldo indisponível
  </div>
</div>
<div class="w3-row">
  <div class="alert alert-warning">
    <strong>Atenção!</strong> Lançamentos futuros levam em média 14 dias para serem liberados para saques.
  </div>
</div>
<div class="w3-row w3-padding-16 w3-border" style="margin: 0% 15% 5% 15%">
  <form ng-submit="vm.sacarDinheiro(data)">
    <div class="w3-row">
      <div class="w3-third" style="padding:2%">
        <div class="w3-twothird" style="margin-right: 2%">
          <label>Agência:</label>
          <input type="text" placeholder="9999" class="w3-input w3-round w3-border" required ng-model="data.agency_number">
        </div>
        <div class="w3-rest">
          <label>Dígito:</label>
          <input type="text" placeholder="9" class="w3-input w3-round w3-border" required ng-model="data.agency_check_number">
        </div>
      </div>
      <div class="w3-third" style="padding:2%">
        <div class="w3-twothird" style="margin-right:2%">
          <label>Conta corrente:</label>
          <input type="text" placeholder="999999" class="w3-input w3-round w3-border" required ng-model="data.account_number">
        </div>
        <div class="w3-rest">
          <label>Dígito:</label>
          <input type="text" placeholder="9" class="w3-input w3-round w3-border" required ng-model="data.account_check_number">
        </div>
      </div>
      <div class="w3-third" style="padding:2%">
        <label>Banco:</label>
        <select class="w3-select w3-round w3-border" required ng-model="data.bank_number">
          <option value="" selected disabled>Selecione seu banco</option>
          <option value="001">Banco do Brasil</option>
        </select>
      </div>
    </div>
    <div class="w3-row">
      <div class="w3-third" style="padding:2%">
        <label>Valor:</label>
        <input type="text" placeholder="R$ 999" class="w3-input w3-border w3-round" required ng-model="data.amount">
      </div>
      <div class="w3-third" style="padding:2%">
        <label>Nome Completo:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="data.holder_name" placeholder="Nome do titular da conta">
      </div>
      <div class="w3-third" style="padding:2%">
        <label>CPF:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="data.tax_document" ng-mask="99999999999" placeholder="xxxxxxxxxxx">
      </div>
    </div>
    <button type="submit" class="btn btn-default" >Sacar Dinheiro</button>
  </form>
</div>
