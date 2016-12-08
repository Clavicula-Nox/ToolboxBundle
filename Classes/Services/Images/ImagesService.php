<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\Classes\Services\Images;

use ClaviculaNox\ToolboxBundle\Entity\Image;
use ClaviculaNox\ToolboxBundle\Entity\ImageAlias;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ImagesService
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Images
 */
class ImagesService
{
    private $Filesystem;
    private $EntityManager;

    /**
     * ImagesService constructor.
     * @param Filesystem $Filesystem
     * @param EntityManager $EntityManager
     */
    public function __construct(Filesystem $Filesystem, EntityManager $EntityManager)
    {
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

            $this->EntityManager->remove($alias);
        }

        $this->EntityManager->flush();
    }
}
