<div>
	<h3>Crie sua lojinha</h3>
	<form ng-submit="vm.criarLoja(vm.lojinha)">
		<div class="w3-content">
			<div class="w3-row w3-padding">
				<label>
					<img class="w3-round" ng-show="!profile_preview" src="{{imgFolder}}stores/logo/default_profile2.png" width="200px" height="200px" alt="fotoLoja" title="Clique para alterar a imagem">
	        <img class="w3-round" ng-src="{{profile_preview}}" ng-show="profile_preview" width="200px" height="200px" title="Clique para alterar a imagem">
	        <input type="file" file-model="bannerFile" filepreview="profile_preview" fileinput="profilePicture" style="display:none;">
				</label>
			</div>
			<div class="w3-row w3-mobile">
				<label>Nome da lojinha:</label>
				<input type="text" class="w3-input w3-border w3-round" required ng-model="vm.lojinha.name" placeholder="Nome da lojinha">
			</div>
			<div class="w3-row w3-mobile">
				<div class="w3-quarter" style="padding-right: 2%">
					<label>DDD:</label>
					<input type="text" class="w3-input w3-border w3-round" required ng-model="vm.lojinha.ddd" mask="99" placeholder="99">
				</div>
				<div class="w3-rest">
					<label>Telefone:</label>
					<input type="text" class="w3-input w3-border w3-round" required ng-model="vm.lojinha.phone" mask="999999999" placeholder="999999999">
				</div>
			</div>
			<div class="w3-row w3-mobile">
				<label>Descrição da lojinha:</label>
				<textarea class="w3-input w3-border w3-round" rows="8" cols="80" required ng-model="vm.lojinha.description" placeholder="Conte-nos um pouco sobre sua lojinha..."></textarea>
			</div>
		</div>
		<div class="w3-row w3-padding">
			<button type="submit" name="criarloja" class="btn btn-default">Criar loja</button>
		</div>
	</form>
</div>
