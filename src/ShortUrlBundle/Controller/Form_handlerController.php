<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 27.01.2018
 * Time: 22:38
 */

namespace ShortUrlBundle\Controller;

use function PHPSTORM_META\type;
use ShortUrlBundle\Entity\Urls_table;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class Form_handlerController extends Controller
{

    protected function generateShortUrl($num_of_char)
        // $num_of_char - short url length
    {

        $arr = array
        (
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
            'p', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
            'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V',
            'W', 'X', 'Y', 'Z', 'F', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            '_'
        );

        do
        {
            $short_url = "";

            for ($i = 0; $i < $num_of_char; $i++)
            {
                $random = rand(0, count($arr) - 1);
                $short_url .= $arr[$random];
            }

            //checking existence of short url in DB:
            $em = $this->getDoctrine()->getManager();
            $get_short_url = $em
                ->getRepository('ShortUrlBundle:Urls_table')
                ->findOneBy(array
                (
                    'shortUrl' => $short_url
                ));


        }
        while($get_short_url);

        return $short_url;
    }


    public function formAction(Request $request)
    {
        $long_url = trim($request->request->get('l_url'));
        $short_url = trim($request->request->get('s_url'));

        if ($long_url or $short_url)
        {
        $json_for_ajax = $this -> handlerAction($long_url, $short_url);
        return $json_for_ajax;
        }

        # THIS rendered main_page #
        $page_title = 'Main Page';
        return $this->render('@ShortUrl/pages/main.html.twig',
            array
            (
                'page_title' => $page_title,
            )
        );
    }


    //public function newAction(Request $request)
    public function handlerAction($long_url, $short_url)
    {

        //$long_url = trim($request->request->get('l_url'));
        //$short_url = trim($request->request->get('s_url'));

        // Both fields are filled:
        if ($long_url != "" && $short_url != "")
        {
            $response_array = $this-> fieldsLongShort($long_url, $short_url);
            return new JsonResponse($response_array);
        }

        // Only long URL filled:
        elseif ($long_url != "" && $short_url == "")
        {
            $response_array = $this-> fieldsLongOnly($long_url);
            return new JsonResponse($response_array);
        }

        // Only long URL filled:
        elseif ($long_url == "" && $short_url != "")
        {
            $response_array = $this-> fieldsShortOnly($short_url);
            return new JsonResponse($response_array);
        }

        //empty fields:
        //not use now
        else
        {
            $response_array = array
            (
            "l_url" => 'ND',
            "s_url" => 'ND',
            "db_er" => 1,
            "debug" => 'fields is empty, focus on LONG_URL field',
            );
            #return new JsonResponse($response_array);
        }
    }


    protected function fieldsLongShort($long_url, $short_url)
    {
        //get value from short_url after "/" by end
        $short_url = substr(strrchr($short_url, '/'), 1, strlen($short_url));

        //urls validation:
        $check_valid = new UrlValidator();
        $check_valid -> long_url_validator = $long_url;
        $check_valid -> short_url_validator = $short_url;

        $validator = $this->get('validator');
        $errors = $validator->validate($check_valid);

        if (count($errors) > 0)
        {
            $errors_str = (string)$errors;
            $ar_debug = $errors_str;
            $ar_er = 2;
        }
        ///////////////////

        // if URLs valid:
        else
        {

            $em = $this->getDoctrine()->getManager();
            $get_query = $em
                ->getRepository('ShortUrlBundle:Urls_table')
                ->findOneBy(array
                (
                    'shortUrl' => $short_url,
                    'longUrl'  => $long_url,
                ));


            if ($get_query)
                // оба поля совпали с данными БД:
            {
                $ar_er = 20;
                $ar_debug = "URL's is valid";
            }
            else
            {
                $ar_er = 2;
                $ar_debug = 'One of the entered fields is invalid';
            }
        }

        return array
        (
            "l_url" => $long_url,
            "s_url" => $short_url,
            "db_er" => $ar_er,
            "debug" => $ar_debug,
        );

    }


    protected function fieldsLongOnly($long_url)
    {
        //urls validation:
        $check_valid = new UrlValidator();
        $check_valid -> long_url_validator = $long_url;

        $validator = $this->get('validator');
        $errors = $validator->validate($check_valid);

        if (count($errors) > 0)
        {
            $errors_str = (string)$errors;
            $ar_debug = $errors_str;
            $ar_er = 2;
            $short_url = 'ND';
        }
        //~~~~~~~~~~~~~~//

        // if Long URL is valid:
        else
        {
            //check long Url in DB:
            // if URLs valid:
            $em = $this->getDoctrine()->getManager();
            $get_query = $em
                ->getRepository('ShortUrlBundle:Urls_table')
                ->findOneBy(array
                (
                    'longUrl'  => $long_url,
                ));

            // Long Url exist in DB
            if($get_query)
            {
                $short_key = $get_query ->getShortUrl();
                $short_url = $_SERVER['HTTP_HOST'].'/'.$short_key;

                $ar_er = 0;
                $ar_debug = 'Send ShortURL to main page from DB';

            }
            // Long Url does't exist in DB
            else
            {
                //create Short Url
                $short_key = $this -> generateShortUrl(3);
                $short_url = $_SERVER['HTTP_HOST'].'/'.$short_key;
                //~~~~~~~~~~~~~~~//

                //INSERT entry in DB

                $url_fields = new Urls_table();
                $url_fields ->setLongUrl($long_url);
                $url_fields ->setShortUrl($short_key);
                $url_fields ->setDateCreate(new \DateTime(date("Y-m-d")));

                $em->persist($url_fields);
                $em->flush();
                //~~~~~~~~~~~~~~~~~~

                $ar_er = 0;
                $ar_debug = 'Create and send ShortURL to main page';
            }
        }

        return array
        (
            "l_url" => $long_url,
            "s_url" => $short_url,
            "db_er" => $ar_er,
            "debug" => $ar_debug,
        );
    }

    protected function fieldsShortOnly($short_url)
    {
        $short_key = substr(strrchr($short_url, '/'), 1, strlen($short_url));
        //urls validation:
        $check_valid = new UrlValidator();
        $check_valid -> short_url_validator = $short_key;

        $validator = $this->get('validator');
        $errors = $validator->validate($check_valid);

        if (count($errors) > 0)
        {
            $errors_str = (string)$errors;
            $ar_debug = $errors_str;
            $ar_er = 4;
            $long_url = 'ND';
        }
        //~~~~~~~~~~~~~~//
        else
        {
            //check short Url in DB:
            // if URLs valid:
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
                $ar_er = 10;
                $ar_debug = 'Long URL send from DB to form';
            }
            else
            {
                $long_url = 'ND';
                $ar_er = 4;
                $ar_debug = 'Short URL not found';
            }
        }

        return array
        (
            "l_url" => $long_url,
            "s_url" => $short_url,
            "db_er" => $ar_er,
            "debug" => $ar_debug,
        );
    }


    // not use
    public function indexAction()
    {
        # THIS rendered main_page
        $page_title = 'Main Page';
        return $this->render('@ShortUrl/pages/main.html.twig',
            array
            (
                'page_title' => $page_title,
            )
        );
    }

    // not use
    public function testingAction(Request $request)
    {
        $long_url = $request->request->get('l_url');
        $short_url = $request->request->get('s_url');

        //if($l_url)
            if(true) {
                $response_array = array
                (
                    "l_url" => 'ND' . $long_url,
                    "s_url" => 'test RESPONSE' . $short_url,
                    "db_er" => 1,
                    "debug" => 'fields is empty, focus on LONG_URL field',

                );

                //return new JsonResponse($response_array);
                return $this->json($response_array);
            }
    }

}