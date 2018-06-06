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
        $response = 0;
        if ($name && $phone) {
            $message = (new \Swift_Message('Запись на процедуру'))
                ->setFrom(['fanrylight@gmail.com' => 'John Doe'])
                ->setTo('medoeva@brights.com.ua')
                ->setBody(
                    "Имя: $name\r\nТелефон: $phone",
                    'text/plain'
                );
            $transport = (new \Swift_SmtpTransport('in-v3.mailjet.com', 25))
                ->setUsername('4a0694f2cc84b2d0fcfa771d65ada8d2')
                ->setPassword('49739284e7791b4cf65e01e346ebba2c')
            ;

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);
            $response = $mailer->send($message);
        }
        return new JsonResponse(['resp' => $response]);
    }
}