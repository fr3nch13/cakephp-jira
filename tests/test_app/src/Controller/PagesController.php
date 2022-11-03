<?php
declare(strict_types=1);

/**
 * PagesController
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Pages Controller
 *
 * Displays the 'static' pages.
 *
 * @property \Cake\ORM\Table $Pages
 */
class PagesController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $prefix = $this->getRequest()->getParam('prefix');

        // Only allow pages without a prefix to be viewed by non-logged in users.
        if (!$prefix) {
            $this->Auth->allow('display');
        }
    }

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     * @throws \Cake\View\Exception\MissingTemplateException in debug mode.
     * @return \Cake\Http\Response|null
     */
    public function display(string ...$path): ?\Cake\Http\Response
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));
        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }

        return null;
    }
}
