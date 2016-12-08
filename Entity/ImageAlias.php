<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\CNToolboxBundle\Entity;

#Annotations
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @package ClaviculaNox\CNToolboxBundle\Entity
 *
 * @ORM\Entity(repositoryClass="ClaviculaNox\CNToolboxBundle\Entity\Repository\ImageAliasRepository")
 * @ORM\Table(name="images_alias")
 */
class ImageAlias
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, options={"default":""})
     */
    protected $filename = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, options={"default":""})
     */
    protected $filepath = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, options={"default":""})
     */
    protected $aliasName = '';

    /**
     * @var Image
     *
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="aliases")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     **/
    protected $image;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @return string
     * @deprecated
     * This is not a good idea...
     */
    protected function getRootDir()
    {
        return Image::ROOT_DIR;
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return $this->getAbsoluteFolderPath(). $this->getFilename();
    }

    /**
     * @return string
     */
    public function getAbsoluteFolderPath()
    {
        if ($this->getFilepath() == "") {
            return __DIR__ . "/../../../web/" . $this->getRootDir();
        } else {
            return __DIR__ . "/../../../web/" . $this->getRootDir() . $this->getFilepath();
        }
    }

    public function getWebPath()
    {
        if ($this->getFilepath() == "") {
            return "/" . $this->getRootDir() . $this->getFilename();
        } else {
            return "/" . $this->getRootDir(). $this->getFilepath() . $this->getFilename();
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
    public function getAliasName()
    {
        return $this->aliasName;
    }

    /**
     * @param string $aliasName
     */
    public function setAliasName($aliasName)
    {
        $this->aliasName = $aliasName;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFilename();
    }
}
