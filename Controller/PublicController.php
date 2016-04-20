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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Default Controller gather generic app views
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class PublicController extends Controller
{
    /**
     * Blog Homepage
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ASFBlogBundle:Public:index.html.twig');
    }
    
    /**
     * Blog category Controller
     * 
     * @param string $path
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction($path)
    {
    	$path = str_replace('/blog', '', $path);
    	
    	$result = $this->get('asf_blog.category.manager')->getRepository()->findBySlug($path);
    	if ( count($result) == 0 ) {
    		throw new NotFoundHttpException('Ooops ! Blog category was not found.');
    	}
    	
    	$category = $result[0];
    	$posts = $this->get('asf_document.post.manager')->getRepository()->findByCategory($category);

    	return $this->render('ASFBlogBundle:Public:category-list.html.twig', array(
    		'category' => $category,
    		'posts' => $posts
    	));
    }
    
    /**
     * Blog post Controller
     *
     * @param string $path
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction($path, $_format)
    {
    	$path = str_replace(array('/blog', '.html'), '', $path);
    	$result = $this->get('asf_document.post.manager')->getRepository()->findBySlug($path);
    	if ( count($result) == 0 ) {
    		throw new NotFoundHttpException('Ooops ! This post was not found.');
    	}
    	 
    	$post = $result[0];
    	 
    	return $this->render('ASFBlogBundle:Public:post-view.html.twig', array(
   			'post' => $post
    	));
    }
}