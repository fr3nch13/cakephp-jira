# [CakePHP Jira Plugin API Documentation](../home)

# Class: \Fr3nch13\Jira\Form\BugForm
### Namespace: [\Fr3nch13\Jira\Form](../namespaces/Fr3nch13.Jira.Form)
---
**Summary:**

Bug Form

**Description:**

Used to submit a bug to Jira.

---
### Constants
* No constants found
---
### Properties
* [public $formData](../classes/Fr3nch13.Jira.Form.AppForm#property_formData)
* [public $issueType](../classes/Fr3nch13.Jira.Form.AppForm#property_issueType)
* [protected $JiraProject](../classes/Fr3nch13.Jira.Form.AppForm#property_JiraProject)
---
### Methods
* [public __construct()](../classes/Fr3nch13.Jira.Form.BugForm#method___construct)
* [public setFormData()](../classes/Fr3nch13.Jira.Form.AppForm#method_setFormData)
* [public getFormData()](../classes/Fr3nch13.Jira.Form.AppForm#method_getFormData)
* [protected _buildSchema()](../classes/Fr3nch13.Jira.Form.AppForm#method__buildSchema)
* [protected _buildValidator()](../classes/Fr3nch13.Jira.Form.AppForm#method__buildValidator)
* [protected _execute()](../classes/Fr3nch13.Jira.Form.AppForm#method__execute)
---
### Details
* File: [Form/BugForm.php](../files/Form.BugForm)
* Package: Default
* Class Hierarchy:  
  * [\Cake\Form\Form]()
  * [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)
  * \Fr3nch13\Jira\Form\BugForm
---
## Properties
<a name="property_formData"></a>
#### public $formData : array
---
**Summary**

The form fields and data.

**Type:** array

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)


<a name="property_issueType"></a>
#### public $issueType : string|null
---
**Summary**

The type of issue we're submitting.

**Type:** string|null

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)


<a name="property_JiraProject"></a>
#### protected $JiraProject : \Fr3nch13\Jira\Lib\JiraProject|null
---
**Summary**

Contains the loaded Jira Project object.

**Type:** <a href="../classes/Fr3nch13.Jira.Lib.JiraProject.html">\Fr3nch13\Jira\Lib\JiraProject</a>|null

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)



---
## Methods
<a name="method___construct" class="anchor"></a>
#### public __construct() : void

```
public __construct(\Cake\Event\EventManager&amp;#124;null  $eventManager = null) : void
```

**Summary**

Constructor

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\BugForm](../classes/Fr3nch13.Jira.Form.BugForm)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\Event\EventManager&#124;null</code> | $eventManager  | The event manager.
 Defaults to a new instance. |

**Returns:** void


<a name="method_setFormData" class="anchor"></a>
#### public setFormData() : void

```
public setFormData(array  $data = array()) : void
```

**Summary**

Sets the formData variable.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>array</code> | $data  | The array of data. |

**Returns:** void


<a name="method_getFormData" class="anchor"></a>
#### public getFormData() : array

```
public getFormData() : array
```

**Summary**

Gets the formData variable.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)

**Returns:** array - The array of the current form data.


<a name="method__buildSchema" class="anchor"></a>
#### protected _buildSchema() : \Cake\Form\Schema

```
protected _buildSchema(\Cake\Form\Schema  $schema) : \Cake\Form\Schema
```

**Summary**

Defines the schema from the JiraProject Object.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\Form\Schema</code> | $schema  | The existing schema. |

**Returns:** \Cake\Form\Schema - The modified schema.


<a name="method__buildValidator" class="anchor"></a>
#### protected _buildValidator() : \Cake\Validation\Validator

```
protected _buildValidator(\Cake\Validation\Validator  $validator) : \Cake\Validation\Validator
```

**Summary**

Defines the validations

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\Validation\Validator</code> | $validator  | The existing validator. |

**Returns:** \Cake\Validation\Validator - The modified validator.


<a name="method__execute" class="anchor"></a>
#### protected _execute() : boolean

```
protected _execute(array  $data = array()) : boolean
```

**Summary**

Submit the issue to Jira.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>array</code> | $data  | The array of post data from the form template. |

**Returns:** boolean - True is the issue was submitted or false if there was an problem.



---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13)

---

### Reports
* [Errors - 0](../reports/errors)
* [Markers - 2](../reports/markers)
* [Deprecated - 0](../reports/deprecated)

---

This document was automatically generated from source code comments on 2019-11-21 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
