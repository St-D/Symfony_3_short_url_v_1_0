<?php

namespace ShortUrlBundle\Controller;

use ShortUrlBundle\ShortUrlBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use ShortUrlBundle\Entity\Urls_table;

class Web_functionsController extends Controller
{
    public function apiAction(Request $request)
    {

        $long_url = trim($request->query->get('long'));
        $short_url = trim($request->query->get('short'));

        //forward requests to another Controller:
        $json_from_controller = $this->forward('ShortUrlBundle:Form_handler:handler',
            array(
            "long_url" => $long_url,
            "short_url" => $short_url,
            ));


        //for debug ajax send
        $test_array = array
        (
            "l_url" => $long_url,
            "s_url" => $short_url,
            "db_er" => 1,
            "debug" => 'is test',
        );

        return $json_from_controller;
        //return new JsonResponse($test_array); // !!!!!!!!!!

    }

    public function resendAction($short_key)
    {
        //find {KEY} in DB:
        $em = $this->getDoctrine()->getManager();
        $get_query = $em
            ->getRepository('ShortUrlBundle:Urls_table')
            ->findOneBy(array
            (
                'shortUrl'  => $short_key,
            ));
        if ($get_query)
        {

            $long_url = $get_query ->getLongUrl();

            $short_count_inc = $get_query ->getShortCount() + 1;

            //UPDATE
            $get_query -> setDateLink(new \DateTime(date("Y-m-d")));
            $get_query -> setShortCount($short_count_inc);
            $em->flush();
            //~~~~~~

            return $this->redirect($long_url);
        }
        else
        {
            return $this->render('@ShortUrl/pages/error404.html.twig');
        }


    }
}
