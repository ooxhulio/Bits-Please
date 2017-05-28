<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/26/2017
 * Time: 11:20 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardid',TextType::class,array('label'=>'Card Id','attr'=>array('class'=> 'form-control')))
            ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
            ->add('surname',TextType::class,array('label'=>'Surname','attr'=>array('class'=> 'form-control')))
            ->add('salary',TextType::class,array('label'=>'Salary','attr'=>array('class'=> 'form-control')))
            ->add('bank',TextType::class,array('label'=>'Bank Account Nr','attr'=>array('class'=> 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Client::class,
        ));
    }
}