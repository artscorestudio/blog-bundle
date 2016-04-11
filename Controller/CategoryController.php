<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\QueryBuilder;

use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use ASF\BlogBundle\Form\Handler\CategoryFormHandler;

/**
 * Blog Category Controller
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class CategoryController extends Controller
{
	/**
	 * List all blog category
	 *
	 * @throws AccessDeniedException If authenticate user is not allowed to access to this resource (minimum ROLE_ADMIN)
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction()
	{
		if ( false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') )
			throw new AccessDeniedException();
	
		// Set Datagrid source
		$source = new Entity($this->get('asf_blog.cateogry.manager')->getClassName());
		$tableAlias = $source->getTableAlias();
		$source->manipulateQuery(function($query) use ($tableAlias){
			$query instanceof QueryBuilder;

			if ( count($query->getDQLPart('orderBy')) == 0) {
				$query->orderBy($tableAlias . '.name', 'ASC');
			}
		});

		// Get Grid instance
		$grid = $this->get('grid');
		$grid instanceof Grid;

		// Attach the source to the grid
		$grid->setSource($source);
		$grid->setId('asf_blog_category_list');

		// Columns configuration
		$grid->hideColumns(array('id'));
	
		$grid->getColumn('name')->setTitle($this->get('translator')->trans('Blog category name', array(), 'asf_blog'))
			->setDefaultOperator('like')
			->setOperatorsVisible(false);

		$editAction = new RowAction('btn_edit', 'asf_blog_category_edit');
		$editAction->setRouteParameters(array('id'));
		$grid->addRowAction($editAction);

		$deleteAction = new RowAction('btn_delete', 'asf_blog_category_delete', true);
		$deleteAction->setRouteParameters(array('id'))
			->setConfirmMessage($this->get('translator')->trans('Do you want to delete this category?', array(), 'asf_blog'));
		$grid->addRowAction($deleteAction);
	
		$grid->setNoDataMessage($this->get('translator')->trans('No blog category was found.', array(), 'asf_blog'));
	
		return $grid->getGridResponse('ASFBlogBundle:Category:list.html.twig');
	}
	
	/**
	 * Add or edit a blog category
	 *
	 * @param Request $request
	 * @param integer $id           ASFBlogBundle:Category Entity ID
	 *
	 * @throws AccessDeniedException If authenticate user is not allowed to access to this resource (minimum ROLE_ADMIN)
	 * @throws \Exception            Error on group not found
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editAction(Request $request, $id = null)
	{
		if ( false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') )
			throw new AccessDeniedException();
		  
		$formFactory = $this->get('asf_blog.form.factory.category');
		$categoryManager = $this->get('asf_blog.category.manager');
		  
		if ( !is_null($id) ) {
			$category = $categoryManager->getRepository()->findOneBy(array('id' => $id));
			$success_message = $this->get('translator')->trans('Updated successfully', array(), 'asf_blog');
				
		} else {
			$category = $categoryManager->createInstance();
			$category->setName($this->get('translator')->trans('New blog category', array(), 'asf_blog'))->setSlug($this->get('translator')->trans('new-blog-category', array(), 'asf_blog'));
			$success_message = $this->get('translator')->trans('Created successfully', array(), 'asf_blog');
		}
	
		if ( is_null($config) )
			throw new \Exception($this->get('translator')->trans('An error occurs when generating or getting the category', array(), 'asf_website'));

		$form = $formFactory->createForm();
		$form->setData($config);
		
		$formHandler = new CategoryFormHandler($form, $request, $this->container);
		
		if ( true === $formHandler->process() ) {
			try {
				if ( is_null($category->getId()) ) {
					$categoryManager->getEntityManager()->persist($category);
				}
				$categoryManager->getEntityManager()->flush();
				 
				$this->get('asf_layout.flash_message')->success($success_message);

				return $this->redirect($this->get('router')->generate('asf_blog_category_edit', array('id' => $category->getId())));

			} catch(\Exception $e) {
				$this->get('asf_layout.flash_message')->danger($e->getMessage());
			}
		}

		return $this->render('ASFBlogBundle:Category:edit.html.twig', array(
			'category' => $category,
			'form' => $form->createView()
		));
	}
	
	/**
	 * Delete a blog category
	 *
	 * @param  integer $id           ASFBlogBundle:Category Entity ID
	 * 
	 * @throws AccessDeniedException If authenticate user is not allowed to access to this resource (minimum ROLE_ADMIN)
	 * @throws \Exception            Error on Config not found or on removing element from DB
	 * 
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function deleteAction($id)
	{
		if ( false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') )
			throw new AccessDeniedException();
		  
		$categoryManager = $this->get('asf_blog.category.manager');
		$category = $categoryManager->getRepository()->findOneBy(array('id' => $id));

		try {
			$categoryManager->getEntityManager()->remove($category);
			$categoryManager->getEntityManager()->flush();
			
			$this->get('asf_layout.flash_message')->success($this->get('translator')->trans('The blog category "%name%" successfully deleted.', array('%name%' => $config->getName()), 'asf_blog'));
				
		} catch (\Exception $e) {
			$this->get('asf_layout.flash_message')->danger($e->getMessage());
		}

		return $this->redirect($this->get('router')->generate('asf_blog_category_list'));
	}
}