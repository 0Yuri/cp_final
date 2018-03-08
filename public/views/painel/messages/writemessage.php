<div class="w3-content" style="padding-bottom:5%">
  <form ng-submit="vm.escreverMensagem(vm.message)">
    <div class="w3-row w3-padding">
      <label>Para:</label>
      <span style="text-transform:capitalize">{{vm.destinatario.name}} {{vm.destinatario.last_name}}</span>
    </div>
    <div class="w3-row w3-padding">
      <label>Assunto:</label>
      <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.message.subject">
    </div>
    <div class="w3-row w3-padding">
      <label>Mensagem:</label>
      <textarea class="w3-input w3-border w3-round" rows="8" cols="80" required ng-model="vm.message.content" maxlength="700">
      </textarea>
      <span ng-show="vm.message.content.length < 700">
        Você possui {{700 - vm.message.content.length}} caracteres restantes.
      </span>
      <span ng-show="vm.message.content.length == 700">
        Você esgotou o limite de caracteres.
      </span>
    </div>
    <div class="w3-row w3-padding">
      <button type="submit" class="btn btn-default">Enviar mensagem</button>
      <button type="reset" class="btn btn-default">Cancelar</button>
    </div>
  </form>

</div>
