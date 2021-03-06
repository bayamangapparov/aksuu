<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * This file has been generated by the Sonata EasyExtends bundle ( https://sonata-project.org/bundles/easy-extends )
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;


    public function __toString()
    {
       if(sizeof($this->firstname) > 0 || sizeof($this->lastname) > 0){
           return $this->firstname.' '.$this->lastname;
       }
        else return $this->username;
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

}