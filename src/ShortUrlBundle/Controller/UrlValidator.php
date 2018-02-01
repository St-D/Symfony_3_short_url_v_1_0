<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 30.01.2018
 * Time: 0:30
 */

namespace ShortUrlBundle\Controller;
use Symfony\Component\Validator\Constraints as Assert;


class UrlValidator
{

    /**
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     *    protocols = {"http", "https", "ftp"},
     *
     *    checkDNS = true,
     *    dnsMessage = "The host '{{ value }}' could not be resolved"
     * )
     */
    public $long_url_validator;


    /**
     * @Assert\Length(
     *      min = 3,
     *      max = 3,
     *      exactMessage = "This value contains the wrong number of characters"
     *
     * )
     */
    public $short_url_validator;


}