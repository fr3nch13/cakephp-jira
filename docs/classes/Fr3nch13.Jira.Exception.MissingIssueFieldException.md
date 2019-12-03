# [CakePHP Jira Plugin API Documentation](../home.md)

# Class: \Fr3nch13\Jira\Exception\MissingIssueFieldException
### Namespace: [\Fr3nch13\Jira\Exception](../namespaces/Fr3nch13.Jira.Exception.md)
---
**Summary:**

Missing Issue Exception

**Description:**

Throw when a Project's Issue can't be found.

---
### Constants
* No constants found
---
### Properties
* [protected $_defaultCode](../classes/Fr3nch13.Jira.Exception.MissingIssueFieldException.md#property__defaultCode)
---
### Methods
* [public __construct()](../classes/Fr3nch13.Jira.Exception.MissingIssueFieldException.md#method___construct)
---
### Details
* File: [Exception/MissingIssueFieldException.php](../files/Exception.MissingIssueFieldException.md)
* Package: Default
* Class Hierarchy:  
  * [\Cake\Core\Exception\Exception]()
  * [\Fr3nch13\Jira\Exception\Exception](../classes/Fr3nch13.Jira.Exception.Exception.md)
  * \Fr3nch13\Jira\Exception\MissingIssueFieldException
---
## Properties
<a name="property__defaultCode"></a>
#### protected $_defaultCode : integer
---
**Summary**

Throw a 404 when a field is missing.

**Type:** integer

**Details:**



---
## Methods
<a name="method___construct" class="anchor"></a>
#### public __construct() 

```
public __construct(string&amp;#124;array  $message = &#039;&#039;, integer&amp;#124;null  $code = null, \Exception&amp;#124;null  $previous = null) 
```

**Summary**

Constructor.

**Description**

Allows you to create exceptions that are treated as framework errors and disabled
when debug mode is off.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Exception\MissingIssueFieldException](../classes/Fr3nch13.Jira.Exception.MissingIssueFieldException.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>string&#124;array</code> | $message  | Either the string of the error message, or an array of attributes
  that are made available in the view, and sprintf()'d into Exception::$_messageTemplate |
| <code>integer&#124;null</code> | $code  | The code of the error, is also the HTTP status code for the error. |
| <code>\Exception&#124;null</code> | $previous  | the previous exception. |





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
