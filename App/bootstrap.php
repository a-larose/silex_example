<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Silex\Application\SecurityTrait;

ini_set('date.timezone', 'Europe/Brussels');

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->add('App', dirname(__DIR__));

require_once __DIR__.'/../config/config.php';

$app = new Silex\Application();
$app['debug'] = true;

// Service register

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => $db_config
  ));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../App/views/',
  ));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
  'security.firewalls' => array(
    'open' => array(
      'pattern' => '^/login$'
    ),
    'secured' => array(
      'pattern' => '^.*$',
      'anonymous' => true,
      'form' => array('login_path' => '/login'),
      'users' => $app->share(function () use ($app) {
        return new App\Controller\Security\UserProvider($app['db']);
      }),
      'logout' => array('logout_path' => '/logout')
    ),
  ),
));

// Route
$app->mount('/', new App\Controller\Home());
$app->mount('/login', new App\Controller\Profil());

$app->run();