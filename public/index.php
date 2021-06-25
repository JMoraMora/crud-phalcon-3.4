
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs([
  APP_PATH . '/controllers/',
  APP_PATH . '/models/'
]);
    
$loader->register();

// Create a DI
$di = new FactoryDefault();

$di->set('view', function() {
  $view = new View();
  $view->setViewsDir(APP_PATH . '/views/');
  return $view;
});

$di->set('url', function() {
  $url = new UrlProvider();
  $url->setBaseUri('/');
  return $url;
});

$di->set('db', function() {
  return new DbAdapter([
    "host"     => "localhost",
    "username" => "root",
    "password" => "280510jt",
    "dbname"   => "tutophalcon"
  ]);
});

$application = new Application($di);

try {
  // Handle the request
  $response = $application->handle();
  $response->send();
} catch (\Exception $e) {
  echo "Exception: ", $e->getMessage();
}



// // Setup a base URI so that all generated URIs include the "tutorial" folder
// $di['url'] = function() {
//     $url = new UrlProvider();
//     $url->setBaseUri('/');
//     return $url;
// };

// // Set the database service
// $di['db'] = function() {
//     return new DbAdapter(array(
//         "host"     => "127.0.0.1",
//         "username" => "root",
//         "password" => "secret",
//         "dbname"   => "tutorial1"
//     ));
// };

// // Handle the request
// try {
//     $application = new Application($di);
//     echo $application->handle()->getContent();
// } catch (Exception $e) {
//      echo "Exception: ", $e->getMessage();
// }