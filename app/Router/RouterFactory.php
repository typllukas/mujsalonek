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
		$router->addRoute('admin', 'Admin:admin');
		$router->addRoute('admin/add-portfolio-item', 'Admin:addPortfolioItem');
		$router->addRoute('admin/edit-portfolio-item/<id>', 'Admin:editPortfolioItem');
		$router->addRoute('blog', 'Blog:blog');
		$router->addRoute('contact', 'Contact:contact');
		$router->addRoute('portfolio', 'Portfolio:portfolio');
		$router->addRoute('portfolio/<id>', 'Portfolio:portfolioItem');
		$router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');

		return $router;
	}
}
