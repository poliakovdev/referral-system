<?php
/**
 * Created by PhpStorm.
 * User: tolik
 * Date: 17.06.2018
 * Time: 22:31
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RefController extends Controller
{
    /**
     * @Route("/user/ref", name="ref")
     */
    public function indexAction(Request $request)
    {
        $currentUser = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($currentUser);
        $allReferralCodes = $entityManager->getRepository(User::class)->findAll();
        $referrals = $entityManager->getRepository(User::class)->findByReferralOf($user->getRef());

        $ifLocalHost = null;
        if($_SERVER['SERVER_NAME'] = "127.0.0.1"){
            $ifLocalHost = ":".$_SERVER['SERVER_PORT'];
        }
        $refUrl = $_SERVER['SERVER_NAME'].$ifLocalHost."/register/?ref=".$user->getRef();

        $disabled = false;
        if($user->getRef() != null){
            $disabled = true;
        }

        $form = $this->createFormBuilder($user)
            ->add('ref', TextType::class, array('disabled' => true))
            ->add('generate', SubmitType::class, array('label' => 'Generate'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newReferralCode = $user->generateNewRefferalCode($allReferralCodes);
            $user->setRef($newReferralCode);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('ref');
        }

        return $this->render('ref.html.twig', array(
            'form' => $form->createView(),
            'username' => $currentUser,
            'ref' => $refUrl,
            'disabledStatus' => $disabled,
            'referrals' => $referrals,
        ));
    }
}