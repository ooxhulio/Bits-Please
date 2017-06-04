<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/27/2017
 * Time: 6:48 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Business;
use AppBundle\Entity\Department;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class BusinessController extends Controller
{
    /**
     * @Route("/business_managment", name="business")
     */
    public function managment(Request $request)
    {
        $b = new Business();
        $form=$this->createFormBuilder($b)
            ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
            ->add('nipt',TextType::class,array('label'=>'Nipt','attr'=>array('class'=> 'form-control')))
            ->add('email',TextType::class,array('label'=>'Email','attr'=>array('class'=> 'form-control')))
            ->add('description',TextareaType::class,array('label'=>'Description','attr'=>array('class'=> 'form-control')))
            ->add('logo',FileType::class,array('label'=>'Logo','attr'=>array('class'=> 'btn btn-default','rows' =>'10')))
            ->add('save',SubmitType::class,array('label'=>'Add Business','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $name=$form['name']->getData();
            $nipt=$form['nipt']->getData();
            $email=$form['email']->getData();
            $description=$form['description']->getData();
            $logo=$form['logo']->getData();
            $photoname=$b->getId().".".$logo->guessExtension();

            $b->setName($name);
            $b->setEmail($email);
            $b->setDescription($description);
            $b->setLogo($photoname);
            $b->setNipt($nipt);
            $em=$this->getDoctrine()->getManager();
            $em->persist($b);
            $em->flush();
            $photoname=$b->getId().".".$logo->guessExtension();
            $b->setLogo($photoname);
            $logo->move(
                $this->getParameter('Bus_Images'),
                $photoname
            );
            $em->persist($b);
            $em->flush();
            return $this->redirectToRoute('business');
        }
        $bus = $this->getDoctrine()
            ->getRepository('AppBundle:Business')
            ->findAll();
        return $this->render('Admin/menaxhoBus.html.twig',array(
            'form'=>$form->createView(),
            'bus'=>$bus,
        ));
    }
    /**
     * @Route("/manager_business", name="mbusiness")
     */
    public function mbusiness(Request $request)
    {
        $b = new Business();
        $form=$this->createFormBuilder($b)
            ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
            ->add('nipt',TextType::class,array('label'=>'Nipt','attr'=>array('class'=> 'form-control')))
            ->add('email',TextType::class,array('label'=>'Email','attr'=>array('class'=> 'form-control')))
            ->add('description',TextareaType::class,array('label'=>'Description','attr'=>array('class'=> 'form-control')))
            ->add('logo',FileType::class,array('label'=>'Logo','attr'=>array('class'=> 'btn btn-default','rows' =>'10')))
            ->add('save',SubmitType::class,array('label'=>'Add Business','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $name=$form['name']->getData();
            $nipt=$form['nipt']->getData();
            $email=$form['email']->getData();
            $description=$form['description']->getData();
            $logo=$form['logo']->getData();
            $photoname=$b->getId().".".$logo->guessExtension();

            $b->setName($name);
            $b->setEmail($email);
            $b->setDescription($description);
            $b->setLogo($photoname);
            $b->setNipt($nipt);
            $em=$this->getDoctrine()->getManager();
            $em->persist($b);
            $em->flush();
            $photoname=$b->getId().".".$logo->guessExtension();
            $b->setLogo($photoname);
            $logo->move(
                $this->getParameter('Bus_Images'),
                $photoname
            );
            $em->persist($b);
            $em->flush();
            return $this->redirectToRoute('mbusiness');
        }
        $bus = $this->getDoctrine()
            ->getRepository('AppBundle:Business')
            ->findAll();
        return $this->render('Manager/menaxhoBus.html.twig',array(
            'form'=>$form->createView(),
            'bus'=>$bus,
        ));
    }
    /**
     * @Route("/department_managment", name="department")
     */
    public function managmentd(Request $request)
    {
        $d = new Department();
        $form=$this->createFormBuilder($d)
            ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
            ->add('save',SubmitType::class,array('label'=>'Add Department','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $name=$form['name']->getData();

            $d->setName($name);
            $em=$this->getDoctrine()->getManager();
            $em->persist($d);
            $em->flush();
            return $this->redirectToRoute('department');
        }
        $dep = $this->getDoctrine()
            ->getRepository('AppBundle:Department')
            ->findAll();
        return $this->render('Admin/menaxhoDep.html.twig',array(
            'form'=>$form->createView(),
            'dep'=>$dep,
        ));
    }
    /**
     * @Route("/manager_department", name="mdepartment")
     */
    public function mdepartment(Request $request)
    {
        $d = new Department();
        $form=$this->createFormBuilder($d)
            ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
            ->add('save',SubmitType::class,array('label'=>'Add Department','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $name=$form['name']->getData();

            $d->setName($name);
            $em=$this->getDoctrine()->getManager();
            $em->persist($d);
            $em->flush();
            return $this->redirectToRoute('mdepartment');
        }
        $dep = $this->getDoctrine()
            ->getRepository('AppBundle:Department')
            ->findAll();
        return $this->render('Manager/menaxhoDep.html.twig',array(
            'form'=>$form->createView(),
            'dep'=>$dep,
        ));
    }
}