(function () {
   'use strict';

   angular.module ('app')

   .config (config);

   function config ($stateProvider,$pathToProvider, $locationProvider, $urlRouterProvider){
     // Beautify URL
    	$locationProvider.html5Mode(true);

   	/*Constant paths to public sub-folders*/
    	$pathToProvider
   		.addPath({
   			name:"jsFolder",
   			folder:"js"
   		})
   		.addPath({
   			name:"directivesFolder",
   			folder:"directives",
   			parent:"jsFolder"
   		})
   		.addPath({
   			name:"viewsFolder",
   			folder:"views"
   		})
      .addPath({
        name:"mainFolder",
        folder:"main",
        parent:"viewsFolder"
      })
      .addPath({
        name:"signupFolder",
        folder:"signup",
        parent:"viewsFolder"
      })
      .addPath({
        name:"checkoutFolder",
        folder:"checkout",
        parent:"viewsFolder"
      })
      .addPath({
        name:"panelFolder",
        folder:"painel",
        parent:"viewsFolder"
      })
      .addPath({
        name:"experimentalFolder",
        folder:"experimental",
        parent:"viewsFolder"
      })
   		.addPath({
   			name:"imgFolder",
   			folder:"img"
   		});

    /*Getting the paths defined by pathToProvider*/
   	var pathTo = $pathToProvider.$get();

   	/*UI-Router states*/

    $urlRouterProvider.otherwise('/');

    // Main pages
   	$stateProvider
   	.state({
   		name: 'root',
   		templateUrl: pathTo.mainFolder+'root.php', /*TESTING NEW ROOT PAGE*/
   		controller: 'RootController as vm'
   	})
    // Página inicial
    .state({
      name: 'root.home',
      url: '/',
      templateUrl: pathTo.mainFolder+'home.php',
      controller: 'HomeController as vm'
    })
    // Cadastro
    .state({
      name: 'root.signup',
      url: '/cadastrar',
      templateUrl: pathTo.signupFolder+'signup.php',
      controller: 'SignupController as vm'
    })
    // Debug section TODO: REMOVER
    .state({
      name: 'root.debug',
      url: '/debug',
      templateUrl: pathTo.mainFolder+'debug.php',
      controller: 'DebugController as vm'
    })
    // Ativar conta
    .state({
      name: 'root.activate',
      url: '/ativarconta/:token',
      templateUrl: pathTo.mainFolder+'activate.php',
      controller: 'ActivateController as vm'
    })
    // Moip Externo
    .state({
      name: 'root.linkMoip',
      url: '/getmoip/?:code',
      templateUrl: pathTo.mainFolder+'moip.php',
      controller: 'TerceirosController as vm'
    })
    // FAQs
    .state({
      name: 'root.faq',
      url: '/faq',
      templateUrl: pathTo.mainFolder+'faq.php'
    })
    // Ajuda
    .state({
      name: 'root.help',
      url: '/ajuda',
      templateUrl: pathTo.mainFolder+'help.php',
      controller: 'HelpController as vm'
    })
    // Pesquisa
    .state({
      name: 'root.search',
      url: '/pesquisa/{pesquisa}',
      templateUrl: pathTo.mainFolder+'search.php',
      controller: 'SearchController as vm'
    })
    .state({
      name: 'root.sell',
      url: '/querovender',
      templateUrl: pathTo.mainFolder+'wantsell.php'
    })
    .state({
      name: 'root.buy',
      url: '/querocomprar',
      templateUrl: pathTo.mainFolder+'wantbuy.php'
    })
    // Ver produto X
    .state({
      name: 'root.product',
      url: '/produto/:unique_id',
      templateUrl: pathTo.mainFolder+'view_product.php',
      controller: 'ProductController as vm'
    })
    // Ver loja X
   	.state({
   		name: 'root.store',
   		url: '/loja/:unique_id',
   		templateUrl: pathTo.mainFolder+'view_store.php',
   		controller: 'ViewStoreController as vm'
   	})
    // Fale conosco
    .state({
      name: 'root.contact',
      url: '/faleconosco',
      templateUrl: pathTo.mainFolder+'contact.php',
      controller: 'HelpController as vm'
    })
    // Lojas
    .state({
      name:'root.stores',
      url: '/lojas',
      templateUrl: pathTo.mainFolder+'stores.php',
      controller: 'StoresController as vm'
    })
    // Ver produtos por filtro
   	.state({
   		name: 'root.showProducts',
   		url: '/produtos/:category_id',
   		templateUrl: pathTo.mainFolder+'products.php',
   		controller: 'ShowProductsController as vm'
   	})
    // Procura produtos TODO: Verifica necessidade
   	.state({
   		name: 'root.searchProducts',
   		url: '/buscar/:search',
   		templateUrl: pathTo.viewsFolder+'searchProducts.php',
   		controller: 'SearchProductsController as vm'
   	})
    // Páginas do painel
    .state({
   		name: 'root.panel',
   		templateUrl: pathTo.panelFolder+'panel.php',
   		controller: 'PanelController as vm'
   	})
    // Dashboard - painel
    .state({
      name: 'root.panel.dashboard',
      url: '/painel',
      templateUrl: pathTo.panelFolder+'panelDashboard.php',
      controller: 'PanelDashboardController as vm'
    })
    // Dashboard - favoritos
   	.state({
      name: 'root.panel.favorites',
      url: '/favoritos',
      templateUrl: pathTo.panelFolder+'panelFavorites.php',
      controller:'PanelFavoritesController as vm'
    })
    // Saque - painel
    .state({
      name: 'root.panel.withdraw',
      url: '/sacar',
      templateUrl: pathTo.panelFolder+'panelWithdraw.php',
      controller: 'PanelWithDrawController as vm'
    })
    // Produtos - painel
   	.state({
   		name: 'root.panel.products',
      url: '/produtos',
   		templateUrl: pathTo.panelFolder+'panelProducts.php',
   		controller: 'PanelProductsController as vm'
   	})
    // Produtos - Criar - painel
    .state({
      name: 'root.create_product',
      url: '/criarproduto',
      templateUrl: pathTo.panelFolder+'panelCreateProduct.php',
      controller: 'CreateProductController as vm'
    })
    // Produtos - Editar - painel TODO: Mudar de nome para ID unico
    .state({
      name: 'root.panel.edit_product',
      url: '/editarproduto/:unique_id',
      templateUrl: pathTo.panelFolder+'panelEditProduct.php',
      controller: 'EditProductController as vm'
    })
    // Mensagens - painel
    .state({
      name: 'root.panel.messagens',
      url: '/mensagens',
      templateUrl: pathTo.panelFolder+'messages/panelMessagens.php',
      controller: 'PanelMessagesController as vm'
    })
    // Minhas Vendas - painel
   	.state({
      name: 'root.panel.sales',
      url: '/vendas',
      templateUrl: pathTo.panelFolder + 'orders/minhasvendas.php',
      controller :'PanelSalesController as vm'
    })
    // Minhas compras - painel
    .state({
      name:'root.panel.shopping',
      url: '/compras',
      templateUrl: pathTo.panelFolder + 'orders/minhascompras.php',
      controller:'PanelShoppingController as vm'
    })
    // Ver Compra x
    .state({
      name:'root.panel.buy',
      url: '/compra/:unique_id',
      templateUrl: pathTo.panelFolder + 'orders/compra.php',
      controller: 'PanelShopController as vm'
    })
    // Ver Venda x
    .state({
      name: 'root.panel.sale',
      url: '/venda/:unique_id',
      templateUrl: pathTo.panelFolder + 'orders/venda.php',
      controller: 'PanelSaleController as vm'
    })
    // Perguntas - painel
    .state({
      name: 'root.panel.questions',
      url: '/perguntas',
      templateUrl: pathTo.panelFolder + 'panelQuestions.php',
      controller: 'PanelQuestionController as vm'
    })
    // Responder Perguntas - painel TODO: Estudar possibilidade de responder a mensagem na leitura
    .state({
      name: 'root.panel.answer',
      url: '/responder/:unique_id',
      templateUrl: pathTo.panelFolder + 'panelAnswer.php',
      controller: 'PanelAnswerController as vm'
    })
    // Minha conta - painel
    .state({
   		name: 'root.panel.myaccount',
      url: '/minhaconta',
   		templateUrl: pathTo.panelFolder+'panelMyAccount.php',
   		controller: 'MyAccountController as vm'
   	})
    // Loja - painel
   	.state({
   		name: 'root.panel.store',
      url: '/minhaloja',
   		templateUrl: pathTo.panelFolder+'store/panelStore.php',
   		controller: 'PanelStoreController as vm'
   	})
    // Minha loja
    .state({
      name: 'root.panel.store.view',
      url: '/dashboard',
      templateUrl: pathTo.panelFolder+'store/panelViewStore.php',
      controller: 'PanelViewStoreController as vm'
    })
    // Criar loja
    .state({
      name: 'root.panel.store.create',
      url: '/criar',
      templateUrl: pathTo.panelFolder+'store/panelCreateStore.php',
      controller: 'PanelCreateStoreController as vm'
    })
    // Alterar Loja
    .state({
      name: 'root.panel.store.update',
      url: '/editar',
      templateUrl: pathTo.panelFolder+'store/panelEditStore.php',
      controller: 'PanelEditStoreController as vm'
    })
    // Checkout
    .state({
      name: 'root.checkout',
      url: '/checkout',
      templateUrl: pathTo.checkoutFolder+'main.php',
      controller: 'CheckoutMainController as vm'
    })
    // Sacolinha - Checkout
    .state({
      name: 'root.checkout.cart',
      url: '/sacolinha',
      templateUrl: pathTo.checkoutFolder+'bag.php',
      controller: 'CheckoutCartController as vm'
    })
    // Entregas - Checkout
    .state({
      name: 'root.checkout.info',
      url: '/entrega',
      templateUrl: pathTo.checkoutFolder+'delivery.php',
      controller: 'CheckoutDeliveryController as vm'
    })
    // Revise o pedido
    .state({
      name: 'root.checkout.review',
      url: '/revisando',
      templateUrl: pathTo.checkoutFolder+'review.php',
      controller: 'CheckoutReviewController as vm'
    })
    // Pagamentos - Checkout
    .state({
      name: 'root.checkout.payment',
      url: '/formadepagamento',
      templateUrl: pathTo.checkoutFolder+'payment.php',
      controller: 'CheckoutPaymentController as vm'
    })
    .state({
      name: 'root.checkout.success',
      url: '/sucesso',
      templateUrl: pathTo.checkoutFolder+'success.php',
      controller: 'CheckoutSuccessController as vm'
    })
    // Painel Administrativo
    .state({
      name: 'root.admin',
      url: '/admin',
      templateUrl: pathTo.viewsFolder+'admin/admin.php',
      controller: 'PanelAdminController as vm'
    })
    .state({
      name: 'root.admin.users',
      url: '/usuarios',
      templateUrl: pathTo.viewsFolder+'admin/users.php',
      controller: 'PanelAdminController as vm'
    })
    .state({
      name:'root.admin.products',
      url:'/produtos',
      templateUrl: pathTo.viewsFolder+'admin/products.php',
      controller: 'PanelAdminController as vm'
    })
    .state({
      name:'root.admin.stores',
      url:'/lojas',
      templateUrl: pathTo.viewsFolder+'admin/stores.php',
      controller: 'PanelAdminController as vm'
    })
    .state({
      name:'root.admin.shopping',
      url:'/compras',
      templateUrl: pathTo.viewsFolder+'admin/shopping.php',
      controller: 'PanelAdminController as vm'
    })
    .state({
      name:'root.admin.help',
      url:'/ajuda',
      templateUrl: pathTo.viewsFolder+'admin/help.php',
      controller: 'PanelAdminController as vm'
    })
    .state({
      name:'root.admin.contact',
      url:'/contato',
      templateUrl: pathTo.viewsFolder+'admin/contact.php',
      controller: 'PanelAdminController as vm'
    })
    ;
  }
 })();
