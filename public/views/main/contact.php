<h2>Fale conosco</h2>
<div class="w3-container w3-cell">
  <div class="text-left">
    <form ng-submit="vm.fale_conosco()">
      <div class="w3-row">
        <label>Seu nome:</label>
        <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.message.name">
      </div>
      <div class="w3-row">
        <div class="w3-half" style="padding-right:2%">
          <label>Seu email:</label>
          <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.message.email">
        </div>
        <div class="w3-half">
          <label>Telefone</label>
          <input type="text" class="w3-input w3-border w3-round" required ng-model="vm.message.phone" mask="00000000">
        </div>
      </div>
      <div class="w3-row">
        <label>Sua mensagem:</label>
        <textarea name="name" rows="8" cols="80" class="w3-input w3-border w3-round" required ng-model="vm.message.content"></textarea>
      </div>
      <div class="w3-row w3-padding-16 text-center">
        <button type="submit" class="btn btn-default">Enviar</button><br>
      </div>
      <div class="w3-row w3-padding-16 text-center">
        <span>{{vm.msg}}</span>
      </div>
    </form>
  </div>
</div>
