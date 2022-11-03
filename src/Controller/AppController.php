<?php
declare(strict_types=1);

/**
 * AppController
 */

namespace Fr3nch13\Jira\Controller;

use App\Controller\AppController as BaseController;
use Fr3nch13\Jira\Form\AppForm as JiraForm;

/**
 * App Controller
 *
 * The base controller for the jira plugin.
 */
class AppController extends BaseController
{
    /**
     * @var string Human name of this object.
     */
    public $humanName = '';

    /**
     * @var \Fr3nch13\Jira\Form\AppForm The form object.
     */
    public $JiraForm;

    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->humanName = __('Task');
        $this->JiraForm = new JiraForm();
    }

    /**
     * The html form.
     *
     * @return null|\Cake\Http\Response Redirects on success.
     */
    public function add(): ?\Cake\Http\Response
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
            'errors' => $errors,
        ]);

        return null;
    }

    /**
     * The thank you page after they've submitted their report.
     *
     * @return void
     */
    public function thankyou(): void
    {
    }
}
