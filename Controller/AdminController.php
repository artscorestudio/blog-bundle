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

/**
 * Admin Controller
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class AdminController extends Controller
{
    /**
     * Homepage
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
    	if ( false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') )
    		throw new AccessDeniedException();
    	
        return $this->render('ASFBlogBundle:Admin:index.html.twig');
    }
}