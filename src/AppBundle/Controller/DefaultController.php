<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Asin;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    protected function getAsins()
    {
        $user = $this->getUser();
        if (method_exists($user, 'getId')) {
            return $this->getDoctrine()->getRepository(Asin::class)->findBy(['fosUserId' => $user->getId()]);
        };
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'asins' => $this->getAsins() ?? []
        ]);
    }
}
