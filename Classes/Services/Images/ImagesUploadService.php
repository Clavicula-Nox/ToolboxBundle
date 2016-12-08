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

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ImagesUploadService
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Images
 */
class ImagesUploadService
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
}
