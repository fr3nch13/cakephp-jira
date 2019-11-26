# [CakePHP Jira Plugin API Documentation](../home.md)

# Class: \Fr3nch13\Jira\Form\AppForm
### Namespace: [\Fr3nch13\Jira\Form](../namespaces/Fr3nch13.Jira.Form.md)
---
**Summary:**

App Form

**Description:**

Used to submit an issue to Jira.

---
### Constants
* No constants found
---
### Properties
* [public $issueType](../classes/Fr3nch13.Jira.Form.AppForm.md#property_issueType)
* [public $settings](../classes/Fr3nch13.Jira.Form.AppForm.md#property_settings)
* [protected $JiraProject](../classes/Fr3nch13.Jira.Form.AppForm.md#property_JiraProject)
---
### Methods
* [public __construct()](../classes/Fr3nch13.Jira.Form.AppForm.md#method___construct)
* [public setFormData()](../classes/Fr3nch13.Jira.Form.AppForm.md#method_setFormData)
* [public getFormData()](../classes/Fr3nch13.Jira.Form.AppForm.md#method_getFormData)
* [protected _buildSchema()](../classes/Fr3nch13.Jira.Form.AppForm.md#method__buildSchema)
* [protected _buildValidator()](../classes/Fr3nch13.Jira.Form.AppForm.md#method__buildValidator)
* [protected _execute()](../classes/Fr3nch13.Jira.Form.AppForm.md#method__execute)
---
### Details
* File: [Form/AppForm.php](../files/Form.AppForm.md)
* Package: Default
* Class Hierarchy: 
  * [\Cake\Form\Form]()
  * \Fr3nch13\Jira\Form\AppForm
---
## Properties
<a name="property_issueType"></a>
#### public $issueType : string|null
---
**Summary**

The type of issue we're submitting.

**Type:** string|null

**Details:**


<a name="property_settings"></a>
#### public $settings : array
---
**Summary**

Settings for this form and for the JiraProject.

**Type:** array

**Details:**


<a name="property_JiraProject"></a>
#### protected $JiraProject : \Fr3nch13\Jira\Lib\JiraProject|null
---
**Summary**

Contains the loaded Jira Project object.

**Type:** <a href="../classes/Fr3nch13.Jira.Lib.JiraProject.html">\Fr3nch13\Jira\Lib\JiraProject</a>|null

**Details:**



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
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm.md)
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
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm.md)
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
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm.md)

**Returns:** array - The array of the current form data.


<a name="method__buildSchema" class="anchor"></a>
#### protected _buildSchema() : \Cake\Form\Schema

```
protected _buildSchema(\Cake\Form\Schema  $schema) : \Cake\Form\Schema
```

**Summary**

Defines the schema from the JiraProject Object.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm.md)
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
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm.md)
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
* Inherited From: [\Fr3nch13\Jira\Form\AppForm](../classes/Fr3nch13.Jira.Form.AppForm.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>array</code> | $data  | The array of post data from the form template. |

**Returns:** boolean - True is the issue was submitted or false if there was an problem.



---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13.html.md)

---

### Reports
* [Errors - 0](../reports/errors.md)
* [Markers - 0](../reports/markers.md)
* [Deprecated - 0](../reports/deprecated.md)

---

This document was automatically generated from source code comments on 2019-11-26 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
