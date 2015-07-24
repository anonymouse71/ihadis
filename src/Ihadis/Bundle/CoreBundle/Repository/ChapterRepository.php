<?php

namespace Ihadis\Bundle\CoreBundle\Repository;

use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * ChapterRepository
 *
 * Repository extending EntityRepository SyliusResourceBundle
 */
class ChapterRepository extends EntityRepository
{
    public function getSectionsWithHadis(Chapter $chapter, $limit = 20, $offset = 0)
    {
        return $this->_em->createQueryBuilder()
            ->select('s')
            ->from('IhadisCoreBundle:Section', 's')
            ->leftJoin('s.hadiths', 'h')
            ->where('s.chapter = :chapter')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('chapter', $chapter)
            ->getQuery()
            ->getResult();
    }
}
