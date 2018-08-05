<div class="w3-row" style="margin:5% 10%">
    <form ng-submit="vm.cadastrarEnderecos(vm.address)">
    <h3>Informações de cobrança e entregas</h3>
    <hr>
    <div class="w3-row">
        <div class="col-sm-3">
            <label>CEP:</label>
            <input type="text" name="cep" class="w3-input w3-border w3-round" required ng-model="vm.address.cep" mask="99999-999" ng-change="vm.textChanged(vm.address)" placeholder="99999-999">
        </div>
        <div class="col-sm-3">
            <label>Rua:</label>
            <input type="text" name="street" class="w3-input w3-border w3-round" required ng-model="vm.address.street" placeholder="Digite o nome da rua">
        </div>
        <div class="col-sm-3">
            <label>Número:</label>
            <input type="text" name="number" class="w3-input w3-border w3-round" required ng-model="vm.address.number" placeholder="Número da residência">
        </div>
        <div class="col-sm-3">
            <label>Bairro:</label>
            <input type="text" name="neighborhood" class="w3-input w3-border w3-round" required ng-model="vm.address.neighborhood" placeholder="Digite o bairro">
        </div>
        <div class="col-sm-4">
            <label>Complemento:</label>
            <input type="text" name="complement" class="w3-input w3-border w3-round" ng-model="vm.address.complement" placeholder="Apartamento 223">
        </div>
        <div class="col-sm-4">
            <label>Referência:</label>
            <input type="text" name="reference" class="w3-input w3-border w3-round" ng-model="vm.address.reference" placeholder="Perto do supermercado X">
        </div>
        <div class="col-sm-1">
            <label>Estado:</label>
            <input type="text" name="uf" class="w3-input w3-border w3-round" required ng-model="vm.address.UF" placeholder="XX">
        </div>
        <div class="col-sm-3">
            <label>Cidade:</label>
            <input type="text" name="city" class="w3-input w3-border w3-round" required ng-model="vm.address.city" placeholder="Digite o nome da sua cidade">
        </div>
    </div>
    <div class="w3-row w3-padding">
        <button class="btn btn-default" type="submit">Prosseguir</button>
        <button class="btn btn-default" type="reset">Limpar</button>
    </div>
    </form>
</div>