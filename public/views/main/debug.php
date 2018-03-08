<div class="w3-container">
  Área de testes
  <div class="w3-row">
    <div class="w3-row">
      <label>PaymentID:</label>
      <input type="text" required ng-model="vm.payment.id">
    </div>
    <div class="w3-row">
      <label>Valor:</label>
      <input type="text" required ng-model="vm.payment.amount">
    </div>
    <div class="w3-row">
      <a target="_blank" href="https://sandbox.moip.com.br/simulador/authorize?payment_id={{vm.payment.id}}&amount={{vm.payment.amount}}">Pagar</a>
    </div>
    <div class="w3-row w3-padding">
      https://sandbox.moip.com.br/simulador/authorize?payment_id={{vm.payment.id}}&amount={{vm.payment.amount}}
    </div>
  </div>
</div>
