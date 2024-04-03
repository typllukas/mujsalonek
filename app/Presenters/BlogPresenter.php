<?php

declare(strict_types=1);

namespace App\Presenters;

use PDO;
use Nette;
use PDOException;
use Nette\Application\UI\Form;


final class BlogPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function renderBlog(): void
    {
        $this->template->posts = $this->database
            ->table('posts')
            ->order('created_at DESC')
            ->limit(6);
    }
}
