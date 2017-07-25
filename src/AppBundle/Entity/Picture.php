<?php
/**
 * Created by PhpStorm.
 * User: unixv
 * Date: 25-Jul-17
 * Time: 09:36
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="picture")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Please upload a JPEG, JPG or PNG file",
     *     maxSizeMessage = "File size must be less than 1M"
     * )
     * @Vich\UploadableField(mapping="images", fileNameProperty="imageName")
     * @var File
     */
    private $imageFile;

    /**
     *  @ORM\Column(type="string")
     *  @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime", name="posted_at")
     * @var \DateTime
     */
    private $postedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return Picture
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->postedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return Picture
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return \DateTime
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * @param \DateTime $postedAt
     */
    public function setPostedAt($postedAt)
    {
        $this->postedAt = $postedAt;
    }
}