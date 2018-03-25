<?php

/* ------------------------------------------------
 * Rotas em teste devem ser testadas nesta parte
 * ------------------------------------------------
*/


// Route::any('/debugging', 'SessionController@email_testing');
// Admin
Route::post('/admin/usuarios/pesquisar', 'AdminController@pesquisarUsuario');
Route::post('/admin/usuarios/banir', 'AdminController@banirUsuario');
Route::post('/admin/usuarios/desbanir', 'AdminController@desbanirUsuario');

Route::post('/admin/lojas/pesquisar', 'AdminController@pesquisarLoja');
Route::post('/admin/lojas/toggleStatus', 'AdminController@toggleLoja');

Route::get('/admin/estatisticas', 'AdminController@estatisticas');
// ------------------------ENDING OF TESTING SECTION-------------------------- //

// Checkout - OK
Route::get('/checkout/definir_pedidos', 'CheckoutController@createSessionOrder');
Route::get('/checkout/pegar_pedidos', 'CheckoutController@getOrders');
Route::post('/checkout/definir_entregas', 'CheckoutController@setDeliveries');
Route::get('/checkout/revisar_pedido', 'CheckoutController@reviewOrder');
Route::post('/checkout/frete', 'CheckoutController@calculateDelivery');
Route::post('/checkout/finalizar', 'CheckoutController@finalize');
Route::post('/checkout/pagar', 'MoipController@buy');
Route::post('/checkout/cartao', 'MoipController@payWithCreditCard');
Route::get('/checkout/boleto', 'MoipController@payWithBoleto');

// Carrinho - OK
Route::get('/cart/getCart' , 'CartController@get'); // Pega o carrinho
Route::get('/cart/products_on_cart', 'CartController@number'); // Pega o número de produtos no carrinho
Route::post('/cart/add', 'CartController@addProduct'); // Adiciona o produto no carrinho
Route::post('/cart/remove', 'CartController@removeProduct'); // Remove o produto do carrinho
Route::get('/cart/clear', 'CartController@clear'); // Limpa o carrinho
Route::post('/cart/quantity', 'CartController@changeQuantityOfProduct'); // Muda a qtd de unidades de um produto no carrinho
Route::post('/cart/frete', 'CartController@GetDeliveryValues'); // Simula o frete do pedido no carrinho
// Entrega
Route::get('/delivery/address', 'DeliveryController@userAddress'); // Pega o endereço do usuário

// Moip - OK
Route::get('/moip/balance', 'MoipController@getAccountBalance');
Route::post('/moip/withdraw', 'MoipController@withdrawMoney');

// Pedidos - OK
Route::post('/orders/myOrders', 'ShoppingController@getAll'); // Pega compras
Route::any('/orders/mySales', 'SalesController@getSales'); // Pega vendas

Route::post('/orders/compra', 'ShoppingController@getOrder'); // Pega pedido de compra
Route::post('/orders/venda', 'SalesController@getOrder'); // Pega pedido de venda
Route::post('/order/getChat', 'OrderChatController@getChat'); // Pega o chat
Route::post('/order/sendMessage', 'OrderChatController@write'); // Escreve uma mensagem no chat
Route::post('/orders/rastreio', 'SalesController@addTrackingCode'); // Adiciona o código de rastreio ao pedido
Route::post('/orders/id', 'OrderController@getOrderID'); // Pega o id do pedido
Route::post('/orders/loja', 'StoreController@getStoreID'); // Pega o id da loja

// Avaliações - OK TODO: REWORK das funções
Route::post('/order/avaliar_vendedor', 'EvaluationController@evaluateSeller');
Route::post('/order/avaliar_comprador', 'EvaluationController@evaluateBuyer');
Route::post('/order/checkComprador', 'EvaluationController@isBuyerEvaluated');
Route::post('/order/checkVendedor', 'EvaluationController@isSellerEvaluated');

// Usuários - OK
Route::post('/user/signup', 'UserController@signup');
Route::post('/user/update', 'UserController@update');
Route::post('/user/activate', 'UserController@activateAccount');
Route::get('/user/get_user', 'UserController@getUser');
Route::get('/user/checkStatus', 'UserController@admin');

// Favoritos - OK
Route::post('/favorites/add', 'FavoritesController@addFavorite');
Route::post('/favorites/remove', 'FavoritesController@removeFavorite');
Route::post('/favorites/get', 'FavoritesController@getFavorites');

// Lojas - OK
Route::post('/store/new_store', 'StoreController@newStore');
Route::post('/store/update_store', 'StoreController@alterar_loja');
Route::get('/store/toggle_store', 'StoreController@toggleStatusStore');
Route::post('/store/store_products', 'ProductController@getProductFromStore');
Route::any('/store/produtos_vendidos', 'StoreController@numberOfSales');
Route::post('/stores/get_store', 'StoreController@getStore');
Route::get('/stores/get_stores', 'StoreController@getAllStores');
Route::get('/store/featured', 'FeaturedController@featuredStores');

// Lojas - Upload de imagem
Route::post('/store/change_picture', 'StoreController@uploadStoreLogo');
Route::post('/store/change_banner', 'StoreController@uploadBannerImage');

// Pedidos - OK
Route::get('/order/set', 'OrderController@setOrder');
Route::post('/order/setDeliveryMethods', 'DeliveryController@setDelivery');
Route::post('/order/pegarPedido', 'MoipController@getOrder');

// Sessão - Produtos
Route::post('/user/login', 'SessionController@login');
Route::get('/user/logout', 'SessionController@logout');
Route::get('/user/session', 'SessionController@checkSession');
Route::get('/user/logged_user', 'SessionController@get_infos');

Route::get('/product/favorites', 'FavoritesController@getFavorites');
Route::post('/product/getForEdit', 'ProductController@getProductForEdition');
Route::post('/product/logged_products', 'SessionController@logged_products');

// Sessão - Lojas
Route::get('/store/checkStore', 'SessionController@isStoreCreated');
Route::get('/store/logged_store', 'SessionController@logged_store');
Route::get('/store/status_store', 'SessionController@status_store');

// Produtos - OK
Route::post('/product/add', 'ProductController@newProduct');
Route::post('/product/update', 'ProductController@updateProduct');
Route::post('/product/toggleStatus', 'ProductController@toggleStatus');
Route::post('/product/get', 'ProductController@getProduct');
Route::post('/product/getAll', 'ProductController@getProducts');
Route::get('/product/featured', 'FeaturedController@featuredProducts');
Route::post('/product/numberOfAll', 'ProductController@getPageCount');

// Produtos - Upload de Imagens
Route::post('/product/profile/add', 'UploadController@uploadProductProfile');
Route::post('/product/extra/add', 'UploadController@uploadProductExtra');
Route::post('/product/remover_image', 'UploadController@deleteProductExtra');

// Perguntas - OK
Route::post('/question/ask', 'QuestionController@ask');
Route::post('/question/answer', 'QuestionController@answer');
Route::post('/question/getQuestions', 'QuestionController@getQuestions');
Route::post('/question/getQuestion', 'QuestionController@getQuestion');
Route::any('/question/getActiveQuestions', 'QuestionController@getActiveQuestions');

// Categorias - OK
Route::post('/categories/new_category', 'CategoryController@newCategory');
Route::get('/categories/getAll', 'CategoryController@getCategories');

// Marcas - OK
Route::post('/brands/new_brand', 'BrandController@newBrand');
Route::get('/brands/get_brands', 'BrandController@getBrands');

// Fale Conosco - OK
Route::post('/contact/contact_us', 'ContactController@contact_us');

// Endereços - OK
Route::post('/address/get', 'CorreiosController@getAddress');
Route::post('/address/getSignup', 'CorreiosController@getAddressForSignup');

// Pesquisa - OK
Route::post('/search', 'SearchController@search');

// Mensagens - OK
Route::any('/message/sent', 'MessageController@sent');
Route::any('/message/received', 'MessageController@received');
Route::post('/message/get', 'MessageController@getMessage');
Route::post('/message/send', 'MessageController@write');
Route::post('/message/answer', 'MessageController@answer');
Route::post('/message/erase', 'MessageController@erase');
