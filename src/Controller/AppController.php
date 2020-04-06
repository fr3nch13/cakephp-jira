<?php

/**
 * AppController
 */

namespace Fr3nch13\Jira\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Fr3nch13\Jira\Form\AppForm as JiraForm;

/**
 * App Controller
 *
 * The base controller for the jira plugin.
 *
 * -----------------------------
 * Inherited:
 *
 * {@inheritdoc}
 *
 * @property \Cake\Controller\Component\AuthComponent $Auth
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
     * @var object
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

        $this->loadComponent('RequestHandler');
        if (isset($this->Auth)) {
            $this->Auth->allow(['add', 'thankyou']);
        }

        $this->modelClass = false;

        $this->humanName = __('Task');
        $this->JiraForm = new JiraForm();
    }

    /**
     * The html form.
     *
     * @return \Cake\Http\Response|null Redirects on success.
     */
    public function add(): ?\Cake\Http\Response
    {
        $errors = [];
        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();
            if ($this->getRequest()->getQuery()) {
                $query = $this->getRequest()->getQuery();
                if (isset($query['referer'])) {
                    $data['referer'] = $query['referer'];
                }
            }
            if ($this->JiraForm->execute($data)) {
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

        $username = null;
        if (isset($this->Auth) && $this->Auth->user() && Configure::read('Jira.usernameField')) {
            $user = $this->Auth->user();
            $usernameField = Configure::read('Jira.usernameField');
            if (isset($user->{$usernameField})) {
                $username = $user->{$usernameField};
            }
        }

        $this->set([
            'form' => $this->JiraForm,
            'errors' => $errors,
            'username' => $username,
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
        //
    }
}
