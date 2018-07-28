<div class="" style="margin-bottom:10%">
<form ng-submit="vm.cadastrarMoip(vm.field)" novalidate>
    <h4>Informações básicas</h4>
    <hr>
    <div class="row">
      <div class="col-sm-3">
        <label>Nome:</label>
        <input type="text" name="name" class="w3-input w3-border w3-round" required ng-model="vm.field.name" maxlength="50" placeholder="Digite o seu primeiro nome">
      </div>
      <div class="col-sm-3">
        <label>Sobrenome:</label>
        <input type="text" name="last_name" class="w3-input w3-border w3-round" required ng-model="vm.field.last_name" maxlength="50" placeholder="Digite o seu sobrenome">
      </div>
      <div class="col-sm-3">
        <label>Gênero:</label>
        <select class="w3-select w3-border w3-round" name="gender" required ng-model="vm.field.gender">
          <option value="">Selecione uma opção</option>
          <option value="male">Masculino</option>
          <option value="female">Feminino</option>
        </select>
      </div>
      <div class="col-sm-3">
        <label>Data de nascimento:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.field.birthdate" mask="99-99-9999" placeholder="dd-mm-aaaa">
      </div>
    </div>

    <h4>Informações de Contato</h4>
    <hr>
    <div class="row">
      <div class="col-sm-2">
        <label>DDD:</label>
        <input type="text" name="ddd_1" class="w3-input w3-border w3-round" required ng-model="vm.field.ddd_1" mask="99" placeholder="99">
      </div>
      <div class="col-sm-2">
        <label>Telefone Principal:</label>
        <input type="text" name="tel_1" class="w3-input w3-border w3-round" required ng-model="vm.field.tel_1" mask="999999999" placeholder="999999999">
      </div>
      <div class="col-sm-2">
        <label>DDD:</label>
        <input type="text" name="ddd_2" class="w3-input w3-border w3-round" required ng-model="vm.field.ddd_2" mask="99" placeholder="99">
      </div>
      <div class="col-sm-2">
        <label>Telefone Secundário:</label>
        <input type="text" name="tel_2" class="w3-input w3-border w3-round" required ng-model="vm.field.tel_2" mask="999999999" placeholder="999999999">
      </div>
      <div class="col-sm-4">
        <label>Email:</label>
        <input type="text" name="email" class="w3-input w3-border w3-round" required ng-model="vm.field.email" maxlength="50" placeholder="Digite o seu email">
      </div>
    </div>

    <h4>Informações essenciais</h4>
    <hr>
    <div class="row">
      <div class="col-sm-2">
        <label>CPF:</label>
        <input type="text" name="cpf" class="w3-input w3-border w3-round" required ng-model="vm.field.cpf" mask="99999999999" placeholder="99999999999">
      </div>
      <div class="col-sm-2">
        <label>RG:</label>
        <input type="text" name="rg" class="w3-input w3-border w3-round" required ng-model="vm.field.rg" mask="999999999" placeholder="99999999">
      </div>
      <div class="col-sm-2">
        <label>Emissor:</label>
        <input type="text" name="issuer" class="w3-input w3-border w3-round" required ng-model="vm.field.issuer" placeholder="Digite o nome do orgão emissor">
      </div>
      <div class="col-sm-2">
        <label>Data de emissão:</label>
        <input type="text" name="issue_date" class="w3-input w3-border w3-round" required ng-model="vm.field.issue_date" mask="99-99-9999" placeholder="dd-mm-aaaa">
      </div>
      <div class="col-sm-2">
        <label>Senha:</label>
        <input type="password" name="password" class="w3-input w3-border w3-round" required ng-model="vm.field.password">
      </div>
      <div class="col-sm-2">
        <label>Confirmar Senha:</label>
        <input type="password" name="confirmpassword" class="w3-input w3-border w3-round" required ng-model="vm.field.confirmpassword">
      </div>
    </div>

    <h4>Informações de endereço:</h4>
    <hr>
    <div class="row">
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
        <input type="text" name="complement" class="w3-input w3-border w3-round" required ng-model="vm.address.complement" placeholder="Apartamento 223">
      </div>
      <div class="col-sm-4">
        <label>Referência:</label>
        <input type="text" name="reference" class="w3-input w3-border w3-round" required ng-model="vm.address.reference" placeholder="Perto do supermercado X">
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

    <div class="w3-padding-16">
        <button type="submit" class="btn btn-default">Cadastrar</button>
        <button type="reset" class="btn btn-default">Limpar</button>
    </div>
    <h5>{{vm.msg_error}}</h5>
    </form>
</div>