<?php

namespace Idy\Idea\Controllers\Web;

use Idy\Idea\Application\CreateNewIdeaRequest;
use Idy\Idea\Application\CreateNewIdeaService;

use Phalcon\Mvc\Controller;

class IdeaController extends Controller
{
    private $CreateNewIdeaService;
    private $session;

    public function onConstruct()
    {
        $this->session = $this->di->getShared('session');

        $ideaRepository = $this->di->getShared('sql_idea_repository');
        $this->CreateNewIdeaService = new CreateNewIdeaService($ideaRepository);
    }

    public function indexAction()
    {
        return $this->view->pick('home');
    }

    public function addAction()
    {
        if($this->request->isPost()) {
            $ideaTitle = $this->request->getPost('idea_title');
            $ideaDescription = $this->request->getPost('idea_description');
            $authorName = $this->request->getPost('author_name');
            $authorEmail = $this->request->getPost('author_email');

            $idea = new CreateNewIdeaRequest($ideaTitle, $ideaDescription, $authorName, $authorEmail, 0);
            // print_r($idea);

            $res = $this->CreateNewIdeaService->execute($idea);
            
            $this->session->set('popup_status', 'success');
            $this->session->set('popup_message', "{$res->idea->title()} has been created"); 

            $this->view->disable();
            return $this->response->redirect('idea');
        }
        return $this->view->pick('add');
    }

    public function voteAction()
    {

    }

    public function rateAction()
    {
        
    }

}