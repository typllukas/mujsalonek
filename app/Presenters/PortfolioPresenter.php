<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class PortfolioPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function renderPortfolio(): void
    {
        $this->template->portfolio = $this->database
            ->table('portfolio')
            ->order('order ASC')
            ->limit(12);
    }
}
