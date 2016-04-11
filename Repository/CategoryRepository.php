<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Blog Category Entity Repository
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class CategoryRepository extends EntityRepository
{
	/**
	 * Find blog category by slug
	 *
	 * @param string $path
	 */
	public function findBySlug($path)
	{
		$qb = $this->createQueryBuilder('c');
		$qb instanceof QueryBuilder;
	
		$qb->add('where', $qb->expr()->like('c.slug', $qb->expr()->lower(':searched_term')))
			->setParameter('searched_term', $path);
	
		return $qb->getQuery()->getResult();
	}
}