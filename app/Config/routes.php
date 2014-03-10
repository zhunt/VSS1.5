<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	


       
        
        Router::connect(
                '/company/:slug' , 
                array('controller' => 'venues', 'action' => 'view'),
                array('slug' => '[0-9a-zA-Z\-_]{3,60}')
                );

        Router::connect(
                '/company/view_map/:slug' , 
                array('controller' => 'venues', 'action' => 'view_map'),
                array('slug' => '[0-9a-zA-Z\-_]{3,60}')
                );
        
        Router::connect(
            '/city',
            array('controller' => 'cities', 'action' => 'index',)
        );      
        
        Router::connect(
            '/bookstore-features',
            array('controller' => 'venue_features', 'action' => 'index', 'product')
        );          

        Router::connect(
            '/bookstore-services',
            array('controller' => 'venue_features', 'action' => 'index', 'services')
        ); 
        
        Router::connect(
                '/city/:slug' , 
                array('controller' => 'cities', 'action' => 'view' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,50}')
                );   
        
       Router::connect(
                '/product/:slug/*' , 
                array('controller' => 'venue_features', 'action' => 'products_index' ),
                array( 'slug' => '[0-9a-zA-Z\-_]{3,50}', 'pass' => array('product' => '[0-9a-zA-Z\-_]{3,50}' ) )
                
                ); 
				
        Router::connect(
            '/province/:slug',
            array('controller' => 'provinces', 'action' => 'view'),
            array('slug' => '[0-9a-zA-Z\-_]{3,50}')    
        );  
		
       
       Router::connect(
                '/search/*' , 
                array('controller' => 'venue_features', 'action' => 'search' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,50}')
                ); 
       
       
       // /posts/venues/tequila-bookworm-on-queen-west/
       Router::connect(
                '/posts/:slug' , 
                array('controller' => 'posts', 'action' => 'view' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,100}')
                );        

       Router::connect(
                '/posts/:slug' , 
                array('controller' => 'posts', 'action' => 'view' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,100}')
                );  
       
       // http://127.0.0.1:8085/feed/city:toronto
       Router::connect(
                '/posts/search/*' , 
                array('controller' => 'post_categories', 'action' => 'search' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,50}')
                );    
       
       
     // custom root for old-style venue links  
    // App::import('Lib', 'routes/SlugRoute');
	 
	 App::uses('SlugRoute', 'Route');
	 
     //Router::connect('/:slug', array('controller' => 'venues', 'action' => 'view_redirect'), array('routeClass' => 'SlugRoute') );
	 
	 Router::connect(
     '/:slug',
     array('controller' => 'venues', 'action' => 'view_redirect'),
     array('routeClass' => 'SlugRoute')
	);

      
       
        // sitemaps  
        Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index'));
        Router::connect('/sitemap/:action/*', array('controller' => 'sitemaps'));

        //Router::parseExtensions();
    
       
       //http://127.0.0.1:8086/venue_features/products_index/pc_parts/page:5/city:new_york
/*
       Router::connect(
                '/product/:slug/:page' , 
                array('controller' => 'venue_features', 'action' => 'products_index' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,50}')
                ); 
       Router::connect(
                '/product/products_index/:slug/:page' , 
                array('controller' => 'venue_features', 'action' => 'products_index' ),
                array('slug' => '[0-9a-zA-Z\-_]{3,50}')
                );
       
*/
       /*
       Router::connect('/product/:page', 
               array('controller' => 'venue_features', 'action' => 'products_index')
              // array('slug' => '[0-9a-zA-Z\-_]{3,50}')
               );
         */       
                        

        Router::connect('/rss/newest', array('controller' => 'venues', 'action' => 'index' ));
        Router::connect('/rss/newest_posts', array('controller' => 'posts', 'action' => 'index' ));
        
        Router::connect('/', array('controller' => 'landings', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));      
        
        
        Router::mapResources('api');
        
        Router::parseExtensions();   
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
