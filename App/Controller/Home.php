<?php

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Home implements ControllerProviderInterface
{
  
  public function connect(Application $app)
  {
    $controllers = $app['controllers_factory'];

    $controllers->match('/', 'App\Controller\Home::index')->bind('index.index');
    $controllers->match('/{id}', 'App\Controller\Home::experienceById')->assert('id', '\d+')->bind('experience');
    $controllers->match('/experience/add', 'App\Controller\Home::addExperience')->bind('experience.add');
    return $controllers;
  }

  public function index(Application $app)
  {
  	$stmt = $app['db']->executeQuery('
     SELECT id, title, content, creation_date
     FROM experience
     ORDER BY creation_date DESC
    ');

    $token = $app['security']->getToken();
    if (NULL !== $token)
      $user = $token->getUser();
    else
      $user = NULL;

    $experiences = $stmt->fetchAll(\PDO::FETCH_ASSOC);

  	return $app['twig']->render('home.html', array('experiences' => $experiences, 'user' => $user));
  }

  public function experienceById(Application $app, $id)
  {
  	$experiences = $app['db']->fetchAssoc('
     SELECT id, title, content, creation_date
     FROM experience
     WHERE id = ?
    ', array($id));

    if (empty($experiences))
    {
      $app['session']->getFlashBag()->add('error', 'That experience does not exist');
      return $app->redirect($app['url_generator']->generate('index.index'));
    }

  	return $app['twig']->render('single_experience.html', array('experience' => $experiences));
  }

  public function experienceByName(Application $app, $title)
  {
    $experiences = $app['db']->fetchAssoc('
     SELECT id, title, content, creation_date
     FROM experience
     WHERE title = "?"
    ', array($title));

    if (empty($experiences))
    {
      $app['session']->getFlashBag()->add('error', 'That experience does not exist');
      return $app->redirect($app['url_generator']->generate('index.index'));
    }

    return $app['twig']->render('single_experience.html', array('experience' => $experiences));
  }

  public function addExperience(Request $request, Application $app)
  {
    $title = trim($request->get('title'));
    $content = trim($request->get('content'));

    if (empty($title) || empty($content))
    {
      $app['session']->getFlashBag()->add('error', 'Missing parameters');
      return $app->redirect($app['url_generator']->generate('index.index'));
    }

    $experience = array(
      'title' => $title,
      'content' => $content,
      'creation_date' => date("Y-m-d H:i:s")
      );

    $app['db']->insert('experience', $experience);
    
    return $app->redirect($request->getBasePath().'/');
  }

}