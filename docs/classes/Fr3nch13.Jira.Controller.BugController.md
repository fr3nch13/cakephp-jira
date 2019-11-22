# [CakePHP Jira Plugin API Documentation](../home)

# Class: \Fr3nch13\Jira\Controller\BugController
### Namespace: [\Fr3nch13\Jira\Controller](../namespaces/Fr3nch13.Jira.Controller.md)
---
**Summary:**

Bug Controller

**Description:**

Frontend for submitting bugs to Jira.

---
### Constants
* No constants found
---
### Properties
* [public $humanName](../classes/Fr3nch13.Jira.Controller.AppController.md#property_humanName)
* [public $JiraForm](../classes/Fr3nch13.Jira.Controller.AppController.md#property_JiraForm)
---
### Methods
* [public add()](../classes/Fr3nch13.Jira.Controller.AppController.md#method_add)
* [public initialize()](../classes/Fr3nch13.Jira.Controller.BugController.md#method_initialize)
* [public index()](../classes/Fr3nch13.Jira.Controller.BugController.md#method_index)
---
### Details
* File: [Controller/BugController.php](../files/Controller.BugController.md)
* Package: Default
* Class Hierarchy:  
  * [\Cake\Controller\Controller]()
  * [\Fr3nch13\Jira\Controller\AppController](../classes/Fr3nch13.Jira.Controller.AppController.md)
  * \Fr3nch13\Jira\Controller\BugController
---
## Properties
<a name="property_humanName"></a>
#### public $humanName : string
---
**Summary**

Human name of this object.

**Type:** string

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\AppController](../classes/Fr3nch13.Jira.Controller.AppController.md)


<a name="property_JiraForm"></a>
#### public $JiraForm : object|null
---
**Summary**

The form object.

**Type:** object|null

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\AppController](../classes/Fr3nch13.Jira.Controller.AppController.md)



---
## Methods
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


<a name="method_initialize" class="anchor"></a>
#### public initialize() : void

```
public initialize() : void
```

**Summary**

Initialize method

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\BugController](../classes/Fr3nch13.Jira.Controller.BugController.md)

**Returns:** void


<a name="method_index" class="anchor"></a>
#### public index() 

```
public index() 
```

**Summary**

The form

**Description**

{@inheritdoc}

**Details:**
* Inherited From: [\Fr3nch13\Jira\Controller\BugController](../classes/Fr3nch13.Jira.Controller.BugController.md)





---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13.md)

---

### Reports
* [Errors - 0](../reports/errors)
* [Markers - 2](../reports/markers)
* [Deprecated - 0](../reports/deprecated)

---

This document was automatically generated from source code comments on 2019-11-22 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
