<h3>Forma de pagamento</h3>
<div class="w3-row">
  <div class="w3-row">
    <div class="w3-row">
      <!-- Credit card -->
      <div class="w3-half">
        <h4>Cartão de crédito</h4>
        <input type="radio" name="payment_form" value="credit_card" ng-model="vm.payment_form">
        <div name="cardImages">
          <img src="{{imgFolder}}site/checkout/checkout-visa.gif">
          <img src="{{imgFolder}}site/checkout/checkout-diners.gif">
      		<img src="{{imgFolder}}site/checkout/checkout-elo.gif">
      		<img src="{{imgFolder}}site/checkout/checkout-hiper.gif">
      		<img src="{{imgFolder}}site/checkout/checkout-hipercard.gif">
      		<img src="{{imgFolder}}site/checkout/checkout-mastercard.gif">
      		<img src="{{imgFolder}}site/checkout/checkout-americanexpress.gif">
        </div>
      </div>
      <!-- Boleto bancário -->
      <div class="w3-half">
        <h4>Boleto bancário</h4>
        <input type="radio" name="payment_form" value="boleto" ng-model="vm.payment_form">
        <div name="boletoImage">
          <img src="{{imgFolder}}site/checkout/checkout-boleto.gif">
        </div>
      </div>
    </div>
    <!-- Formas de pagamentos -->
    <div class="w3-row">
      <!-- Credit card -->
      <div class="w3-content w3-center" ng-show="vm.payment_form =='credit_card'" style="padding: 0 10%">
        <form ng-submit="vm.pagarComCartao(vm.card)">
          <h3>Informações de cobrança</h3>
          <div class="w3-row">
            <div class="w3-quarter" style="margin-right:2%">
              <label>CEP:</label>
              <input type="text" ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" ng-model="vm.card.cep" maxlength="8">
            </div>
            <div class="w3-rest">
              <label>Rua:</label>
              <input type="text" ng-required="vm.payment_form == 'credit_card'" maxlength="70" class="w3-input w3-border w3-round" ng-model="vm.card.street">
            </div>
          </div>          
          <div class="w3-row">
            <div class="w3-quarter" style="margin-right:2%">
              <label>Número:</label>
              <input type="text" ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" ng-model="vm.card.address_number">
            </div>          
            <div class="w3-third" style="margin-right:2%">
              <label>Bairro:</label>
              <input type="text" ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" ng-model="vm.card.neighborhood">
            </div>
            <div class="w3-quarter" style="margin-right:2%">
              <label>Cidade:</label>
              <input type="text" ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" ng-model="vm.card.city">
            </div>
            <div class="w3-rest">
              <label>Estado:</label>
              <input type="text" ng-required="vm.payment_form == 'credit_card'" maxlength="3" class="w3-input w3-border w3-round" ng-model="vm.card.UF">
            </div>
          </div>
          <div class="w3-row">
            <label>Complemento:</label>
            <input type="text" ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" ng-model="vm.card.complement">
          </div>
          <div class="w3-row">
            <div class="w3-quarter" style="margin-right:2%">
              <label>DDD:</label>
              <input type="text" class="w3-input w3-border w3-round" maxlength="2" ng-required="vm.payment_form == 'credit_card'" ng-model="vm.card.ddd">
            </div>
            <div class="w3-third" style="margin-right:2%">
              <label>Telefone do titular:</label>
              <input type="text" class="w3-input w3-border w3-round"  maxlength="9" ng-required="vm.payment_form == 'credit_card'" ng-model="vm.card.phone">
            </div>
            <div class="w3-rest">
              <label>Data de nascimento do titular:</label>
              <input type="text" class="w3-input w3-border w3-round" maxlength="10" ng-required="vm.payment_form == 'credit_card'" ng-model="vm.card.birthdate" placeholder="xx-xx-xxxx" mask="99-99-9999">
            </div>
          </div>
          <div class="w3-row">
            <textarea id="public_key" class="w3-input w3-hide" >"-----BEGIN PUBLIC KEY-----
              MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnn0BRekMnGuLyfLAFQxA
              t0qob4qSwuHHAY4LqhdW6V+VZAsqs66xWJmjsjjeXsp+F17HfgxpHbOUqfyTy1EF
              7d9MtXk8kpAAqMAJNXDFGdAvj6eHSvsNyvhhq5SsK5U+HS2WYbBIUs5vDrNhyCSM
              18f2A/N5LYTNqP7HPDZM2WbEEQtyp308RXsXw2w46qjPVxTllBOrC3zc5LSEG8gj
              2igV3R7aqDb1wnkmqdKB8Lhwwrz5RMoN5+HmYzj2g0StQT70m5zhSTPpxWgWz44d
              VUr10Cs+B4g4ezRZ0LFa5afS1ZXxuoXa0G1d2/KGNMer8SpDVPf1wbg9nhcmK2QE
              mQIDAQAB
              -----END PUBLIC KEY-----"</textarea>
          </div>
          <h3>Informações de pagamento</h3>
          <div class="w3-row">
            <label>Nome do titular:</label>
            <input type="text" ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" ng-model="vm.card.name" placeholder="JOSE F G SILVA">
          </div>
          <div class="w3-row">
            <label>CPF do titular:</label>
            <input type="text" ng-required="vm.payment_form == 'credit_card'" maxlength="12" class="w3-input w3-border w3-round" ng-model="vm.card.cpf" placeholder="XXXXXXXXXXXX">
          </div>
          <div class="w3-row">
            <label>Número do cartão:</label>
            <input type="text" id="cc_number" ng-required="vm.payment_form == 'credit_card'"  class="w3-input w3-border w3-round" required ng-model="vm.card.number" placeholder="0000.0000.0000.0000" mask="9999999999999999">
          </div>
          <div class="w3-row">
            <div class="w3-third" style="padding-right:2%">
              <label>Mês:</label>
              <input type="text" id="cc_exp_month"  ng-required="vm.payment_form == 'credit_card'" class="w3-input w3-border w3-round" required ng-model="vm.card.expMonth" placeholder="MM" mask="99">
            </div>
            <div class="w3-third" style="padding-right:2%">
              <label>Ano</label>
              <input type="text" id="cc_exp_year" ng-required="vm.payment_form == 'credit_card'"  class="w3-input w3-border w3-round" required ng-model="vm.card.expYear" placeholder="YYYY" mask="9999">
            </div>
            <div class="w3-third">
              <label>CVC:</label>
              <input type="text" id="cc_cvc" ng-required="vm.payment_form == 'credit_card'"  class="w3-input w3-border w3-round" required ng-model="vm.card.cvc" placeholder="9999" mask="9999" maxlength=4>
            </div>
          </div>
          <div class="w3-row">
            <label>Parcelas:</label>
            <select class="w3-select w3-border w3-round" required ng-model="vm.card.parcelas">
              <option value="" disabled selected>Selecione a quantidade de parcelas</option>
              <option value="{{n}}" ng-repeat="n in vm.parcelas">Em {{n}} vezes</option>
            </select>
          </div>
          <div class="w3-row w3-padding-16">
            <button type="submit" class="btn btn-default" >Realizar o pagamento</button>
          </div>
        </form>
      </div>
      <!-- Boleto bancário -->
      <div class="w3-content w3-center" ng-show="vm.payment_form =='boleto'">
        <div class="w3-row" style="padding: 5% 0">
          <button type="submit" class="btn btn-default" ng-click="vm.pagarComBoleto()">Gerar boleto</button>
        </div>
        <div class="w3-row">
          <a ng-show="vm.boleto_view" href="{{vm.boleto_facil}}" target="_blank">Visualizar boleto</a>
        </div>
      </div>
    </div>
  </div>
</div>
