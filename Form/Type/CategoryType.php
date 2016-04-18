<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use ASF\BlogBundle\Entity\Manager\ASFBlogEntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Blog Category Form
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class CategoryType extends AbstractType
{
    /**
     * @var ASFBlogEntityManagerInterface
     */
    protected $categoryManager;
    
    /**
     * @param ASFBlogEntityManagerInterface $categoryManager
     */
    public function __construct(ASFBlogEntityManagerInterface $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }
    
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', TextType::class, array(
			'label' => 'Category name',
			'required' => true,
			'attr' => array('class' => 'category-name')
		))
		->add('slug', TextType::class, array(
			'label' => 'Slug',
			'required' => true,
			'attr' => array('class' => 'category-slug')
		))
		->add('isEnabled', ChoiceType::class, array(
			'label' => 'State',
			'choices' => array(
				'Enabled' => true,
				'disabled' => false
			)
		))
		->add('parent', EntityType::class, array(
			'class' => $this->categoryManager->getClassName(),
			'choice_label' => 'name',
			'label' => 'Parent',
			'placeholder' => 'Choose a parent',
			'choice_attr' => function($category) {
				return array('data-slug' => $category->getSlug());
			},
			'required' => false,
			'choice_value' => function($category) {
				if ( is_null($category) )
					return;
		
				return $category->getId();
			},
			'attr' => array('class' => 'select2-entity parent-box')
		))
		->add('menuOrder', NumberType::class, array(
			'label' => 'Category order',
			'required' => true
		));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => $this->categoryManager->getClassName(),
			'translation_domain' => 'asf_blog'
		));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::getName()
	 */
	public function getName()
	{
		return 'blog_category_type';
	}
}