<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 5/21/2017
 * Time: 9:55 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Client;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Users;
use AppBundle\Form\MergedUC;
use AppBundle\Form\MergedUE;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;

class UserController extends Controller
{
    /**
     * @Route("/user_managment", name="users")
     */
    public function managment(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')) {
                $e = new Employee();
                $u = new Users();
                $total = array(
                    'user' => $u,
                    'employee' => $e
                );
                $form = $this->createForm(MergedUE::class, $total);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $name = $form['employee']['name']->getData();
                    $surname = $form['employee']['surname']->getData();
                    $email = $form['user']['email']->getData();
                    $username = $form['user']['username']->getData();
                    $password = $form['user']['plainPassword']->getData();
                    $type = 0;
                    $ssn = $form['employee']['ssn']->getData();
                    $department = $form['employee']['department']->getData();
                    $position = $form['employee']['position']->getData();
                    $salary = $form['employee']['salary']->getData();

                    $total['employee']->setName($name);
                    $total['user']->setEmail($email);
                    $total['user']->setUsername($username);
                    $total['user']->setPlainPassword($password);
                    $total['user']->setType($type);
                    $total['user']->setEnabled(true);

                    $total['employee']->setSurname($surname);
                    $total['employee']->setSsn($ssn);
                    $total['employee']->setDepartment($department);
                    $total['employee']->setPosition($position);
                    $total['employee']->setSalary($salary);

                    $em = $this->getDoctrine()->getManager();
                    $total['employee']->setUserId($total['user']);
                    $em->persist($total['employee']);
                    $em->persist($total['user']);
                    $em->flush();
                    $em->flush();
                    return $this->redirectToRoute('users');

                }
                $c = new Client();
                $u1 = new Users();
                $total1 = array(
                    'user' => $u1,
                    'client' => $c
                );
                $form1 = $this->createForm(MergedUC::class, $total1);
                $form1->handleRequest($request);
                if ($form1->isSubmitted() && $form1->isValid()) {
                    $name=$form1['client']['name']->getData();
                    $surname=$form1['client']['surname']->getData();
                    $email=$form1['user']['email']->getData();
                    $username=$form1['user']['username']->getData();
                    $password=$form1['user']['plainPassword']->getData();
                    $type=1;
                    $bank=$form1['client']['bank']->getData();
                    $cardid=$form1['client']['cardid']->getData();
                    $salary=$form1['client']['salary']->getData();


                    $total1['client']->setName($name);
                    $total1['user']->setEmail($email);
                    $total1['user']->setUsername($username);
                    $total1['user']->setPlainPassword($password);
                    $total1['user']->setType($type);
                    $total1['user']->setEnabled(true);
                    $total1['client']->setSurname($surname);
                    $total1['client']->setBank($bank);
                    $total1['client']->setCardid($cardid);
                    $total1['client']->setSalary($salary);
                    $total1['client']->setUserId($total1['user']);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($total1['user']);
                    $em->flush();
                    $em->persist($total1['client']);
                    $em->flush();

                    return $this->redirectToRoute('users');

                }
                $users = $this->getDoctrine()
                    ->getRepository('AppBundle:Users')
                    ->findAll();
                $employees = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->findAll();
                $clients = $this->getDoctrine()
                    ->getRepository('AppBundle:Client')
                    ->findAll();
                return $this->render('Admin/menaxhousers.html.twig', array(
                    'form' => $form->createView(),
                    'form2' => $form1->createView(),
                    'users' => $users,
                    'employees' => $employees,
                    'clients' => $clients,
                ));
            }else{
                return $this->redirectToRoute('ClientIndex');
            }
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/manager_client", name="clients")
     */
    public function managmentClients(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                return $this->redirectToRoute('admin');
            }else if($user->getType()==1){
                return $this->redirectToRoute('ClientIndex');
            }
            $c = new Client();
            $u1 = new Users();
            $departments = $this->getDoctrine()
                ->getRepository('AppBundle:Department')
                ->findAll();
            $total1=array(
                'user'=>$u1,
                'client'=>$c,
            );

            $form1= $this->createForm(MergedUC::class,$total1);
            $form1->handleRequest($request);
            if($form1->isSubmitted()&&$form1->isValid()){
                $name=$form1['client']['name']->getData();
                $surname=$form1['client']['surname']->getData();
                $email=$form1['user']['email']->getData();
                $username=$form1['user']['username']->getData();
                $password=$form1['user']['plainPassword']->getData();
                $type=1;
                $bank=$form1['client']['bank']->getData();
                $cardid=$form1['client']['cardid']->getData();
                $salary=$form1['client']['salary']->getData();

                $total1['client']->setName($name);
                $total1['user']->setEmail($email);
                $total1['user']->setUsername($username);
                $total1['user']->setPlainPassword($password);
                $total1['user']->setType($type);
                $total1['user']->setEnabled(true);
                $total1['client']->setSurname($surname);
                $total1['client']->setBank($bank);
                $total1['client']->setCardid($cardid);
                $total1['client']->setSalary($salary);
                $total1['client']->setUserId($total1['user']);
                $em=$this->getDoctrine()->getManager();
                $em->persist($total1['user']);
                $em->flush();
                $em->persist($total1['client']);
                $em->flush();
                return $this->redirectToRoute('clients');

            }
            $users = $this->getDoctrine()
                ->getRepository('AppBundle:Users')
                ->findAll();
            $clients = $this->getDoctrine()
                ->getRepository('AppBundle:Client')
                ->findAll();
            return $this->render('Manager/menaxhousers.html.twig',array(
                'form2'=>$form1->createView(),
                'users'=>$users,
                'clients'=>$clients,
            ));
        }else{
            return $this->redirectToRoute('ClientIndex');
        }


    }
    /**
     * @Route("/edit_clients/{id}", name="editclients")
     */
    public function editClients($id,Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')) {
                $clients = $this->getDoctrine()
                    ->getRepository('AppBundle:Client')
                    ->find($id);
                $form = $this->createFormBuilder($clients)
                    ->add('cardid', TextType::class, array('label' => 'Card Id', 'attr' => array('class' => 'form-control')))
                    ->add('name', TextType::class, array('label' => 'Name', 'attr' => array('class' => 'form-control')))
                    ->add('surname', TextType::class, array('label' => 'Surname', 'attr' => array('class' => 'form-control')))
                    ->add('salary', TextType::class, array('label' => 'Salary', 'attr' => array('class' => 'form-control')))
                    ->add('bank', TextType::class, array('label' => 'Bank Account Nr', 'attr' => array('class' => 'form-control')))
                    ->add('save', SubmitType::class, array('label' => 'Edit Client', 'attr' => array('class' => 'btn btn-primary pull-right')))
                    ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $cardid = $form['cardid']->getData();
                    $name = $form['name']->getData();
                    $surname = $form['surname']->getData();
                    $salary = $form['salary']->getData();
                    $bank = $form['bank']->getData();
                    $clients->setCardid($cardid);
                    $clients->setName($name);
                    $clients->setSurname($surname);
                    $clients->setBank($bank);
                    $clients->setSalary($salary);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($clients);
                    $em->flush();
                    return $this->redirectToRoute('users');
                }
                return $this->render('Admin/editUCE.html.twig', array(
                    'form' => $form->createView(),
                    'clients' => $clients,
                ));
            }else{
                return $this->redirectToRoute('ClientIndex');
            }
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/edit_employees/{id}", name="editemployees")
     */
    public function editEmployees($id,Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')) {
                $employee = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->find($id);
                $form = $this->createFormBuilder($employee)
                    ->add('name', TextType::class, array('label' => 'Name', 'attr' => array('class' => 'form-control')))
                    ->add('surname', TextType::class, array('label' => 'Surname', 'attr' => array('class' => 'form-control')))
                    ->add('ssn', TextType::class, array('label' => 'SSN', 'attr' => array('class' => 'form-control')))
                    ->add('position', TextType::class, array('label' => 'Position', 'attr' => array('class' => 'form-control')))
                    ->add('department', TextType::class, array('label' => 'Department', 'attr' => array('class' => 'form-control')))
                    ->add('salary', TextType::class, array('label' => 'Salary', 'attr' => array('class' => 'form-control')))
                    ->add('save', SubmitType::class, array('label' => 'Edit Employee', 'attr' => array('class' => 'btn btn-primary pull-right')))
                    ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $surname = $form['surname']->getData();
                    $name = $form['name']->getData();
                    $ssn = $form['ssn']->getData();
                    $position = $form['position']->getData();
                    $department = $form['department']->getData();
                    $salary = $form['salary']->getData();
                    $employee->setSsn($ssn);
                    $employee->setName($name);
                    $employee->setSurname($surname);
                    $employee->setPosition($position);
                    $employee->setSalary($salary);
                    $employee->setDepartment($department);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($employee);
                    $em->flush();
                    return $this->redirectToRoute('users');
                }
                return $this->render('Admin/editUCE.html.twig', array(
                    'form' => $form->createView(),
                    'employee' => $employee,
                ));
            }else{
                return $this->redirectToRoute('ClientIndex');
            }
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/edit_users/{id}", name="editusers")
     */
    public function editUserd($id,Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user1 = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user1->hasRole('ROLE_SUPER_ADMIN')) {
                $user = $this->getDoctrine()
                    ->getRepository('AppBundle:Users')
                    ->find($id);
                $form = $this->createFormBuilder($user)
                    ->add('username', TextType::class, array('label' => 'Username', 'attr' => array('class' => 'form-control', 'row' => '5')))
                    ->add('email', TextType::class, array('label' => 'Email', 'attr' => array('class' => 'form-control', 'row' => '5')))
                    ->add('plainPassword', RepeatedType::class, array(
                        'type' => PasswordType::class,
                        'invalid_message' => 'Passworded duhet te jen njelloj.',
                        'options' => array('attr' => array('class' => 'form-control')),
                        'required' => false,
                        'first_options' => array('label' => 'Password:'),
                        'second_options' => array('label' => 'Confirm Password:'),
                        'empty_data' => '',
                    ))
                    ->add('type', ChoiceType::class, array('label' => 'Type', 'attr' => array('class' => 'form-control'), 'choices' => array(
                        'Employee' => '0',
                        'Client' => '1',
                        'Admin' => '2',
                    )))
                    ->add('save', SubmitType::class, array('label' => 'Edit User', 'attr' => array('class' => 'btn btn-primary pull-right')))
                    ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $username = $form['username']->getData();
                    $email = $form['email']->getData();
                    $password = $form['plainPassword']->getData();
                    $type = $form['type']->getData();


                    $user->setUsername($username);
                    $user->setEmail($email);
                    $user->setType($type);
                    $user->setEnabled(true);
                    if ($password != null || $password != ""){
                        $user->setPlainPassword($password);
                    }
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('users');
                }
                return $this->render('Admin/editUCE.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                ));
            }else{
                return $this->redirectToRoute('ClientIndex');
            }
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/edit_client/{id}", name="editclient")
     */
    public function editClient($id,Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                return $this->redirectToRoute('admin');
            }else if($user->getType()==1){
                return $this->redirectToRoute('ClientIndex');
            }
            $clients = $this->getDoctrine()
                ->getRepository('AppBundle:Client')
                ->find($id);
            $form=$this->createFormBuilder($clients)
                ->add('cardid',TextType::class,array('label'=>'Card Id','attr'=>array('class'=> 'form-control')))
                ->add('name',TextType::class,array('label'=>'Name','attr'=>array('class'=> 'form-control')))
                ->add('surname',TextType::class,array('label'=>'Surname','attr'=>array('class'=> 'form-control')))
                ->add('salary',TextType::class,array('label'=>'Salary','attr'=>array('class'=> 'form-control')))
                ->add('bank',TextType::class,array('label'=>'Bank Account Nr','attr'=>array('class'=> 'form-control')))
                ->add('save',SubmitType::class,array('label'=>'Edit Client','attr'=>array('class'=> 'btn btn-primary pull-right')))
                ->getForm();
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()){
                $cardid=$form['cardid']->getData();
                $name=$form['name']->getData();
                $surname=$form['surname']->getData();
                $salary=$form['salary']->getData();
                $bank=$form['bank']->getData();
                $clients->setCardid($cardid);
                $clients->setName($name);
                $clients->setSurname($surname);
                $clients->setBank($bank);
                $clients->setSalary($salary);
                $em=$this->getDoctrine()->getManager();
                $em->persist($clients);
                $em->flush();
                return $this->redirectToRoute('clients');
            }
            return $this->render('Manager/editUCE.html.twig',array(
                'form'=>$form->createView(),
                'clients'=>$clients,
            ));
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                $loans = $this->getDoctrine()
                    ->getRepository('AppBundle:Loan')
                    ->findAll();
                $clients = $this->getDoctrine()
                    ->getRepository('AppBundle:Client')
                    ->findAll();
                $employees = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->findAll();
                $businesses = $this->getDoctrine()
                    ->getRepository('AppBundle:Business')
                    ->findAll();
                $departments = $this->getDoctrine()
                    ->getRepository('AppBundle:Department')
                    ->findAll();
                $bloans=0;
                for($i=0;$i<sizeof($loans);$i++){
                    if($loans[$i]->getStatus()==0) $bloans++;
                }
                $nloans=0;
                for($i=0;$i<sizeof($loans);$i++){
                    if((time()-(60*60*24*7)) < $loans[$i]->getDataFillimit()->getTimestamp()){
                        $nloans++;
                    }
                }
                $ditet= array('0','0','0','0','0','0','0');
                $dje=0;
                $sot=0;
                for($i=0;$i<sizeof($loans);$i++){
                    if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-7 day') ){
                        $ditet[$loans[$i]->getDataFillimit()->format('w')]++;
                    }
                    if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-2 day') && strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))< strtotime('-1 day') ){
                        $dje++;
                    }
                    if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-1 day') ){
                        $sot++;
                    }
                }
                if($dje!=0)$inc=(($sot-$dje)/$dje)*100;
                else $inc=100;
                $muajt= array('0','0','0','0','0','0','0','0','0','0','0','0');
                for($i=0;$i<sizeof($loans);$i++){
                    if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-365 day') ){
                        $muajt[$loans[$i]->getDataFillimit()->format('n')-1]++;
                    }
                }
                return $this->render('Admin/dashboard.html.twig',array(
                    'loans'=>$loans,
                    'bloans'=>$bloans,
                    'nloans'=>$nloans,
                    'clients'=>$clients,
                    'employees'=>$employees,
                    'businesses'=>$businesses,
                    'departments'=>$departments,
                    'ditet'=>$ditet,
                    'muajt'=>$muajt,
                    'inc'=>$inc
                ));
            }else{
                return $this->redirectToRoute('ClientIndex');
            }

        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/manager", name="manager")
     */
    public function manager(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                return $this->redirectToRoute('admin');
            }else if($user->getType()==1){
                return $this->redirectToRoute('ClientIndex');
            }
            $loans = $this->getDoctrine()
                ->getRepository('AppBundle:Loan')
                ->findAll();
            $clients = $this->getDoctrine()
                ->getRepository('AppBundle:Client')
                ->findAll();
            $employees = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findAll();
            $businesses = $this->getDoctrine()
                ->getRepository('AppBundle:Business')
                ->findAll();
            $departments = $this->getDoctrine()
                ->getRepository('AppBundle:Department')
                ->findAll();
            $bloans=0;
            for($i=0;$i<sizeof($loans);$i++){
                if($loans[$i]->getStatus()==0) $bloans++;
            }
            $nloans=0;
            for($i=0;$i<sizeof($loans);$i++){
                if((time()-(60*60*24*7)) < $loans[$i]->getDataFillimit()->getTimestamp()){
                    $nloans++;
                }
            }
            $ditet= array('0','0','0','0','0','0','0');
            $dje=0;
            $sot=0;
            for($i=0;$i<sizeof($loans);$i++){
                if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-7 day') ){
                    $ditet[$loans[$i]->getDataFillimit()->format('w')]++;
                }
                if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-2 day') && strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))< strtotime('-1 day') ){
                    $dje++;
                }
                if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-1 day') ){
                    $sot++;
                }
            }
            if($dje!=0)$inc=(($sot-$dje)/$dje)*100;
            else $inc=100;
            $muajt= array('0','0','0','0','0','0','0','0','0','0','0','0');
            for($i=0;$i<sizeof($loans);$i++){
                if(strtotime($loans[$i]->getDataFillimit()->format('Y-m-d H:i:s'))> strtotime('-365 day') ){
                    $muajt[$loans[$i]->getDataFillimit()->format('n')-1]++;
                }
            }
            return $this->render('Manager/dashboard.html.twig',array(
                'loans'=>$loans,
                'bloans'=>$bloans,
                'nloans'=>$nloans,
                'clients'=>$clients,
                'employees'=>$employees,
                'businesses'=>$businesses,
                'departments'=>$departments,
                'ditet'=>$ditet,
                'muajt'=>$muajt,
                'inc'=>$inc
            ));
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $c = new Client();
            $u1 = new Users();
            $total1=array(
                'user'=>$u1,
                'client'=>$c
            );
            $form1= $this->createForm(MergedUC::class,$total1);
            $form1->handleRequest($request);
            if($form1->isSubmitted()&&$form1->isValid()){
                $name=$form1['client']['name']->getData();
                $surname=$form1['client']['surname']->getData();
                $email=$form1['user']['email']->getData();
                $username=$form1['user']['username']->getData();
                $password=$form1['user']['plainPassword']->getData();
                $type=1;
                $bank=$form1['client']['bank']->getData();
                $cardid=$form1['client']['cardid']->getData();
                $salary=$form1['client']['salary']->getData();

                $total1['client']->setName($name);
                $total1['user']->setEmail($email);
                $total1['user']->setUsername($username);
                $total1['user']->setPlainPassword($password);
                $total1['user']->setType($type);
                $total1['user']->setEnabled(true);
                $total1['client']->setSurname($surname);
                $total1['client']->setBank($bank);
                $total1['client']->setCardid($cardid);
                $total1['client']->setSalary($salary);
                $total1['client']->setUserId($total1['user']);
                $em=$this->getDoctrine()->getManager();
                $em->persist($total1['user']);
                $em->flush();
                $em->persist($total1['client']);
                $em->flush();
                return $this->redirectToRoute('ClientIndex');

            }
            $users = $this->getDoctrine()
                ->getRepository('AppBundle:Users')
                ->findAll();
            $clients = $this->getDoctrine()
                ->getRepository('AppBundle:Client')
                ->findAll();
            return $this->render('Client/signup.html.twig',array(
                'form2'=>$form1->createView(),
                'users'=>$users,
                'clients'=>$clients,
            ));
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/aprofile", name="aprofile")
     */
    public function aprofile(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                return $this->render('Admin/profile.html.twig');
            }else{
                return $this->redirectToRoute('ClientIndex');
            }

        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile($id,Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                return $this->redirectToRoute($this->aprofile());
            }else if($user->getType()==1){
                $client = $this->getDoctrine()
                    ->getRepository('AppBundle:Client')
                    ->findBy(array('userId' => $id));
                $total1 = array(
                    'user' => $user,
                    'client' => $client[0]
                );
                $loans = $this->getDoctrine()
                    ->getRepository('AppBundle:Loan')
                    ->findBy(array('clientid'=>$client[0]->getId()));
                $aloans = $this->getDoctrine()
                    ->getRepository('AppBundle:LoanApproval')
                    ->findBy(array('clientid'=>$client[0]->getId()));

                $form1 = $this->createForm(MergedUC::class, $total1);
                $form1->handleRequest($request);
                if ($form1->isSubmitted() && $form1->isValid()) {
                    $name = $form1['client']['name']->getData();
                    $surname = $form1['client']['surname']->getData();
                    $email = $form1['user']['email']->getData();
                    $username = $form1['user']['username']->getData();
                    $password = $form1['user']['plainPassword']->getData();
                    $type = 1;
                    $bank = $form1['client']['bank']->getData();
                    $cardid = $form1['client']['cardid']->getData();
                    $salary = $form1['client']['salary']->getData();

                    $total1['client']->setName($name);
                    $total1['user']->setEmail($email);
                    $total1['user']->setUsername($username);
                    $total1['user']->setPlainPassword($password);
                    $total1['user']->setType($type);
                    $total1['client']->setSurname($surname);
                    $total1['client']->setBank($bank);
                    $total1['client']->setCardid($cardid);
                    $total1['client']->setSalary($salary);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($total1['user']);
                    $em->flush();
                    $total1['client']->setUserId($total1['user']);
                    $em->persist($total1['client']);
                    $em->flush();

                    return $this->redirectToRoute('ClientIndex');
                }
                return $this->render('Client/profile.html.twig',array(
                    "form2"=>$form1->createView(),
                    "loans"=>$loans,
                    "aloans"=>$aloans,
                ));
            }else{
                $emp = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->findBy(array('userId' => $id));
                $total = array(
                    'user' => $user,
                    'employee' => $emp[0]
                );
                $form = $this->createForm(MergedUE::class, $total);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $name = $form['employee']['name']->getData();
                    $surname = $form['employee']['surname']->getData();
                    $email = $form['user']['email']->getData();
                    $username = $form['user']['username']->getData();
                    $password = $form['user']['plainPassword']->getData();
                    $type = 0;
                    $ssn = $form['employee']['ssn']->getData();
                    $department = $form['employee']['department']->getData();
                    $position = $form['employee']['position']->getData();
                    $salary = $form['employee']['salary']->getData();

                    $total['employee']->setName($name);
                    $total['user']->setEmail($email);
                    $total['user']->setUsername($username);
                    $total['user']->setPlainPassword($password);
                    $total['user']->setType($type);
                    $total['user']->setEnabled(true);

                    $total['employee']->setSurname($surname);
                    $total['employee']->setSsn($ssn);
                    $total['employee']->setDepartment($department);
                    $total['employee']->setPosition($position);
                    $total['employee']->setSalary($salary);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($total['user']);
                    $em->flush();
                    $total['employee']->setUserId($total['user']);
                    $em->persist($total['employee']);
                    $em->flush();
                    return $this->redirectToRoute('manager');

                }
               return $this->render('Client/profile.html.twig',array(
                    "form"=>$form->createView(),
                ));
            }

        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
}