<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('about', 'About:about');
		$router->addRoute('blog', 'Blog:blog');
		$router->addRoute('contact', 'Contact:contact');
		$router->addRoute('portfolio', 'Portfolio:portfolio');
		$router->addRoute('portfolio/<id>', 'Portfolio:portfolioItem');
		$router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');

		return $router;
	}
}
