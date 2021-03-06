<?php

namespace AppBundle\Repository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository {

    public function fulltextQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->addSelect("MATCH_AGAINST (e.title, e.description) AGAINST(:q 'BOOLEAN') as HIDDEN score");
        $qb->andWhere("MATCH_AGAINST (e.title, e.description) AGAINST(:q 'BOOLEAN') > 0");
        
        $qb->innerJoin('e.projectPages', 'p');
        $qb->orWhere("MATCH_AGAINST (p.title, p.content) AGAINST(:q 'BOOLEAN') > 0");
        
        $qb->orderBy('score', 'desc');
        $qb->setParameter('q', $q);
        return $qb->getQuery();
    }

}
