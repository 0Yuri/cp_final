<div class="w3-row" style="margin:5% 10%">
    <form ng-submit="vm.cadastrarPessoal(vm.field)" novalidate>
        <h4>Informações básicas</h4>
        <hr>
        <div class="w3-row">
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
        <h4>Informações essenciais</h4>
        <hr>
        <div class="w3-row">
            <div class="col-sm-3">
                <label>CPF:</label>
                <input type="text" name="cpf" class="w3-input w3-border w3-round" required ng-model="vm.field.cpf" mask="99999999999" placeholder="99999999999">
            </div>
            <div class="col-sm-3">
                <label>RG:</label>
                <input type="text" name="rg" class="w3-input w3-border w3-round" required ng-model="vm.field.rg" mask="999999999" placeholder="99999999">
            </div>
            <div class="col-sm-3">
                <label>Emissor:</label>
                <input type="text" name="issuer" class="w3-input w3-border w3-round" required ng-model="vm.field.issuer" placeholder="Digite o nome do orgão emissor">
            </div>
            <div class="col-sm-3">
                <label>Data de emissão:</label>
                <input type="text" name="issue_date" class="w3-input w3-border w3-round" required ng-model="vm.field.issue_date" mask="99-99-9999" placeholder="dd-mm-aaaa">
            </div>
        </div>
        <div class="w3-row w3-center w3-padding">
            <button class="btn btn-default" type="submit">Prosseguir</button>
            <button class="btn btn-default" type="reset">Limpar</button>
        </div>
    </form>
    <div class="w3-padding">
        {{vm.msg_error}}
    </div>
</div>