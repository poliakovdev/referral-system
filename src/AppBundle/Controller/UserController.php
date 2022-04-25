<?php
/**
 * Created by PhpStorm.
 * User: tolik
 * Date: 17.06.2018
 * Time: 22:09
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function indexAction(Request $request)
    {
        $username = $this->getUser();
        return $this->render('user.html.twig', array(
            'text' => $username,
        ));
    }
}