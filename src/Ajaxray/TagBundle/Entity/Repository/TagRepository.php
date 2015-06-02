<?php

namespace Ajaxray\TagBundle\Entity\Repository;

use Ajaxray\TagBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * TagRepository
 */
class TagRepository extends EntityRepository
{

    public function getByName($tagName)
    {
        $tag = $this->findOneByName($tagName);
        return $tag ?: new Tag($tagName);
    }
//    /**
//     * Get Hadiths by Section
//     */
//    public function getBySectionId($sectionId)
//    {
//        $result = $this->createQueryBuilder('h')
//                    ->where('h.section = :section')
//                    ->setParameter('section', $sectionId)
//                    ->orderBy('h.numberPrimary', 'asc')
//                    ->getQuery()
//                    ->getResult();
//
//        return $result;
//    }
}