<div class="w3-container" style="margin-bottom:10%">
  <div class="w3-row">
    <h4>Painel Administrativo</h4>
  </div>
  <div class="w3-row w3-padding-16">
    <div class="w3-white w3-bar-block w3-col l2">
      <h3 class="w3-bar-item">Seções</h3>
      <a ui-sref="root.admin.users" class="w3-bar-item w3-button">Usuários</a>
      <a ui-sref="root.admin.stores" class="w3-bar-item w3-button">Lojas</a>
      <a ui-sref="root.admin.shopping" class="w3-bar-item w3-button">Compras</a>
    </div>
    <div class="w3-white w3-rest">
      <ui-view>Escolha uma seção para começar</ui-view>
    </div>
  </div>
</div>
