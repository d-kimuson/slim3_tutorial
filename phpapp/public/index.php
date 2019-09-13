<?php
require '../vendor/autoload.php';

$app = new Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
  ]
]);
$container = $app->getContainer();
$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig('templates/');
  return $view;
};

$users = [
  [
    'name' => "Taro",
    'age' => 20,
    'passed' => "taro20",
  ],
  [
    'name' => "Jiro",
    'age' => 15,
    'passed' => "jiro15",
  ],
  [
    'name' => "Toshiro",
    'age' => 12,
    'passed' => "toshi12",
  ],
];

$app->get('/', function($request, $response, $args) {
  $response->write("Welcome My APP");
  $response->write("My App 2nd");
});

$app->get('/index', function($request, $response, $args) {
  return $this->view->render($response, 'index.html');
});

$app->get('/users', function($request, $response, $args) use ($users) {
  return $response->withJson($users);
});

$app->get('/users/search', function($request, $response, $args) use ($users) {
  $name = $request->getQueryParams()['name'];
  $results = array();
  foreach ($users as $user) {
    if ($user['name'] == $name) {
      array_push($results, $user);
    }
  }
  return $response->withJson($results);
});

$app->run()
?>
