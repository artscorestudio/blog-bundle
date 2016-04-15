<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Model\Tag;

/**
 * Blog Post Category Interface
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
interface TagInterface
{	
	/**
	 * @return string
	 */
	public function getName();
	
	/**
	 * @param string $name
	 * @return \ASF\BlogBundle\Model\Tag\TagInterface
	 */
	public function setName($name);
}