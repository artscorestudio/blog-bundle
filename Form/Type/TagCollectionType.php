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

use ASF\BlogBundle\Utils\Manager\DefaultManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use ASF\BlogBundle\Form\DataTransformer\TagArrayToTagStringTransformer;

/**
 * Blog Tag Collection Form
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class TagCollectionType extends AbstractType
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
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addModelTransformer(new TagArrayToTagStringTransformer($this->tagManager));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'entry_type' => TagType::class,
			'allow_add' => true,
			'allow_delete' => true,
			'translation_domain' => 'asf_blog',
			'attr' => array('class' => 'tags-input-field')
		));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::getName()
	 */
	public function getName()
	{
		return 'blog_tag_collection_type';
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::getParent()
	 */
	public function getParent()
	{
		return CollectionType::class;
	}
}