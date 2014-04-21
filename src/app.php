<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/db-connect.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Setup the application
$app = new Application();
$app['debug'] = true;
$app->register(new TwigServiceProvider, array(
    'twig.path' => __DIR__ . '/templates',
));

// Setup the database
$app['db.table'] = DB_TABLE;
$app['db.dsn'] = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
$app['db'] = $app->share(function ($app) {
    return new PDO($app['db.dsn'], DB_USER, DB_PASSWORD);
});

$app->error(function (\PDOException $e, $code) use ($app) {
  $alert = array('type' => 'error', 'message' => 'Can\'t connect to database. If you launched this application with AWS Elastic Beanstalk, please go to your Environment\'s Configuration page in the AWS Management Console and click \'create a new RDS database\' in the Data Tier section.');
  return $app['twig']->render('index.twig', array(
      'alert'    => $alert
  ));
});

// Handle the index page
$app->match('/', function () use ($app) {
    $query = $app['db']->prepare("SELECT message, author FROM {$app['db.table']}");
    $thoughts = $query->execute() ? $query->fetchAll(PDO::FETCH_ASSOC) : array();

    return $app['twig']->render('index.twig', array(
        'title'    => 'Your Thoughts',
        'thoughts' => $thoughts,
    ));
});

// Handle the add page
$app->match('/add', function (Request $request) use ($app) {
    $alert = null;
    // If the form was submitted, process the input
    if ('POST' == $request->getMethod()) {
        try {
            // Make sure the photo was uploaded without error
            $message = $request->request->get('thoughtMessage');
            $author = $request->request->get('thoughtAuthor');
            if ($message && $author && strlen($author) < 64) {
                // Save the thought record to the database
                $sql = "INSERT INTO {$app['db.table']} (message, author) VALUES (:message, :author)";
                $query = $app['db']->prepare($sql);
                $data = array(
                    ':message' => $message,
                    ':author'  => $author,
                );
                if (!$query->execute($data)) {
                    throw new \RuntimeException('Saving your thought to the database failed.');
                }
            } else {
                throw new \InvalidArgumentException('Sorry, The format of your thought was not valid.');
            }

            // Display a success message
            $alert = array('type' => 'success', 'message' => 'Thank you for sharing your thought.');
        } catch (Exception $e) {
            // Display an error message
            $alert = array('type' => 'error', 'message' => $e->getMessage());
        }
    }

    return $app['twig']->render('add.twig', array(
        'title' => 'Share Your Thought!',
        'alert' => $alert,
    ));
});

$app->run();
