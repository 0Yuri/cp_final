<?php

// Admin
Route::post('/admin/users/search', 'AdminController@pesquisarUsuario');
Route::post('/admin/users/ban', 'AdminController@banirUsuario');
Route::post('/admin/users/unban', 'AdminController@desbanirUsuario');

Route::post('/admin/stores/search', 'AdminController@pesquisarLoja');
Route::post('/admin/stores/toggleStatus', 'AdminController@toggleLoja');

Route::get('/admin/stats', 'AdminController@estatisticas');

Route::get('/moip/connect', 'MoipController@link');
Route::any('/moip/receive', 'MoipController@autorizarAppMoip');

Route::post('/webhooks', 'MoipController@getWebHooks');
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
Route::get('/cart/productsCart', 'CartController@number'); // Pega o número de produtos no carrinho
Route::post('/cart/add', 'CartController@addProduct'); // Adiciona o produto no carrinho
Route::post('/cart/remove', 'CartController@removeProduct'); // Remove o produto do carrinho
Route::get('/cart/clear', 'CartController@clear'); // Limpa o carrinho
Route::post('/cart/quantity', 'CartController@changeQuantityOfProduct'); // Muda a qtd de unidades de um produto no carrinho
Route::post('/cart/frete', 'CartController@GetDeliveryValues'); // Simula o frete do pedido no carrinho
Route::get('/cart/parcelas', 'CartController@getParcelas');

// Entrega
Route::get('/delivery/address', 'DeliveryController@userAddress'); // Pega o endereço do usuário

// Moip - OK
Route::get('/moip/balance', 'MoipController@getAccountBalance');
Route::post('/moip/withdraw', 'MoipController@withdrawMoney');

// Pedidos - OK
Route::post('/orders/myOrders', 'ShoppingController@getAll'); // Pega compras
Route::any('/orders/mySales', 'SalesController@getSales'); // Pega vendas

Route::post('/orders/buyOrder', 'ShoppingController@getOrder'); // Pega pedido de compra
Route::post('/orders/sellOrder', 'SalesController@getOrder'); // Pega pedido de venda
Route::post('/order/getChat', 'OrderChatController@getChat'); // Pega o chat
Route::post('/order/sendMessage', 'OrderChatController@write'); // Escreve uma mensagem no chat
Route::post('/orders/tracking', 'SalesController@addTrackingCode'); // Adiciona o código de rastreio ao pedido
Route::post('/orders/id', 'OrderController@getOrderID'); // Pega o id do pedido
Route::post('/orders/loja', 'StoreController@getStoreID'); // Pega o id da loja

// Avaliações - OK
// TODO: reavaliar funcionalidades.
Route::post('/order/evaluateSeller', 'EvaluationController@evaluateSeller');
Route::post('/order/evaluateBuyer', 'EvaluationController@evaluateBuyer');
Route::post('/order/getBuyerStatus', 'EvaluationController@isBuyerEvaluated');
Route::post('/order/getSellerStatus', 'EvaluationController@isSellerEvaluated');

// Usuários - OK
Route::post('/user/signup', 'UserController@signup');
Route::post('/user/update', 'UserController@update');
Route::post('/user/activate', 'UserController@activateAccount');
Route::get('/user/getUser', 'UserController@getUser');
Route::get('/user/checkStatus', 'UserController@admin');

// Favoritos - OK
Route::post('/favorites/add', 'FavoritesController@addFavorite');
Route::post('/favorites/remove', 'FavoritesController@removeFavorite');
Route::post('/favorites/get', 'FavoritesController@getFavorites');

// Lojas - OK
Route::post('/store/newStore', 'StoreController@newStore');
Route::post('/store/updateStore', 'StoreController@updateStore');
Route::get('/store/toggleStore', 'StoreController@toggleStatusStore');
Route::post('/store/storeProducts', 'StoreController@getStoreProducts');
Route::any('/store/soldProducts', 'StoreController@numberOfSales');
Route::post('/stores/getStore', 'StoreController@getStore');
Route::get('/stores/getStores', 'StoreController@getAllStores');

// Destaques - OK
Route::get('/store/featured', 'FeaturedController@featuredStores');
Route::get('/product/featured', 'FeaturedController@featuredProducts');

// Lojas - Upload de imagem
Route::post('/store/uploadNewLogo', 'StoreController@uploadStoreLogo');
Route::post('/store/uploadNewBanner', 'StoreController@uploadBannerImage');

// Pedidos - OK
Route::get('/order/set', 'OrderController@setOrder');
Route::post('/order/setDeliveryMethods', 'DeliveryController@setDelivery');
Route::post('/order/pegarPedido', 'MoipController@getOrder');

// Sessão - Produtos
Route::post('/user/login', 'SessionController@login');
Route::get('/user/logout', 'SessionController@logout');
Route::get('/user/session', 'SessionController@checkSession');
Route::get('/user/loggedUser', 'SessionController@get_infos');

Route::get('/product/favorites', 'FavoritesController@getFavorites');
Route::post('/product/getForEdit', 'ProductController@getProductForEdition');
Route::post('/product/loggedProducts', 'SessionController@logged_products');

// Sessão - Lojas
Route::get('/store/checkStore', 'SessionController@isStoreCreated');
Route::get('/store/loggedStore', 'SessionController@logged_store');
Route::get('/store/statusStore', 'SessionController@status_store');

Route::get('/store/solds', 'StoreController@numberOfSolds'); // Retorna o número de produtos vendidos
Route::get('/store/active', 'StoreController@numberOfActive'); // Retorna o número de produtos ativos
Route::get('/store/noActive', 'StoreController@numberOfNonActive'); // Retorna o número de produtos não ativos

Route::get('/evaluations/get', 'EvaluationController@getMyEvaluations');

// Produtos - OK
Route::post('/product/add', 'ProductController@newProduct');
Route::post('/product/update', 'ProductController@updateProduct');
Route::post('/product/toggleStatus', 'ProductController@toggleStatus');
Route::post('/product/get', 'ProductController@getProduct');
Route::post('/product/getAll', 'ProductController@getProducts');
Route::post('/product/numberOfAll', 'ProductController@getPageCount');

// Produtos - Upload de Imagens
Route::post('/product/profile/add', 'UploadController@uploadProductProfile');
Route::post('/product/extra/add', 'UploadController@uploadProductExtra');
Route::post('/product/extra/remove', 'UploadController@deleteProductExtra');

// Perguntas - OK
Route::post('/question/ask', 'QuestionController@ask');
Route::post('/question/answer', 'QuestionController@answer');
Route::post('/question/getQuestions', 'QuestionController@getQuestions');
Route::post('/question/getQuestion', 'QuestionController@getQuestion');
Route::any('/question/getActiveQuestions', 'QuestionController@getActiveQuestions');

// Categorias - OK
Route::post('/categories/newCategory', 'CategoryController@newCategory');
Route::get('/categories/getCategories', 'CategoryController@getCategories');

// Marcas - OK
Route::post('/brands/newBrand', 'BrandController@newBrand');
Route::get('/brands/getBrands', 'BrandController@getBrands');

// Fale Conosco - OK
Route::post('/contact/contactUs', 'ContactController@contact_us');

// Endereços - OK
Route::post('/address/get', 'CorreiosController@getAddress');
Route::post('/address/getForSignup', 'CorreiosController@getAddressForSignup');

// Pesquisa - OK
Route::post('/search', 'SearchController@search');

// Mensagens - OK
Route::any('/message/sent', 'MessageController@sent');
Route::any('/message/received', 'MessageController@received');
Route::post('/message/get', 'MessageController@getMessage');
Route::post('/message/send', 'MessageController@write');
Route::post('/message/answer', 'MessageController@answer');
Route::post('/message/erase', 'MessageController@erase');
