<?php

/**
 * AppController
 */

namespace Fr3nch13\Jira\Controller;

use Cake\Controller\Controller;

/**
 * App Controller
 *
 * The base controller for the jira plugin.
 *
 * -----------------------------
 * Inherited:
 *
 * {@inheritdoc}
 */
class AppController extends Controller
{
    /**
     * Human name of this object.
     * @var string
     */
    public $humanName = '';

    /**
     * The form object.
     * @var object|null
     */
    public $JiraForm = null;

    /**
     * The html form.
     *
     * @return void|\Cake\Http\Response|null Redirects on success.
     */
    public function add()
    {
        if ($this->getRequest()->is('post')) {
            if ($this->JiraForm->execute($this->getRequest()->getData())) {
                $this->Flash->success(__('The {0} has been saved.', [$this->humanName]));

                return $this->redirect($this->getReferer());
            } else {
                $this->Flash->error('There was a problem saving the {0}.', [$this->humanName]);
            }
        }

        if ($this->getRequest()->is('get')) {
            $this->JiraForm->setData($this->JiraForm->getFormData());
        }

        $this->set([
            'form' => $this->JiraForm
        ]);
    }
}
