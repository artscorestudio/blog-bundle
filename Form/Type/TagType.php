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

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Blog Tag Form
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class TagType extends AbstractType
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
		$builder->add('name', TextType::class, array(
			'label' => 'Tag name',
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
			'data_class' => $this->tagManager->getClassName(),
			'translation_domain' => 'asf_blog'
		));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Form\AbstractType::getName()
	 */
	public function getName()
	{
		return 'blog_tag_type';
	}
}