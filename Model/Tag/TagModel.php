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
 * Blog Post Tag Model
 *
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
abstract class TagModel implements TagInterface
{
	/**
	 * @var integer
	 */
	protected $id;
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 * @return \ASF\BlogBundle\Model\Tag\TagInterface
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
}