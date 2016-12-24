<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\Classes\Services\Tools;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EmailManager
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Tools
 */
class EmailManager
{
    protected $Container;

    /**
     * EmailManager constructor.
     * @param ContainerInterface $Container
     */
    public function __construct(ContainerInterface $Container)
    {
        $this->Container = $Container;
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function validateEmail($email)
    {
        $validator = $this->Container->get('validator');

        $constraints = array(
            new \Symfony\Component\Validator\Constraints\Email(),
            new \Symfony\Component\Validator\Constraints\NotBlank()
        );

        $error = $validator->validate($email, $constraints);

        if (count($error) > 0) {
            return false;
        }

        return true;
    }
}
