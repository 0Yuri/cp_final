<?php

/* ------------------------------------------------
 * Rotas em teste devem ser testadas nesta parte
 * ------------------------------------------------
*/


Route::any('/debugging', 'SessionController@email_testing');
// Admin
Route::post('/admin/usuarios/pesquisar', 'AdminController@pesquisarUsuario');
Route::post('/admin/usuarios/banir', 'AdminController@banirUsuario');
Route::post('/admin/usuarios/desbanir', 'AdminController@desbanirUsuario');

Route::post('/admin/lojas/pesquisar', 'AdminController@pesquisarLoja');
Route::post('/admin/lojas/toggleStatus', 'AdminController@toggleLoja');

Route::get('/admin/estatisticas', 'AdminController@estatisticas');
// ------------------------ENDING OF TESTING SECTION-------------------------- //
// Checkout
Route::get('/checkout/definir_pedidos', 'CheckoutController@criarPedidoSessao');
Route::get('/checkout/pegar_pedidos', 'CheckoutController@pegarPedidos');
Route::post('/checkout/definir_entregas', 'CheckoutController@definirEntregas');
Route::get('/checkout/revisar_pedido', 'CheckoutController@revisarPedido');
Route::post('/checkout/frete', 'CheckoutController@calcularEntrega');
Route::post('/checkout/finalizar', 'CheckoutController@finalizar');
Route::post('/checkout/pagar', 'MoipController@buy');
Route::post('/checkout/cartao', 'MoipController@pagarCartao');
Route::get('/checkout/boleto', 'MoipController@pagarBoleto');
// Carrinho
Route::post('/cart/frete', 'CartController@calcularFrete');
Route::post('/cart/quantity', 'CartController@quantidade');
Route::get('/cart/products_on_cart', 'CartController@number');
Route::get('/cart/getCart' , 'CartController@get');
Route::post('/cart/remove', 'CartController@remover');
Route::post('/cart/add', 'CartController@adicionar');
Route::get('/cart/clear', 'CartController@clear'); // -- Limpar carrinho
// Entrega
Route::get('/delivery/address', 'DeliveryController@userAddress');
// Moip
Route::post('/moip/payment', 'MoipController@buy');
Route::get('/moip/balance', 'MoipController@pegarSaldo');
Route::post('/moip/withdraw', 'MoipController@sacarDinheiro');
// Compras
Route::post('/orders/myOrders', 'ShoppingController@getAll');
Route::post('/orders/compra', 'ShoppingController@compra');
Route::post('/orders/rastreio', 'SalesController@rastreio');
Route::post('/orders/venda', 'SalesController@venda');
Route::any('/orders/mySales', 'SalesController@pegarVendas');
Route::post('/orders/id', 'OrderController@pedidoID');
Route::post('/orders/loja', 'StoreController@lojaID');
Route::post('/order/getChat', 'OrderChatController@getChat');
Route::post('/order/sendMessage', 'OrderChatController@write');

Route::post('/order/avaliar_vendedor', 'EvaluationController@avaliarVendedor');
Route::post('/order/avaliar_comprador', 'EvaluationController@avaliarComprador');
Route::post('/order/checkComprador', 'EvaluationController@compradorAvaliado');
Route::post('/order/checkVendedor', 'EvaluationController@vendedorAvaliado');
// Usuário
Route::post('/user/signup', 'UserController@signup');
Route::post('/user/update', 'UserController@update');
Route::post('/user/login', 'SessionController@login');
Route::post('/user/activate', 'UserController@ativarConta');
Route::get('/user/logout', 'SessionController@logout');
Route::get('/user/session', 'SessionController@checkSession');
Route::get('/user/logged_user', 'SessionController@get_infos');
Route::get('/user/get_user', 'UserController@getUser');
Route::get('/user/checkStatus', 'UserController@admin');
Route::get('/user/destiny/{id}', 'UserController@destinatario');
// Favoritos
Route::post('/favorites/add', 'FavoritesController@adicionar_favorito');
Route::post('/favorites/remove', 'FavoritesController@remover_favorito');
Route::post('/favorites/get', 'FavoritesController@pegar_favoritos');
// Lojas
Route::post('/store/new_store', 'StoreController@nova_loja');
Route::post('/store/change_picture', 'StoreController@alterarImagem');
Route::post('/store/change_banner', 'StoreController@alterarBanner');
Route::post('/store/update_store', 'StoreController@alterar_loja');
Route::get('/store/toggle_store', 'StoreController@toggle_loja');
Route::get('/store/checkStore', 'SessionController@status_store');
Route::get('/store/logged_store', 'SessionController@logged_store');
Route::get('/store/status_store', 'SessionController@status_store');
Route::post('/store/store_products', 'ProductController@getProductFromStore');
Route::any('/store/produtos_vendidos', 'StoreController@numberOfSales');
Route::get('/store/featured', 'FeaturedController@lojasDestaque');

Route::post('/stores/get_store', 'StoreController@getStore');
Route::get('/stores/get_stores', 'StoreController@getAllStores');
// Produtos
Route::post('/product/add', 'ProductController@novoProduto');
Route::post('/product/update', 'ProductController@alterar_produto');
Route::post('/product/activate', 'ProductController@ativar_produto');

//Operações com as imagens dos produtos
Route::post('/product/profile/add', 'UploadController@uploadProductProfile');
Route::post('/product/extra/add', 'UploadController@uploadProductExtra');
Route::post('/product/remover_image', 'UploadController@deleteProductExtra');

Route::post('/product/deactivate', 'ProductController@desativar_produto');
Route::post('/product/get', 'ProductController@getProduct');
Route::post('/product/getForEdit', 'ProductController@getProductForEdition');
Route::get('/product/favorites', 'FavoritesController@pegar_favoritos');
Route::post('/product/logged_products', 'SessionController@logged_products');
Route::post('/product/getAll', 'ProductController@listarProdutos');
Route::post('/product/numberOfAll', 'ProductController@countActive');
Route::get('/product/featured', 'FeaturedController@produtosDestaque');
// Pedidos
Route::get('/order/set', 'OrderController@definirPedido');
Route::post('/order/setDeliveryMethods', 'DeliveryController@setEntregas');
Route::post('/order/pegarPedido', 'MoipController@getOrder');
// Perguntas
Route::any('/question/getActiveQuestions', 'QuestionController@perguntasAtivas');
Route::post('/question/ask', 'QuestionController@perguntar');
Route::post('/question/answer', 'QuestionController@responder');
Route::post('/question/getQuestions', 'QuestionController@pegarPerguntas');
Route::post('/question/getQuestion', 'QuestionController@pegarPergunta');
// Categorias
Route::get('/categories/getAll', 'CategoryController@pegar_categorias');
Route::post('/categories/new_category', 'CategoryController@nova_categoria');
Route::post('/categories/delete_category', 'CategoryController@remover_categoria');
// Marcas
Route::post('/brands/new_brand', 'BrandController@nova_marca');
Route::post('/brands/delete_brand', 'BrandController@desativar_marca');
Route::get('/brands/get_brands', 'BrandController@pegar_marcas');
// Fale Conosco
Route::post('/contact/contact_us', 'ContactController@fale_conosco');
// Endereços
Route::post('/address/get', 'CorreiosController@pegarEndereco');
Route::post('/address/getSignup', 'CorreiosController@pegarEnderecoCadastro');
// Pesquisa
Route::post('/search', 'SearchController@pesquisar');
// Mensagens - OK
Route::any('/message/sent', 'MessageController@enviadas');
Route::any('/message/received', 'MessageController@recebidas');
Route::post('/message/get', 'MessageController@pegarMensagem');
Route::post('/message/send', 'MessageController@escrever');
Route::post('/message/answer', 'MessageController@responder');
