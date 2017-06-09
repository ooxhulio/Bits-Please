<?php
/**
 * Created by PhpStorm.
 * User: xhulio
 * Date: 6/6/2017
 * Time: 5:26 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\LoanApproval;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    /**
     * @Route("/", name="ClientIndex")
     */
    public function indexAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                return $this->redirectToRoute('admin');
            }else if($user->getType()==0){
                return $this->redirectToRoute('manager');
            }else{
                return $this->render('Client/index.html.twig');
            }
        }
        return $this->render('Client/index.html.twig');
    }
    /**
     * @Route("/apply", name="apply")
     */
    public function apply(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                return $this->redirectToRoute('admin');
            }else if($user->getType()==0){
                return $this->redirectToRoute('manager');
            }
            $c = $this->getDoctrine()
                ->getRepository('AppBundle:Client')
                ->findBy(array('userId' => $user->getId()));
            $loan = new LoanApproval();
            if (isset($_REQUEST['submit'])) {
                $amnt = $_POST['loanAmount'];
                if ($_POST['clientType'] === "new") {
                    $int = 0.17;
                } else {
                    $int = 0.15;
                }

                $mat = $_POST['loanPeriod'];

                $date = date("Y/m/d H:i");
                $loan->setAmount($amnt);
                $loan->setClientid($c[0]);
                $loan->setInterest($int);
                $loan->setMaturity($mat);
                $loan->setDataFillimit(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($loan);
                $em->flush();
                return $this->redirectToRoute('ClientIndex');
            }

            return $this->render('Client/apply.html.twig');
        }else{
            return $this->redirectToRoute('ClientIndex');
        }

    }
}