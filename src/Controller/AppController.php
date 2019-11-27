<?php

/**
 * AppController
 */

namespace Fr3nch13\Jira\Controller;

use App\Controller\AppController as BaseController;

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
class AppController extends BaseController
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
        $errors = [];
        if ($this->getRequest()->is('post')) {
            if ($this->JiraForm->execute($this->getRequest()->getData())) {
                $this->Flash->success(__('The {0} has been saved.', [$this->humanName]));

                return $this->redirect(['action' => 'thankyou', '?' => ['type' => $this->humanName]]);
            } else {
                $errors = $this->JiraForm->getErrors();
                $this->Flash->error(__('There was a problem saving the {0}.', [$this->humanName]));
            }
        }

        if ($this->getRequest()->is('get')) {
            $this->JiraForm->setData($this->JiraForm->getFormData());
        }

        $this->set([
            'form' => $this->JiraForm,
            'errors' => $errors
        ]);
    }

    /**
     * The thank you page after they've submitted their report.
     *
     * @return void
     */
    public function thankyou()
    {
        //
    }
}
