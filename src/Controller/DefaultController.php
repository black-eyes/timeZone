<?php

namespace App\Controller;

use App\Form\DatesType;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(DatesType::class);

        $form->handleRequest($request);

        $data = null;
        if($form->isSubmitted())
        {
            $formData = $form->getData();


            $timeOffsetTOUTC  = $this->timeOffsetTOUTC($formData['TimeZone']);
            $data ['timeOffsetTOUTC']= $timeOffsetTOUTC;

            $februaryDaysCount = $this->februaryDaysCount($formData['date']);
            $data ['februaryDaysCount']= $februaryDaysCount;

            $nameOfMonth = $this->nameOfMonth($formData['date']);
            $data ['nameOfMonth']= $nameOfMonth;

            $numberOfDaysOfMonth = $this->numberOfDaysOfMonth($formData['date']);
            $data ['numberOfDaysOfMonth']= $numberOfDaysOfMonth;

            //get form data for the twog display
            $data['date']=$formData['date'];
            $data['TimeZone']=$formData['TimeZone'];
        }

        return $this->render('default/index.html.twig',
            [
                'controller_name' => 'DefaultController',
                'form' => $form->createView(),
                'data'=>$data
            ]);
    }

    /**
     * @param $TimeZone
     * @return string
     */
    function  timeOffsetTOUTC($TimeZone):string
    {
        $dateTimeZoneUTC = new \DateTimeZone("UTC");
        $dateTimeZoneForm = new \DateTimeZone($TimeZone);


        $dateFromGivenTime = new \DateTime("now", $dateTimeZoneForm );
        $dateFromUTCTime =  new \DateTime("now", $dateTimeZoneUTC );


        $difference = $dateFromGivenTime->diff($dateFromUTCTime);


        $minutes = $difference->days*24*60;
        $minutes += $difference->h*60;
        $minutes += $difference->i;

        return $minutes;
    }

    /**
     * @param $dateField
     * @return int
     */
    function februaryDaysCount($dateField):int
    {
        $timestamp = strtotime($dateField);
        $year = date('Y', $timestamp);
        $count =  (new \DateTime($year."-02-01"))->modify('Last day of this month')->format('d');

        return $count;

    }


    /**
     * @param $dateField
     * @return string
     */
    function nameOfMonth($dateField):string
    {
        $timestamp = strtotime($dateField);
        $year = date('Y-m-d', $timestamp);
        $name =  (new \DateTime($year."-02-01"))->format('F');

        return $name;
    }

    /**
     * @param $dateField
     * @return int
     */
    function numberOfDaysOfMonth($dateField):int
    {
        $timestamp = strtotime($dateField);
        $date = date('Y-m-d', $timestamp);
        $count =  (new \DateTime($date))->modify('Last day of this month')->format('d');

        return $count;
    }
}
