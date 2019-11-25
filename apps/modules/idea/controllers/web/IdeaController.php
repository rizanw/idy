<?php

namespace Idy\Idea\Controllers\Web;

use Phalcon\Mvc\Controller;
use Idy\Idea\Application\CreateNewIdeaRequest;
use Idy\Idea\Application\CreateNewIdeaService;
use Idy\Idea\Application\ViewAllIdeasService;
use Idy\Idea\Application\ViewIdeaRequest;
use Idy\Idea\Application\ViewIdeaService;
use Idy\Idea\Application\RateIdeaRequest;
use Idy\Idea\Application\RateIdeaService;
use Idy\Idea\Application\VoteIdeaRequest;
use Idy\Idea\Application\VoteIdeaService;
use Idy\Idea\Application\SendRatingNotificationService;

class IdeaController extends Controller
{
    private $session;
    private $createNewIdeaService;
    private $viewAllIdeasService;
    private $viewIdeaService;
    private $voteIdeaService;
    private $sendRatingNotificationService;

    public function onConstruct()
    {
        $this->session = $this->di->getShared('session');
        $ideaRepository = $this->di->getShared('sql_idea_repository');
        $ratingRepository = $this->di->getShared('sql_rating_repository');
        $mailRepository = $this->di->getShared('smtp_mail_repository');
        $this->createNewIdeaService = new CreateNewIdeaService($ideaRepository);
        $this->viewAllIdeasService = new ViewAllIdeasService($ideaRepository, $ratingRepository);
        $this->viewIdeaService = new ViewIdeaService($ideaRepository, $ratingRepository);
        $this->rateIdeaService = new RateIdeaService($ideaRepository, $ratingRepository);
        $this->voteIdeaService = new VoteIdeaService($ideaRepository);

        $this->sendRatingNotificationService = new SendRatingNotificationService($mailRepository, $ideaRepository);
    }

    public function indexAction()
    {
        $ideas = $this->viewAllIdeasService->execute();
        $votedIdeasByUser = empty($this->session->get('votedIdeas')) ? array() : $this->session->get('votedIdeas');
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
        if ($this->request->isPost()) {
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

    public function rateAction($ideaId)
    {

        if (!isset($ideaId)) {
            return $this->response->redirect('idea');
        }
        if ($this->request->isPost()) {
            $ratingUser = $this->request->getPost('name');
            $ratingValue = $this->request->getPost('rating');
            $rateIdeaRequest = new RateIdeaRequest($ideaId, $ratingUser, $ratingValue);
            $this->rateIdeaService->execute($rateIdeaRequest);
            $this->sendRatingNotificationService->execute($ideaId, $ratingValue);

            return $this->response->redirect("idea/rate/{$ideaId}");
        }
        $viewIdeaRequest = new ViewIdeaRequest($ideaId);

        $idea = $this->viewIdeaService->execute($viewIdeaRequest);
        $this->view->setVars([
            'idea' => $idea
        ]);
        return $this->view->pick('rate');
    }

    public function voteAction($ideaId)
    {
        $ideaIdHasAlreadyVotedByUser = empty($this->session->get('votedIdeas')) ? array() : $this->session->get('votedIdeas');
        if (in_array($ideaId, $ideaIdHasAlreadyVotedByUser)) {
            return $this->response->redirect('idea');
        }

        $voteRequest = new VoteIdeaRequest($ideaId);
        $idea = $this->voteIdeaService->execute($voteRequest);

        $this->session->set('popup_status', 'success');
        $this->session->set('popup_message', "Thanks for voting {$idea->title()} ");
        array_push($ideaIdHasAlreadyVotedByUser, $ideaId);
        $this->session->set('votedIdeas', $ideaIdHasAlreadyVotedByUser);
        $this->response->redirect('idea');
    }


}