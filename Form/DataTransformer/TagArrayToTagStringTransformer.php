<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use ASF\BlogBundle\Utils\Manager\DefaultManagerInterface;

/**
 * Transform a tag array to a tag string
 *
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class TagArrayToTagStringTransformer implements DataTransformerInterface
{
    /**
     * @var DefaultManagerInterface
     */
    protected $tagManager;

    /**
     * @param DefaultManagerInterface $tagManager
     */
    public function __construct(DefaultManagerInterface $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($array)
    {
        if ($array === null) {
        	return '';
        }
        
        $return = array();
        foreach($array as $tag) {
        	$return[] = $tag->getName();
        }
        
        return implode(', ', $return);
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($string)
    {
    	$array = explode(',', $string);
    	$collection = new ArrayCollection();
    	foreach($array as $name) {
    		$tag = $this->tagManager->getRepository()->findOneBy(array('name' => trim($name)));
    		if ( $tag === null ) {
    			$tag = $this->tagManager->createInstance();
    			$tag->setName(trim($name));
    		}
    		$collection->add($tag);
    	}
        return $collection;
    }
}