<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class AdminPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function renderAdmin(): void
    {
        $this->template->portfolio = $this->database
            ->table('portfolio');
    }

    protected function createComponentPortfolioItemForm(): Form
    {
        $form = new Form;
        $form->addText('title', 'Title:')
            ->setRequired();
        $form->addText('subtitle', 'Subtitle:')
            ->setRequired();
        $form->addTextArea('text', 'Text:')
            ->setRequired();
        $form->addText('order', 'Order:')
            ->setHtmlType('number')
            ->addRule($form::INTEGER, 'The field must be a numeric value.')
            ->setRequired();
        $form->addUpload('image', 'Portfolio Image (800x533px):')
            ->setRequired('Please upload an image.')
            ->addRule($form::IMAGE, 'Portfolio image must be JPEG or PNG.')
            ->addRule($form::MAX_FILE_SIZE, 'Maximum file size is 10 MB.', 10 * 1024 * 1024);

        $form->addSubmit('send', 'Save and publish');
        $form->onSuccess[] = [$this, 'portfolioItemFormSucceeded'];
        return $form;
    }

    public function actionEditPortfolioItem(int $id): void
    {
        $portfolioItem = $this->database->table('portfolio')->get($id);
        if (!$portfolioItem) {
            $this->error('Portfolio item not found');
        }

        /** @var Form $form */
        $form = $this['portfolioItemForm']; // Directly access the component
        $form->setDefaults($portfolioItem->toArray()); // Set defaults here
    }

    public function renderEditPortfolioItem(int $id): void
    {
        $portfolioItem = $this->database
            ->table('portfolio')
            ->get($id);


        if (!$portfolioItem) {
            $this->error('Portfolio item not found');
        }
    }

    public function portfolioItemFormSucceeded(Form $form, Nette\Utils\ArrayHash $values): void
    {
        $image = $values->image;
        if ($image->isOk() && $image->isImage()) {
            // Check the image dimensions
            $imageInfo = getimagesize($image->getTemporaryFile());
            if ($imageInfo[0] == 800 && $imageInfo[1] == 533) {
                $filePath = __DIR__ . '/../../www/images/demo/' . $image->getSanitizedName();
                $image->move($filePath);

                $data = [
                    'title' => $values->title,
                    'subtitle' => $values->subtitle,
                    'text' => $values->text,
                    'order' => $values->order,
                    'image_name' => $image->getSanitizedName(),
                ];

                $portfolioItem = $this->database->table('portfolio')->insert($data);

                $this->flashMessage("Portfolio item has been successfully added.", 'success');
                $this->redirect('Portfolio:portfolioItem', $portfolioItem->id);
            } else {
                $this->flashMessage("Image dimensions must be exactly 800x533 pixels.", 'error');
            }
        } else {
            $this->flashMessage("There was a problem with the image upload.", 'error');
        }
    }
}
