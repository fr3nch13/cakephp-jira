<?php
declare(strict_types=1);

/**
 * Handles Errors in responses
 */

namespace App\Controller;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        $this->viewBuilder()->setTemplatePath('Error');

        return parent::beforeRender($event);
    }
}
