<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Idy\Idea\Infrastructure\SqlIdeaRepository;
use Idy\Idea\Infrastructure\SqlRatingRepository;
use Idy\Idea\Infrastructure\SmtpMailRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$di['voltServiceMail'] = function($view) use ($di) {

    $config = $di->get('config');

    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
    if (!is_dir($config->mail->cacheDir)) {
        mkdir($config->mail->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT' ? true : false;

    $volt->setOptions(array(
        "compiledPath" => $config->mail->cacheDir,
        "compiledExtension" => ".compiled",
        "compileAlways" => $compileAlways
    ));
    return $volt;
};

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$di['db'] = function () use ($di) {

    $config = $di->get('config');

    $dbAdapter = $config->database->adapter;

    return new $dbAdapter([
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ]);
};

$di['smtp_mailer_client'] = function () use ($di) {
    $config = $di->get('config');
    $driver = $config->mail->driver;
    $host = $config->mail->smtp->server;
    $port = $config->mail->smtp->port;
    $username = $config->mail->smtp->username;
    $password = $config->mail->smtp->password;

//    $mail = new $driver;
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->Port = (int)$port;
    $mail->SMTPAuth = isset($username);
    $mail->Username = $username;
    $mail->Password = $password;
    return $mail;
};

$di->setShared('sql_idea_repository', function() use ($di) {
    $repo = new SqlIdeaRepository($di);

    return $repo;
});

$di->setShared('sql_rating_repository', function() use ($di) {
    $repo = new SqlRatingRepository($di);

    return $repo;
});

$di->setShared('smtp_mail_repository', function() use ($di) {
    $config = $di->get('config');

    $senderName = $config->mail->fromName;
    $senderMail = $config->mail->fromEmail;

    $repo = new SmtpMailRepository($di, $senderName, $senderMail);

    return $repo;
});

