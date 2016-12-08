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

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#Annotations
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @package ClaviculaNox\CNToolboxBundle\Entity
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="ClaviculaNox\CNToolboxBundle\Entity\Repository\ImageRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    const ROOT_DIR = "images/";

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", options={"default":""})
     */
    protected $title = '';

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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ImageAlias", mappedBy="image")
     **/
    protected $aliases;

    /**
     * Unmapped properties to handle file uploads
     */
    protected $file;
    protected $FilePathForRemove;
    protected $displayFilePath;

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
     * @throws \Exception
     */
    protected function getDestinationDir()
    {
        return $this->getRootDir() . $this->getDestinationFolderPath();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDestinationFolderPath()
    {
        return $this->getFolderPathFromId();
    }

    /**
     * @param $id
     * @return string
     */
    public function getFolderPathFromId($id = null)
    {
        if (is_null($id)) {
            $id = $this->getId();
        }

        $string = (string) $id;
        $return = '';

        foreach (str_split($string) as $part)
        {
            $return .= $part . "/";
        }

        return $return;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        /**
         * Done to be sure to trigger PrePersist event
         */
        if (!is_null($file)) {
            $this->setFilePathForRemove($this->getFilepath() . $this->getFilename());
            $this->setFilename('');
            $this->setFilepath('');
        }
    }

    /**
     * @return string
     */
    public function getFilePathForRemove()
    {
        return $this->FilePathForRemove;
    }

    /**
     * @param string $FilePathForRemove
     */
    public function setFilePathForRemove($FilePathForRemove)
    {
        $this->FilePathForRemove = $FilePathForRemove;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        if ($this->getFilepath() == "") {
            return $this->getAbsoluteFolderPath() . $this->getFilename();
        } else {
            return $this->getAbsoluteFolderPath(). $this->getFilename();
        }
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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadFile()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->cleanupFiles();
        $fileInfos = pathinfo($this->getFile()->getClientOriginalName());
        $fileName = Urlizer::urlize($fileInfos['filename']) . '.' . $fileInfos['extension'];

        $this->getFile()->move(
            $this->getDestinationDir(),
            $fileName
        );

        $this->setFilename($fileName);
        $this->setFilepath($this->getDestinationFolderPath());
        $this->setFile(null);
    }

    /**
     * @ORM\PostRemove()
     */
    public function cleanupFiles()
    {
        if ($this->getFilePathForRemove() != '') {
            unlink(Image::ROOT_DIR . $this->getFilePathForRemove());
        }
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdated(new \DateTime("now"));
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
    public function __toString()
    {
        return $this->getTitle() == "" ? $this->getFilepath() . '/' . $this->getFilename() : $this->getTitle();
    }

    /**
     * @return ArrayCollection
     */
    public function getAliases()
    {
        if (is_null($this->aliases)) {
            return new ArrayCollection();
        }

        return $this->aliases;
    }

    /**
     * @param ArrayCollection|array $aliases
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDisplayFilePath()
    {
        return Image::ROOT_DIR . $this->getFilepath() . $this->getFilename();
    }

    /**
     * @param string $displayFilePath
     */
    public function setDisplayFilePath($displayFilePath)
    {

    }
}
