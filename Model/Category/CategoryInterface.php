<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Model\Category;

/**
 * Blog Post Category Interface
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
interface CategoryInterface
{	
	/**
	 * @return string
	 */
	public function getName();
	
	/**
	 * @param string $name
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setName($name);
	
	/**
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function getParent();
	
	/**
	 * @param CategoryInterface $parent
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setParent(CategoryInterface $parent);
	
	/**
	 * @return number
	 */
	public function getMenuOrder();
	
	/**
	 * @param number $menuOrder
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setMenuOrder($menuOrder);
}