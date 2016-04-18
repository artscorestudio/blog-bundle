<?php
/**
 * This file is part of Artscore Studio Framework Package
 *
 * (c) 2012-2015 Artscore Studio <info@artscore-studio.fr>
 *
 * This source file is subject to the MIT Licence that is bundled
 * with this source code in the file LICENSE.
 */
namespace ASF\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
    	$treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('asf_blog');

        $rootNode
	        ->children()
	        	->scalarNode('form_theme')
	        		->defaultValue('ASFBlogBundle:Form:fields.html.twig')
	        	->end()
	        	->append($this->addCategoryParameterNode())
	        	->append($this->addTagParameterNode())
	        ->end();
        
        return $treeBuilder;
    }
    
    /**
     * Add Blog Category Entity Configuration
     */
    protected function addCategoryParameterNode()
    {
    	$builder = new TreeBuilder();
    	$node = $builder->root('category');
    
    	$node
	    	->treatTrueLike(array('form' => array(
	    		'type' => "ASF\BlogBundle\Form\Type\CategoryType",
	    		'name' => 'blog_category_type'
	    	)))
	    	->treatFalseLike(array('form' => array(
	    		'type' => "ASF\BlogBundle\Form\Type\CategoryType",
	    		'name' => 'blog_category_type'
	    	)))
	    	->addDefaultsIfNotSet()
	    	->children()
		    	->arrayNode('form')
			    	->addDefaultsIfNotSet()
			    	->children()
				    	->scalarNode('type')
				    		->defaultValue('ASF\BlogBundle\Form\Type\CategoryType')
				    	->end()
				    	->scalarNode('name')
				    		->defaultValue('blog_category_type')
				    	->end()
				    	->arrayNode('validation_groups')
				    		->prototype('scalar')->end()
				    		->defaultValue(array("Default"))
				    	->end()
				    ->end()
		    	->end()
	    	->end()
    	;
    
    	return $node;
    }
    
    /**
     * Add Blog Tag Entity Configuration
     */
    protected function addTagParameterNode()
    {
    	$builder = new TreeBuilder();
    	$node = $builder->root('tag');
    
    	$node
	    	->treatTrueLike(array('form' => array(
	    		'type' => "ASF\BlogBundle\Form\Type\TagType",
	    		'name' => 'blog_tag_type'
	    	)))
	    	->treatFalseLike(array('form' => array(
	    		'type' => "ASF\BlogBundle\Form\Type\TagType",
	    		'name' => 'blog_tag_type'
	    	)))
	    	->addDefaultsIfNotSet()
	    	->children()
		    	->arrayNode('form')
			    	->addDefaultsIfNotSet()
			    	->children()
				    	->scalarNode('type')
				    		->defaultValue('ASF\BlogBundle\Form\Type\TagType')
				    	->end()
				    	->scalarNode('name')
				    		->defaultValue('blog_tag_type')
				    	->end()
				    	->arrayNode('validation_groups')
				    		->prototype('scalar')->end()
				    		->defaultValue(array("Default"))
				    	->end()
			    	->end()
		    	->end()
	    	->end()
    	;
    
    	return $node;
    }
}
