<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/28/2017
 * Time: 5:12 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Loan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class LoanController extends Controller
{
    /**
     * @Route("/loan_managment", name="loan")
     */
    public function managment(Request $request)
    {
        $l= new Loan();
        $c = $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->findAll();
        $clients=array();
        for($i=0;$i<sizeof($c);$i++){
            $clients[$c[$i]->getCardid()." ".$c[$i]->getName()." ".$c[$i]->getSurname()]=$c[$i];
        }
        $form=$this->createFormBuilder($l)
            ->add('clientid',ChoiceType::class,array('label'=>'Client ID','attr'=>array('class'=> 'form-control'), 'choices'=>
                $clients
            ))
            ->add('amount',TextType::class,array('label'=>'Amount','attr'=>array('class'=> 'form-control amount')))
            ->add('interest',TextType::class,array('label'=>'Interest','attr'=>array('class'=> 'form-control int')))
            ->add('maturity',ChoiceType::class,array('label'=>'Maturity','attr'=>array('class'=> 'form-control maturity'),'choices'=>array(
                '1 Month'=>'1',
                '2 Months'=>'2',
                '3 Months'=>'3',
                '4 Months'=>'4',
                '5 Months'=>'5',
                '6 Months'=>'6',
                '7 Months'=>'7',
                '8 Months'=>'8',
                '9 Months'=>'9',
                '10 Months'=>'10',
                '11 Months'=>'11',
                '12 Months'=>'12',
                '13 Months'=>'13',
                '14 Months'=>'14',
            )))
            ->add('status',ChoiceType::class,array('label'=>'Type','attr'=>array('class'=> 'form-control'),'choices'=>array(
                'Aktiv'=>'1',
                'Me Vonese'=>'2',
                'Kredi e Keqe'=>'3',
                'Mbaruar'=>'0',
            )))
            ->add('dataFillimit',TextType::class,array('label'=>'Data e Fillimit','attr'=>array('class'=> 'form-control datetimepicker','id'=>'datetimepicker')))
            ->add('save',SubmitType::class,array('label'=>'Add Loan','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $cid=$form['clientid']->getData();
            $amnt=$form['amount']->getData();
            $int=$form['interest']->getData();
            $mat=$form['maturity']->getData();
            $stat=$form['status']->getData();
            $dat=$form['dataFillimit']->getData();
            $date = date_create_from_format('Y/m/d H:i', $form['dataFillimit']->getData());
            $l->setAmount($amnt);
            $l->setClientid($cid);
            $l->setInterest($int);
            $l->setMaturity($mat);
            $l->setStatus($stat);
            $l->setDataFillimit($date);
            $em=$this->getDoctrine()->getManager();
            $em->persist($l);
            $em->flush();
            return $this->redirectToRoute('loan');
        }
        $loans = $this->getDoctrine()
            ->getRepository('AppBundle:Loan')
            ->findAll();

        return $this->render('Admin/menaxhoLoans.html.twig',array(
            'form'=>$form->createView(),
            'loans'=>$loans,
        ));
    }
    /**
     * @Route("/manager_loan", name="mloan")
     */
    public function mloan(Request $request)
    {
        $l= new Loan();
        $c = $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->findAll();
        $clients=array();
        for($i=0;$i<sizeof($c);$i++){
            $clients[$c[$i]->getCardid()." ".$c[$i]->getName()." ".$c[$i]->getSurname()]=$c[$i];
        }
        $form=$this->createFormBuilder($l)
            ->add('clientid',ChoiceType::class,array('label'=>'Client ID','attr'=>array('class'=> 'form-control'), 'choices'=>
                $clients
            ))
            ->add('amount',TextType::class,array('label'=>'Amount','attr'=>array('class'=> 'form-control amount')))
            ->add('interest',TextType::class,array('label'=>'Interest','attr'=>array('class'=> 'form-control int')))
            ->add('maturity',ChoiceType::class,array('label'=>'Maturity','attr'=>array('class'=> 'form-control maturity'),'choices'=>array(
                '1 Month'=>'1',
                '2 Months'=>'2',
                '3 Months'=>'3',
                '4 Months'=>'4',
                '5 Months'=>'5',
                '6 Months'=>'6',
                '7 Months'=>'7',
                '8 Months'=>'8',
                '9 Months'=>'9',
                '10 Months'=>'10',
                '11 Months'=>'11',
                '12 Months'=>'12',
                '13 Months'=>'13',
                '14 Months'=>'14',
            )))
            ->add('status',ChoiceType::class,array('label'=>'Type','attr'=>array('class'=> 'form-control'),'choices'=>array(
                'Aktiv'=>'1',
                'Me Vonese'=>'2',
                'Kredi e Keqe'=>'3',
                'Mbaruar'=>'0',
            )))
            ->add('dataFillimit',TextType::class,array('label'=>'Data e Fillimit','attr'=>array('class'=> 'form-control datetimepicker','id'=>'datetimepicker')))
            ->add('save',SubmitType::class,array('label'=>'Add Loan','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $cid=$form['clientid']->getData();
            $amnt=$form['amount']->getData();
            $int=$form['interest']->getData();
            $mat=$form['maturity']->getData();
            $stat=$form['status']->getData();
            $dat=$form['dataFillimit']->getData();
            $date = date_create_from_format('Y/m/d H:i', $form['dataFillimit']->getData());
            $l->setAmount($amnt);
            $l->setClientid($cid);
            $l->setInterest($int);
            $l->setMaturity($mat);
            $l->setStatus($stat);
            $l->setPayed(0);
            $l->setDataFillimit($date);
            $em=$this->getDoctrine()->getManager();
            $em->persist($l);
            $em->flush();
            return $this->redirectToRoute('mloan');
        }
        $loans = $this->getDoctrine()
            ->getRepository('AppBundle:Loan')
            ->findAll();
        for($i=0;$i<sizeof($loans);$i++){
            $newdate = date('Y-m-d', strtotime("+".$loans[$i]->getPayed()." months", strtotime($loans[$i]->getDataFillimit()->format('Y-m-d'))));
            if(strtotime($newdate)<strtotime(date("Y-m-d"))){
                $loans[$i]->setStatus(2);
                $em=$this->getDoctrine()->getManager();
                $em->persist($loans[$i]);
                $em->flush();
            }else if ($loans[$i]->getStatus()==2){
                if(strtotime($newdate)>strtotime(date("Y-m-d"))){
                    $loans[$i]->setStatus(1);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($loans[$i]);
                    $em->flush();
                }
            }
        }

        return $this->render('Manager/menaxhoLoans.html.twig',array(
            'form'=>$form->createView(),
            'loans'=>$loans,
        ));
    }
    /**
     * @Route("/edit_loan/{id}", name="editloan")
     */
    public function edit($id,Request $request)
    {
        $loans = $this->getDoctrine()
            ->getRepository('AppBundle:Loan')
            ->find($id);
        $c = $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->findAll();
        $clients=array();
        for($i=0;$i<sizeof($c);$i++){
            $clients[$c[$i]->getCardid()." ".$c[$i]->getName()." ".$c[$i]->getSurname()]=$c[$i];
        }
        $form=$this->createFormBuilder($loans)
            ->add('clientid',ChoiceType::class,array('label'=>'Client ID','attr'=>array('class'=> 'form-control'), 'choices'=>
                $clients
            ))
            ->add('amount',TextType::class,array('label'=>'Amount','attr'=>array('class'=> 'form-control')))
            ->add('interest',TextType::class,array('label'=>'Interest','attr'=>array('class'=> 'form-control')))
            ->add('maturity',ChoiceType::class,array('label'=>'Maturity','attr'=>array('class'=> 'form-control'),'choices'=>array(
                '1 Month'=>'1',
                '2 Months'=>'2',
                '3 Months'=>'3',
                '4 Months'=>'4',
                '5 Months'=>'5',
                '6 Months'=>'6',
                '7 Months'=>'7',
                '8 Months'=>'8',
                '9 Months'=>'9',
                '10 Months'=>'10',
                '11 Months'=>'11',
                '12 Months'=>'12',
                '13 Months'=>'13',
                '14 Months'=>'14',
            )))
            ->add('status',ChoiceType::class,array('label'=>'Type','attr'=>array('class'=> 'form-control'),'choices'=>array(
                'Aktiv'=>'1',
                'Me Vonese'=>'2',
                'Kredi e Keqe'=>'3',
                'Mbaruar'=>'0',
            )))
            ->add('dataFillimit',TextType::class,array('mapped' => false,'label'=>'Data e Fillimit','attr'=>array('class'=> 'form-control datetimepicker','id'=>'datetimepicker','value'=>$loans->getDataFillimit()->format('Y/m/d H:i'))))
            ->add('save',SubmitType::class,array('label'=>'Edit Loan','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $cid=$form['clientid']->getData();
            $amnt=$form['amount']->getData();
            $int=$form['interest']->getData();
            $mat=$form['maturity']->getData();
            $stat=$form['status']->getData();

            $date = date_create_from_format('Y/m/d H:i', $form['dataFillimit']->getData());
            $loans->setAmount($amnt);
            $loans->setClientid($cid);
            $loans->setInterest($int);
            $loans->setMaturity($mat);
            $loans->setStatus($stat);
            $loans->setDataFillimit($date);
            $em=$this->getDoctrine()->getManager();
            $em->persist($loans);
            $em->flush();
            return $this->redirectToRoute('loan');
        }

        return $this->render('Admin/editLoans.html.twig',array(
            'form'=>$form->createView(),
            'loans'=>$loans,
        ));
    }
    /**
     * @Route("/editl/{id}", name="eloan")
     */
    public function editl($id,Request $request)
    {
        $loans = $this->getDoctrine()
            ->getRepository('AppBundle:Loan')
            ->find($id);
        $c = $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->findAll();
        $clients=array();
        for($i=0;$i<sizeof($c);$i++){
            $clients[$c[$i]->getCardid()." ".$c[$i]->getName()." ".$c[$i]->getSurname()]=$c[$i];
        }
        $form=$this->createFormBuilder($loans)
            ->add('clientid',ChoiceType::class,array('label'=>'Client ID','attr'=>array('class'=> 'form-control'), 'choices'=>
                $clients
            ))
            ->add('amount',TextType::class,array('label'=>'Amount','attr'=>array('class'=> 'form-control')))
            ->add('interest',TextType::class,array('label'=>'Interest','attr'=>array('class'=> 'form-control')))
            ->add('maturity',ChoiceType::class,array('label'=>'Maturity','attr'=>array('class'=> 'form-control'),'choices'=>array(
                '1 Month'=>'1',
                '2 Months'=>'2',
                '3 Months'=>'3',
                '4 Months'=>'4',
                '5 Months'=>'5',
                '6 Months'=>'6',
                '7 Months'=>'7',
                '8 Months'=>'8',
                '9 Months'=>'9',
                '10 Months'=>'10',
                '11 Months'=>'11',
                '12 Months'=>'12',
                '13 Months'=>'13',
                '14 Months'=>'14',
            )))
            ->add('status',ChoiceType::class,array('label'=>'Type','attr'=>array('class'=> 'form-control'),'choices'=>array(
                'Aktiv'=>'1',
                'Me Vonese'=>'2',
                'Kredi e Keqe'=>'3',
                'Mbaruar'=>'0',
            )))
            ->add('dataFillimit',TextType::class,array('mapped' => false,'label'=>'Data e Fillimit','attr'=>array('class'=> 'form-control datetimepicker','id'=>'datetimepicker','value'=>$loans->getDataFillimit()->format('Y/m/d H:i'))))
            ->add('save',SubmitType::class,array('label'=>'Edit Loan','attr'=>array('class'=> 'btn btn-primary pull-right')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $cid=$form['clientid']->getData();
            $amnt=$form['amount']->getData();
            $int=$form['interest']->getData();
            $mat=$form['maturity']->getData();
            $stat=$form['status']->getData();

            $date = date_create_from_format('Y/m/d H:i', $form['dataFillimit']->getData());
            $loans->setAmount($amnt);
            $loans->setClientid($cid);
            $loans->setInterest($int);
            $loans->setMaturity($mat);
            $loans->setStatus($stat);
            $loans->setDataFillimit($date);
            $em=$this->getDoctrine()->getManager();
            $em->persist($loans);
            $em->flush();
            return $this->redirectToRoute('mloan');
        }

        return $this->render('Manager/editLoans.html.twig',array(
            'form'=>$form->createView(),
            'loans'=>$loans,
        ));
    }
    /**
     * @Route("/invoice/{id}", name="invoice")
     */
    public function invoice($id,Request $request)
    {
        $loans = $this->getDoctrine()
            ->getRepository('AppBundle:Loan')
            ->find($id);
        if($loans->getPayed()+1==$loans->getMaturity()){
            $loans->setPayed($loans->getPayed()+1);
            $loans->setStatus(0);
        }else {
            $loans->setPayed($loans->getPayed() + 1);
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($loans);
        $em->flush();
        return $this->render('Manager/invoice.html.twig',array(
            'x'=>$loans,
        ));
    }

}