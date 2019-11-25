<?php

namespace Idy\Idea\Controllers\Web;

use Phalcon\Mvc\Controller;
use Idy\Idea\Application\CreateNewIdeaRequest;
use Idy\Idea\Application\CreateNewIdeaService;
use Idy\Idea\Application\ViewAllIdeasService;

class IdeaController extends Controller
{
    private $session;
    private $createNewIdeaService;
    private $viewAllIdeasService;

    public function onConstruct()
    {
        $this->session = $this->di->getShared('session');

        $ideaRepository = $this->di->getShared('sql_idea_repository');
        // $ratingRepository = $this->di->getShared('sql_rating_repository');
        $this->createNewIdeaService = new CreateNewIdeaService($ideaRepository);
        $this->viewAllIdeasService = new ViewAllIdeasService($ideaRepository);

    }

    public function indexAction()
    {
        $ideas = $this->viewAllIdeasService->execute();
        // print_r($ideas); exit;
        $this->view->setVars([
            'popup' => $this->session->get('popop_status'),
            'popupMessage' => $this->session->get('popup_message'),
            'votedIdeas' => $votedIdeasByUser,
            'ideas' => $ideas
        ]);
        $this->session->remove('popup_status');
        $this->session->remove('popup_message');

        return $this->view->pick('home');
    }

    public function addAction()
    {
        if($this->request->isPost()) {
            $ideaTitle = $this->request->getPost('idea_title');
            $ideaDescription = $this->request->getPost('idea_description');
            $authorName = $this->request->getPost('author_name');
            $authorEmail = $this->request->getPost('author_email');

            $idea = new CreateNewIdeaRequest($ideaTitle, $ideaDescription, $authorName, $authorEmail);
            // print_r($idea);

            $res = $this->createNewIdeaService->execute($idea);
            
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