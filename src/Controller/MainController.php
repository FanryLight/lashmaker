<?php

namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/sendContacts")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sendContactsAction(Request $request) {
        $name = $request->get('name');
        $phone = $request->get('phone');
        if ($name && $phone) {
            $message = (new \Swift_Message('Запись на процедуру'))
                ->setFrom('medoeva@brights.com.ua')
                ->setTo('fanrylight@gmail.com')
                ->setBody(
                    $this->renderView(
                        'email.html.twig',
                        [
                            'name' => $name,
                            'phone' => $phone
                        ]
                    ),
                    'text/plain'
                );
            $this->get('mailer')->send($message);
        }
        return new JsonResponse();
    }
}