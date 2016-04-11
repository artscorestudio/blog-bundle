<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use ASF\BlogBundle\DependencyInjection\Configuration;

/**
 * This test case check if the default bundle's configuration from bundle's Configuration class is OK
 *  
 * @author Nicolas Claverie <info@artscore-studio.fr
 *
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var array
	 */
	private $defaultConfig;
	
	/**
	 * {@inheritDoc}
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		$processor = new Processor();
		$this->defaultConfig = $processor->processConfiguration(new Configuration(), array());
	}
	
    /**
     * @covers ASF\BlogBundle\DependencyInjection\Configuration
     */
	public function testDefaultConfiguration()
	{
		$this->assertCount(2, $this->defaultConfig);
	}
	
	/**
	 * @covers ASF\BlogBundle\DependencyInjection\Configuration::addCategoryParameterNode
	 */
	public function testConfigLoadFormName()
	{
		$this->assertEquals('ASF\BlmogBundle\Form\Type\CategoryType', $this->defaultConfig['category']['form']['type']);
		$this->assertEquals('blog_category_type', $this->defaultConfig['category']['form']['name']);
	}
}