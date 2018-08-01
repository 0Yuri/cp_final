<div class="w3-row" style="padding:5%;margin-bottom:10%">
    <div class="w3-third w3-hide-small w3-hide-medium"><p></p></div>
    <div class="w3-row panel panel-default w3-round-xlarge w3-third">
        <form ng-submit="vm.verificarEmail(vm.info)">        
            <div class="w3-row" style="margin:5%">
                <label><h3>Para cadastrar-se, é fácil!<br> Digite seu email</h3></label>
                <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.info.email">
            </div>
            <div class="w3-row w3-padding">
                <span class="w3-text-red">{{vm.msg_error}}</span>
            </div>
            <div class="w3-row w3-padding">
                <button class="btn btn-default">Cadastrar-se</button>
            </div>
        </form>
    </div>
    <div class="w3-third w3-hide-small w3-hide-medium"></div>
</div>