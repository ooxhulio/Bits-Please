<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/26/2017
 * Time: 10:51 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Employee;
use AppBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MergedUE extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('user', UsersType::class, array(
            'data_class' => Users::class
        ))
        ->add('employee', EmployeeType::class, array(
            'data_class' => Employee::class
        ))
        ->add('save',SubmitType::class,array('label'=>'Submit','attr'=>array('class'=> 'btn btn-primary pull-right')))
;
}
}