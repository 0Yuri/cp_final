<div class="w3-container">
  <form ng-submit="vm.responderPergunta(vm.pergunta)">
    <div class="w3-row">
      <div class="panel panel-default" style="margin: 0 20% 0 20%">
        <div class="panel-heading">
          Pergunta
        </div>
        <div class="panel-body">
          <div class="w3-row">
            {{vm.pergunta.question}}
            <hr>
          </div>
          <div class="w3-row">
            <label>Resposta:</label>
            <textarea name="answer" rows="8" cols="80" class="w3-input w3-round w3-border" required ng-model="vm.pergunta.answer" placeholder="Responda aqui"></textarea>
          </div>
          <div class="w3-row w3-padding-16">
            <button type="submit" class="btn btn-default">Responder</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
