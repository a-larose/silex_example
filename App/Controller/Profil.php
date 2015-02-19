<?php

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class Profil implements ControllerProviderInterface
{
  
  public function connect(Application $app)
  {
    $controllers = $app['controllers_factory'];

    $controllers->match('/', 'App\Controller\Profil::logView')->bind('log_view');
    $controllers->match('/register', 'App\Controller\Profil::register')->bind('register');
    return $controllers;
  }

  public function logView(Request $request, Application $app)
  {
    return $app['twig']->render('register.html', 
      array(
        'error' => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username')
        ));
  }

  public function register(Request $request, Application $app)
  {
    $email = trim($request->get('email'));
    $password = trim($request->get('password'));
    $username = trim($request->get('username'));
    $role = intval($request->get('role'));

    $encoder = new MessageDigestPasswordEncoder();


    if (empty($email) || empty($password) || empty($username))
    {
      return $app->redirect($request->getBasePath().'/profile/login');
    }

    $user = array(
      'username' => $username,
      'email' => $email,
      'password' => $encoder->encodePassword($password, $username),
      'role' => $role == 1 ? 'ROLE_USER' : 'ROLE_ADMIN',
      'creation_date' => date('Y-m-d H:i:s')
      );

    $app['db']->insert('user', $user);
    
    return $app->redirect($request->getBasePath().'/');
  }

}