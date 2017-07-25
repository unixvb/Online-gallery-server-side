<?php
/**
 * Created by PhpStorm.
 * User: unixv
 * Date: 25-Jul-17
 * Time: 09:36
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="picture")
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime", name="posted_at")
     */
    private $postedAt;
}