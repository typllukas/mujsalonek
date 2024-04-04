<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class SignInPresenter extends Nette\Application\UI\Presenter
{
    protected function createComponentSignInForm(): Form
    {
        $form = new Form;
        $form->addText('username', 'Username:')
            ->setRequired('Please fill out your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please fill out your password.');

        $form->addSubmit('send', 'Sign In');

        $form->onSuccess[] = $this->signInFormSucceeded(...);
        return $form;
    }

    private function signInFormSucceeded(Form $form, \stdClass $data): void
    {
        try {
            $this->getUser()->login($data->username, $data->password);
            $this->redirect('Admin:admin');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Incorrect username or password.');
        }
    }

    public function renderSignIn(): void
    {
    }
}
