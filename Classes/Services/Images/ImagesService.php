<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\CNToolboxBundle\Classes\Services\Images;

use ClaviculaNox\CNToolboxBundle\Entity\Image;
use ClaviculaNox\CNToolboxBundle\Entity\ImageAlias;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ImagesService
 * @package ClaviculaNox\CNToolboxBundle\Classes\Services\Images
 */
class ImagesService
{
    private $Container;
    private $Filesystem;
    private $EntityManager;

    /**
     * ImagesService constructor.
     * @param ContainerInterface $Container
     * @param Filesystem $Filesystem
     * @param EntityManager $EntityManager
     */
    public function __construct(ContainerInterface $Container, Filesystem $Filesystem, EntityManager $EntityManager)
    {
        $this->Container = $Container;
        $this->Filesystem = $Filesystem;
        $this->EntityManager = $EntityManager;
    }

    /**
     * @param Image $Image
     * @param string $alias
     * @return string
     */
    public function getWebPath(Image $Image, $alias = 'reference')
    {
        /* @var $alias ImageAlias */
        $alias = $this->getAliasEntity($Image->getId(), $alias);
        if (is_null($alias)) {
            return "";
        }

        return $alias->getWebPath();
    }

    /**
     * @param int $imageId
     * @param string $alias
     * @return null
     */
    public function getAliasEntity($imageId, $alias)
    {
        return $this->EntityManager->getRepository('CoreBundle:ImageAlias')->getFromImageIdAndAlias($imageId, $alias);
    }

    /**
     * @param Image $Image
     */
    public function synchronizeImage(Image $Image)
    {
        if ($Image->getDestinationFolderPath() != $Image->getFilepath()) {
            $imagePath = $Image->getAbsolutePath();
            $Image->setFilepath($Image->getFolderPathFromId());
            if (!$this->Filesystem->exists($Image->getAbsoluteFolderPath())) {
                $this->Filesystem->mkdir($Image->getAbsoluteFolderPath(), 0775);
            }

            $this->Filesystem->rename($imagePath, $Image->getAbsolutePath());
            $this->EntityManager->persist($Image);
            $this->EntityManager->flush();
        }
    }

    /**
     * @param Image $Image
     */
    public function preRemove(Image $Image)
    {
        foreach ($Image->getAliases() as $alias)
        {
            /* @var $alias ImageAlias */
            if ($this->Filesystem->exists($alias->getAbsolutePath())) {
                unlink($alias->getAbsolutePath());
            }
            //Todo : Maybe here we should delete the folder if it's empty ?

            $this->EntityManager->remove($alias);
            $this->EntityManager->flush();
        }
    }
}
