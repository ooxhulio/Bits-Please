<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/26/2017
 * Time: 11:20 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
            ->add('surname',TextType::class,array('label'=>'Surname','attr'=>array('class'=> 'form-control')))
            ->add('ssn',TextType::class,array('label'=>'SSN','attr'=>array('class'=> 'form-control')))
            ->add('position',TextType::class,array('label'=>'Position','attr'=>array('class'=> 'form-control')))
            ->add('department', ChoiceType::class, array('label' => 'Department', 'attr' => array('class' => 'form-control'), 'choices' => array(
                "Marketing"=>"Marketing",
                "Managment"=>"Managment",
                "Loans"=>"Loans",
                "Finance"=>"Finance",
                "IT"=>"IT"
            )))
            ->add('salary',TextType::class,array('label'=>'Salary','attr'=>array('class'=> 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Employee::class,
        ));
    }
}