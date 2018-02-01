<?php

namespace ShortUrlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Urls_table
 *
 * @ORM\Table(name="urls_table")
 * @ORM\Entity(repositoryClass="ShortUrlBundle\Repository\Urls_tableRepository")
 */
class Urls_table
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="long_url", type="string", length=500, unique=true)
     */
    private $longUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="short_url", type="string", length=255, unique=true)
     */
    private $shortUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="short_count", type="integer", nullable=true)
     */
    private $shortCount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_link", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"}))
     */
    private $dateLink;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set longUrl.
     *
     * @param string $longUrl
     *
     * @return Urls_table
     */
    public function setLongUrl($longUrl)
    {
        $this->longUrl = $longUrl;

        return $this;
    }

    /**
     * Get longUrl.
     *
     * @return string
     */
    public function getLongUrl()
    {
        return $this->longUrl;
    }

    /**
     * Set shortUrl.
     *
     * @param string $shortUrl
     *
     * @return Urls_table
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    /**
     * Get shortUrl.
     *
     * @return string
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * Set shortCount.
     *
     * @param int|null $shortCount
     *
     * @return Urls_table
     */
    public function setShortCount($shortCount)
    {
        $this->shortCount = $shortCount;

        return $this;
    }

    /**
     * Get shortCount.
     *
     * @return int
     */
    public function getShortCount()
    {
        return $this->shortCount;
    }

    /**
     * Set dateCreate.
     *
     * @param \DateTime $dateCreate
     *
     * @return Urls_table
     */
    public function setDateCreate($dateCreate)
    {
        // $dateCreate = new \DateTime(date('Y-m-d H:i:s')); // по умолчанию
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate.
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateLink.
     *
     * @param \DateTime|null $dateLink
     *
     * @return Urls_table
     */
    public function setDateLink($dateLink = null)
    {
        $this->dateLink = $dateLink;

        return $this;
    }

    /**
     * Get dateLink.
     *
     * @return \DateTime|null
     */
    public function getDateLink()
    {
        return $this->dateLink;
    }
}
