<?php

namespace ShortUrlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ShortUrlBundle\Entity\Urls_table;

class Web_pagesController extends Controller
{
    public function aboutAction()
    {
        $name = 'about us';
        $mail = 'stastastas@mail.ru';
        $date_content = date("d.m.Y");

        return $this->render('@ShortUrl/pages/about.html.twig',
            array(
                'page_title' => $name,
                'contact_mail' => $mail,
                'cur_date' => $date_content
                ));
    }

    public function statisticsAction()
    {
        $name = 'statistics';

        $em = $this->getDoctrine()->getManager();
        $urls_tables = $em->getRepository('ShortUrlBundle:Urls_table')->findAll();

        return $this->render('@ShortUrl/pages/statistics.html.twig',
            array(
                'page_title' => $name,
                'urls_tables' => $urls_tables,
                'host_name' => $_SERVER['HTTP_HOST'],
                'host_postfix' => '/',
                ));
    }

    public function api_infoAction()
    {
        $name = 'for web masters';

        return $this->render('@ShortUrl/pages/for_web_masters.html.twig',
            array('page_title' => $name));
    }
}
