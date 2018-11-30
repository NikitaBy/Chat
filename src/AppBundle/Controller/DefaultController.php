<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        $config = [
            'user' => $user->getId(),
            'chatRoom' => $user->getChatRooms()[0]->getId()
        ];
        return $this->render('@App/chat.html.twig', ['config'=>$config]);
    }
}
