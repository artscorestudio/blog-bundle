<?php
/*
 * This file is part of the Artscore Studio Framework package.
 *
 * (c) 2012-2015 Nicolas Claverie <info@artscore-studio.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ASF\BlogBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Matcher\Voter\RouteVoter;

use ASF\BackendBundle\Event\BackendEvents;
use ASF\BackendBundle\Event\SidebarMenuEvent;
use ASF\WebsiteBundle\Event\WebsiteEvents;
use ASF\WebsiteBundle\Event\PrimaryMenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use ASF\DocumentBundle\Entity\Manager\ASFDocumentEntityManagerInterface;

/**
 * Menu Subscriber
 * 
 * @author Nicolas Claverie <info@artscore-studio.fr>
 *
 */
class MenuSubscriber implements EventSubscriberInterface
{
	/**
	 * @var RequestStack
	 */
	protected $request;
	
	/**
	 * @var TranslatorInterface
	 */
	protected $translator;
	
	/**
	 * @var EventDispatcherInterface
	 */
	protected $eventDispatcher;
	
	/**
	 * @var ASFDocumentEntityManagerInterface
	 */
	protected $postManager;
	
	/**
	 * @param RequestStack                      $request
	 * @param TranslatorInterface               $translator
	 * @param EventDispatcherInterface          $eventDispatcher
	 * @param ASFDocumentEntityManagerInterface $postManager
	 */
	public function __construct(RequestStack $request, TranslatorInterface $translator, EventDispatcherInterface $eventDispatcher, ASFDocumentEntityManagerInterface $postManager)
	{
		$this->request = $request;
		$this->translator = $translator;
		$this->eventDispatcher = $eventDispatcher;
		$this->postManager = $postManager;
	}
	
	/**
	 * Subscribed Events
	 */
	public static function getSubscribedEvents()
	{
		return array(
			BackendEvents::SIDEBAR_MENU_INIT => array('onSidebarMenuInit', 0),
			WebsiteEvents::PRIMARY_MENU_INIT => array('onPrimaryMenuInit', 0),
			DocumentEvents::POST_MENU_INIT   => array('onPostMenuInit', 0)
		);
	}

	/**
	 * @param NavbarMenuEvent $event
	 */
	public function onSidebarMenuInit(SidebarMenuEvent $event)
	{
		$menu = $event->getMenu();
		$factory = $event->getFactory();
		
		$matcher = new Matcher();
		$matcher->addVoter(new RouteVoter($this->request->getCurrentRequest()));
		
		$homepage = $factory->createItem($this->translator->trans('Blog Manager', array(), 'asf_blog'), array('route' => 'asf_blog_admin_homepage'));
		$menu->addChild($homepage);
		$homepage->setCurrent($matcher->isCurrent($homepage));
		
		// Post list link
		$post_category_list = $factory->createItem($this->translator->trans('Post Category list', array(), 'asf_blog'), array('route' => 'asf_blog_post_category_list'));
		$homepage->addChild($post_category_list);
		$post_category_list->setCurrent($matcher->isCurrent($post_category_list));
	}

	/**
	 * @param PrimaryMenuEvent $event
	 */
	public function onPrimaryMenuInit(PrimaryMenuEvent $event)
	{
		$menu = $event->getMenu();
		$factory = $event->getFactory();
		
		$matcher = new Matcher();
		$matcher->addVoter(new RouteVoter($this->request->getCurrentRequest()));
		
		$categories = $this->postManager->getRepository()->getRootCategory();
		
		foreach($categories as $category) {
			$item = $factory->createItem($category->getName(), array('route' => 'asf_blog_public_post_route', 'routeParameters' => array('path' => $category->getSlug())));
			$this->eventDispatcher->dispatch(
				BlogEvents::POST_CATEGORY_MENU_INIT,
				new PostCategoryMenuEvent($item, $factory, $category->getId())
			);
			$menu->addChild($item);
			$item->setCurrent($matcher->isCurrent($item));
		}
	}
	
	/**
	 * @param PageMenuEvent $event
	 */
	public function onPageMenuInit(PageMenuEvent $event)
	{
		$menu = $event->getMenu();
		$factory = $event->getFactory();
		$parentId = $event->getParentId();
		
		$matcher = new Matcher();
		$matcher->addVoter(new RouteVoter($this->request->getCurrentRequest()));
		
		$pages = $this->pageManager->getRepository()->getMenuChildren($parentId);
		
		foreach($pages as $page) {
			$item = $factory->createItem($page->getTitle(), array('route' => 'asf_website_public_page_route', 'routeParameters' => array('path' => $page->getSlug())));
			$this->eventDispatcher->dispatch(
				DocumentEvents::PAGE_MENU_INIT,
				new PageMenuEvent($item, $factory, ( is_null($page->getOriginal()) ? $page->getId() : $page->getOriginal()->getId() ))
			);
			$item->setExtra('orderNumber', $page->getMenuOrder());
			$menu->addChild($item);
			$item->setCurrent($matcher->isCurrent($item));
		}
	}
}