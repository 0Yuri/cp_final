<?php
/* --------------------------------------------------
 * FILES INCLUDES
 * --------------------------------------------------
 * There are 2 ways to include a file:
 * 		$load['type'][] = 'file_name';
 *		$load['type']['folder'][] = 'file_name';
 *
 * THE ORDER OF INCLUSIONS MATTER.
 */

/* --------------------------------------------------
 * assets/css/core/
 * --------------------------------------------------
 */
$load['css']['core'][] = 'bootstrap.min';
$load['css']['core'][] = 'bootstrap-theme.min';
$load['css']['core'][] = 'font-awesome.min';
$load['css']['core'][] = 'w3';

/* --------------------------------------------------
 * assets/css/
 * --------------------------------------------------
 */
$load['css'][] = 'general';
$load['css'][] = 'login-signup';
$load['css'][] = 'crescendo';

/* --------------------------------------------------
 * assets/js/core/
 * --------------------------------------------------
 */
$load['js']['core'][] = 'angular.min';
$load['js']['core'][] = 'angular-ui-router.min';
$load['js']['core'][] = 'jquery.min';
$load['js']['core'][] = 'bootstrap.min';
$load['js']['core'][] = 'ngMask.min';
$load['js']['core'][] = 'angular-file-upload.min';
$load['js']['core'][] = 'personal';
/* --------------------------------------------------
 * assets/js/
 * --------------------------------------------------
 */
$load['js'][] = 'app';
$load['js'][] = 'config';
$load['js'][] = 'directives';

/* --------------------------------------------------
 * assets/js/controllers/
 * --------------------------------------------------
 */
// Controladores das páginas principais
$load['js']['controllers'][] = 'main-root-controller'; // Tela do topo
$load['js']['controllers'][] = 'main-home-controller'; // Inicial
$load['js']['controllers'][] = 'main-signup-controller'; // Cadastro
$load['js']['controllers'][] = 'main-help-controller'; // Ajuda
$load['js']['controllers'][] = 'main-search-controller'; // Pesquisa
$load['js']['controllers'][] = 'main-product-controller'; // Página de um Produto
$load['js']['controllers'][] = 'main-products-controller'; // Produtos
$load['js']['controllers'][] = 'main-store-controller'; // Página de uma loja
$load['js']['controllers'][] = 'main-stores-controller'; // Lojas
$load['js']['controllers'][] = 'main-debug-controller';
// Controladores das páginas do painel
$load['js']['controllers'][] = 'panel-controller'; // Padrao
$load['js']['controllers'][] = 'panel-admin-controller'; // Painel administrativo
$load['js']['controllers'][] = 'panel-dashboard-controller'; // Dashboard inicial
$load['js']['controllers'][] = 'panel-favorites-controller'; // Favoritos
$load['js']['controllers'][] = 'panel-home-controller'; // Tela inicial do painel
// Controladores relacionados a Pedidos(vendas)
$load['js']['controllers'][] = 'panel-sale-controller';
$load['js']['controllers'][] = 'panel-sales-controller';
// Controladores relacionados a Pedidos(compras)
$load['js']['controllers'][] = 'panel-shop-controller';
$load['js']['controllers'][] = 'panel-shopping-controller';
// Controladores de mensagens
$load['js']['controllers'][] = 'panel-message-controller';
$load['js']['controllers'][] = 'panel-write-message';
$load['js']['controllers'][] = 'panel-messages-controller';
// Controladores de Perguntas e respostas
$load['js']['controllers'][] = 'panel-question-controller';
$load['js']['controllers'][] = 'panel-answer-controller';
// Controlador de minha conta
$load['js']['controllers'][] = 'panel-my-account-controller';
// Controlador de produtos
$load['js']['controllers'][] = 'panel-create-product-controller';
$load['js']['controllers'][] = 'panel-edit-product-controller';
// Sem definicao
$load['js']['controllers'][] = 'panel-order-controller';
$load['js']['controllers'][] = 'panel-withdraw-controller';
// Store related controllers
$load['js']['controllers'][] = 'panel-view-store-controller';
$load['js']['controllers'][] = 'panel-create-store-controller';
$load['js']['controllers'][] = 'panel-store-controller';
$load['js']['controllers'][] = 'panel-edit-store-controller';

// Controladores de checkout
$load['js']['controllers'][] = 'checkout-main-controller';
$load['js']['controllers'][] = 'checkout-cart-controller';
$load['js']['controllers'][] = 'checkout-delivery-controller';
$load['js']['controllers'][] = 'checkout-review-controller';
$load['js']['controllers'][] = 'checkout-payment-controller';
$load['js']['controllers'][] = 'checkout-final-controller';

/* --------------------------------------------------
 * assets/js/services/
 * --------------------------------------------------
 */
 $load['js']['services'][] = 'root-service';
 $load['js']['services'][] = 'user-service';
 $load['js']['services'][] = 'path-to-provider';
 $load['js']['services'][] = 'upload-service';
 $load['js']['services'][] = 'test-service';

 $load['js']['services'][] = 'fileupload-service';
