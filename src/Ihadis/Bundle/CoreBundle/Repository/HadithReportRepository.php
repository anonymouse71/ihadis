<?php

namespace Ihadis\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ihadis\Bundle\CoreBundle\Entity\HadithReport;

/**
 * Hadith Report Repository
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class HadithReportRepository extends EntityRepository
{
    public function create($data)
    {
        $report = new HadithReport();

        $report->setIssue($data['issue']);
        $report->setComment($data['comments']);
        $report->setEmail($data['email']);

        $this->_em->persist($report);
        $this->_em->flush();
    }
} 