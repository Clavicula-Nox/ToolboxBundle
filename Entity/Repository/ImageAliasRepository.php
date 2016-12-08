<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\Entity\Repository;

use ClaviculaNox\ToolboxBundle\Entity\ImageAlias;
use Doctrine\ORM\EntityRepository;

/**
 * Class ImageAliasRepository
 * @package ClaviculaNox\ToolboxBundle\Entity\Repository
 */
class ImageAliasRepository extends EntityRepository
{
    /**
     * @param int $imageId
     * @param string $alias
     * @return null|ImageAlias
     */
    public function getFromImageIdAndAlias($imageId, $alias)
    {
        $return = $this->createQueryBuilder('ia')
            ->where('ia.image = :id')
            ->andWhere('ia.aliasName = :aliasName')
            ->setParameter('id', $imageId)
            ->setParameter('aliasName', $alias)
            ->getQuery()->getResult()
        ;

        if (isset($return[0])) {
            return $return[0];
        }

        return null;
    }
}
