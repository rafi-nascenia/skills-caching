<?php
/**
 * @author Rafi Adnan <rafi@nascenia.com>
 * @since 2014-11-05
 * @version 2014-11-05
 */

namespace Nascenia\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Sample
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;
}
