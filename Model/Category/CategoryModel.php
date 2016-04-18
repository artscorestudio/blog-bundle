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
 * Blog Post Category Model
 *
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
abstract class CategoryModel implements CategoryInterface
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
	 * @var string
	 */
	protected $slug;
	
	/**
	 * @var \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	protected $parent;
	
	/**
	 * @var integer
	 */
	protected $menuOrder;
	
	/**
	 * @var boolean
	 */
	protected $isEnabled;
	
	public function __construct()
	{
		$this->isEnabled = false;
	}
	
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
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}
	
	/**
	 * @param string $slug
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}
	
	/**
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function getParent()
	{
		return $this->parent;
	}
	
	/**
	 * @param CategoryInterface $parent
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setParent(CategoryInterface $parent)
	{
		$this->parent = $parent;
		return $this;
	}
	
	/**
	 * @return number
	 */
	public function getMenuOrder()
	{
		return $this->menuOrder;
	}
	
	/**
	 * @param number $menuOrder
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setMenuOrder($menuOrder)
	{
		$this->menuOrder = $menuOrder;
		return $this;
	}
	
	/**
	 * @return boolean
	 */
	public function getIsEnabled()
	{
		return $this->isEnabled;
	}
	
	/**
	 * @param boolean $isEnabled
	 * @return \ASF\BlogBundle\Model\Category\CategoryInterface
	 */
	public function setIsEnabled($isEnabled)
	{
		$this->isEnabled = $isEnabled;
		return $this;
	}
}