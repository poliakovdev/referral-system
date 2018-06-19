<?php
/**
 * Created by PhpStorm.
 * User: tolik
 * Date: 17.06.2018
 * Time: 14:49
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType ;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = null;
        if(isset($_GET['ref'])){
            $data = $_GET['ref'];
        }

        $builder
            ->add('firstName')
            ->add('referralOf', HiddenType::class, array(
                'data' => $data,
            ));
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }
}