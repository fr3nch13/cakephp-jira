# [CakePHP Jira Plugin API Documentation](../home.md)

# Class: \Fr3nch13\Jira\Controller\AppController
### Namespace: [\Fr3nch13\Jira\Controller](../namespaces/Fr3nch13.Jira.Controller.md)
---
**Summary:**

App Controller

**Description:**

The base controller for the jira plugin.

-----------------------------
Inherited:

{@inheritdoc}

---
### Constants
* No constants found
---
### Properties
* [public $humanName](../classes/Fr3nch13.Jira.Controller.AppController.md#property_humanName)
* [public $JiraForm](../classes/Fr3nch13.Jira.Controller.AppController.md#property_JiraForm)
---
### Methods
* [public initialize()](../classes/Fr3nch13.Jira.Controller.AppController.md#method_initialize)
* [public add()](../classes/Fr3nch13.Jira.Controller.AppController.md#method_add)
* [public thankyou()](../classes/Fr3nch13.Jira.Controller.AppController.md#method_thankyou)
---
### Details
* File: [Controller/AppController.php](../files/Controller.AppController.md)
* Package: Default
* Class Hierarchy: 
  * [\App\Controller\AppController]()
  * \Fr3nch13\Jira\Controller\AppController
---
## Properties
<a name="property_humanName"></a>
#### public $humanName : string
---
**Summary**

Human name of this object.

**Type:** string

**Details:**


<a name="property_JiraForm"></a>
#### public $JiraForm : object|null
---
**Summary**

The form object.

**Type:** object|null

**Details:**



---
## Methods
<a name="method_initialize" class="anchor"></a>
#### public initialize() : void

```
public initialize() : void
```

**Summary**

Initialize method

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\AppController](../classes/Fr3nch13.Jira.Controller.AppController.md)

**Returns:** void


<a name="method_add" class="anchor"></a>
#### public add() : void&amp;#124;\Cake\Http\Response&amp;#124;null

```
public add() : void&amp;#124;\Cake\Http\Response&amp;#124;null
```

**Summary**

The html form.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\AppController](../classes/Fr3nch13.Jira.Controller.AppController.md)

**Returns:** void&#124;\Cake\Http\Response&#124;null - Redirects on success.


<a name="method_thankyou" class="anchor"></a>
#### public thankyou() : void

```
public thankyou() : void
```

**Summary**

The thank you page after they've submitted their report.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\AppController](../classes/Fr3nch13.Jira.Controller.AppController.md)

**Returns:** void



---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13.html.md)

---

### Reports
* [Errors - 0](../reports/errors.md)
* [Markers - 0](../reports/markers.md)
* [Deprecated - 0](../reports/deprecated.md)

---

This document was automatically generated from source code comments on 2019-12-03 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
