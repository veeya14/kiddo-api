<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('api/vocabularies', 'ApiController::vocabularies');
$routes->get('api/rewards', 'ApiController::rewards');
$routes->get('api/videos', 'ApiController::videos');

$routes->get('api/categories', 'ApiController::categories');
$routes->get('api/words', 'ApiController::words');
$routes->get('api/objectwords', 'ApiController::objectWords');

$routes->get('/api/animals-quiz', 'ApiController::animalQuiz');
$routes->get('/api/fruits-quiz', 'ApiController::fruitQuiz');
$routes->get('/api/objects-quiz', 'ApiController::objectQuiz');
$routes->get('/api/family-quiz', 'ApiController::familyQuiz');
$routes->get('/api/greeting-quiz', 'ApiController::greetingQuiz');
$routes->get('/api/colour-quiz', 'ApiController::colourQuiz');

$routes->post('api/create-user', 'ApiController::createUser');
$routes->post('/api/save-quiz-result', 'ApiController::saveQuizResult');
$routes->post('api/unlock-reward', 'ApiController::unlockReward');
