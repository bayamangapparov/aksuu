<?php

namespace Info\SuggestBundle\Controller;

use Info\SuggestBundle\Entity\Suggest;
use Info\SuggestBundle\Form\SuggestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SuggestController extends Controller
{
    public function createSuggestAction()
    {
        $em = $this->getDoctrine()->getManager();
        $suggest = new Suggest();
        $form = $this->createForm(new SuggestType(), $suggest);
        $request = $this->getRequest();
        if($request->isMethod('POST')) {

            $form->submit($request);
            $this->addFlash(
                'success',
                'СИЗДИН КАЙРЫЛУУНУЗ КАБЫЛ АЛЫНДЫ!'
            );
            if ($form->isValid()) {
                $suggest->setActive(false);
                $em->persist($suggest);
                $em->flush();
                return $this->redirectToRoute('info_suggest_create');
            }
        }
        return $this->render('InfoSuggestBundle:Suggest:createSuggest.html.twig',
            array('form' => $form->createView())
        );
    }

    public function suggestListAction()
    {
        $suggest = $this->getDoctrine()->getRepository('InfoSuggestBundle:Suggest')->findByActive(true);

        return $this->render('InfoSuggestBundle:Suggest:listSuggest.html.twig',
            array('entity'=>$suggest)
        );
    }
}
