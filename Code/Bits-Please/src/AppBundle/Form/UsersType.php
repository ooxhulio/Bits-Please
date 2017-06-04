<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/26/2017
 * Time: 11:21 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,array('label'=>'Username','attr'=>array('class'=> 'form-control','row'=>'5')))
            ->add('email',TextType::class,array('label'=>'Email','attr'=>array('class'=> 'form-control','row'=>'5')))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Passworded duhet te jen njelloj.',
                'options' => array('attr' => array('class' => 'form-control')),
                'required' => false,
                'first_options'  => array('label' => 'Password:'),
                'second_options' => array('label' => 'Confirm Password:'),
                'empty_data'  => '',
            ))
            ->add('type',ChoiceType::class,array('label'=>'Type','attr'=>array('class'=> 'form-control'),'choices'=>array(
                'Client'=>'1',
            )));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Users::class,
        ));
    }
}