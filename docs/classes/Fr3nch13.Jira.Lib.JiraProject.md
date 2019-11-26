# [CakePHP Jira Plugin API Documentation](../home.md)

# Class: \Fr3nch13\Jira\Lib\JiraProject
### Namespace: [\Fr3nch13\Jira\Lib](../namespaces/Fr3nch13.Jira.Lib.md)
---
**Summary:**

Jira Project class

---
### Constants
* No constants found
---
### Properties
* [public $ConfigObj](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_ConfigObj)
* [public $projectKey](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_projectKey)
* [public $ProjectService](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_ProjectService)
* [public $IssueService](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_IssueService)
* [protected $Project](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_Project)
* [protected $Versions](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_Versions)
* [protected $Issues](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_Issues)
* [protected $issuesCache](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_issuesCache)
* [protected $validTypes](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_validTypes)
* [protected $allowedTypes](../classes/Fr3nch13.Jira.Lib.JiraProject.md#property_allowedTypes)
---
### Methods
* [public __construct()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method___construct)
* [public getInfo()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getInfo)
* [public getVersions()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getVersions)
* [public getIssues()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getIssues)
* [public getOpenIssues()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getOpenIssues)
* [public getIssue()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getIssue)
* [public getBugs()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getBugs)
* [public getOpenBugs()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getOpenBugs)
* [public getAllowedTypes()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getAllowedTypes)
* [public modifyAllowedTypes()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_modifyAllowedTypes)
* [public isAllowedType()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_isAllowedType)
* [public getFormData()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_getFormData)
* [public setFormData()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_setFormData)
* [public submitIssue()](../classes/Fr3nch13.Jira.Lib.JiraProject.md#method_submitIssue)
---
### Details
* File: [Lib/JiraProject.php](../files/Lib.JiraProject.md)
* Package: Default
* Class Hierarchy:
  * \Fr3nch13\Jira\Lib\JiraProject
---
## Properties
<a name="property_ConfigObj"></a>
#### public $ConfigObj : \JiraRestApi\Configuration\ArrayConfiguration|null
---
**Summary**

Config Object.

**Type:** \JiraRestApi\Configuration\ArrayConfiguration|null

**Details:**


<a name="property_projectKey"></a>
#### public $projectKey : string|null
---
**Summary**

The key for the project.

**Type:** string|null

**Details:**


<a name="property_ProjectService"></a>
#### public $ProjectService : \JiraRestApi\Project\ProjectService|null
---
**Summary**

The project service object.

**Type:** \JiraRestApi\Project\ProjectService|null

**Details:**


<a name="property_IssueService"></a>
#### public $IssueService : \JiraRestApi\Issue\IssueService|null
---
**Summary**

The project service object.

**Type:** \JiraRestApi\Issue\IssueService|null

**Details:**


<a name="property_Project"></a>
#### protected $Project : \JiraRestApi\Project\Project|null
---
**Summary**

The project object.

**Type:** \JiraRestApi\Project\Project|null

**Details:**


<a name="property_Versions"></a>
#### protected $Versions : \ArrayObject|null
---
**Summary**

The list of a Project's Versions.

**Type:** \ArrayObject|null

**Details:**


<a name="property_Issues"></a>
#### protected $Issues : array|null
---
**Summary**

The Cached list of issues.

**Type:** array|null

**Details:**


<a name="property_issuesCache"></a>
#### protected $issuesCache : array
---
**Summary**

The cached list of returned issue info from the below getIssue() method.

**Type:** array

**Details:**


<a name="property_validTypes"></a>
#### protected $validTypes : array
---
**Summary**

Valid Types.

***Description***

Used to ensure we're getting a valid type when filtering.
Currently only support Jira Core and Software.

**Type:** array

**Details:**
* See Also:
  * [https://confluence.atlassian.com/adminjiracloud/issue-types-844500742.html]()


<a name="property_allowedTypes"></a>
#### protected $allowedTypes : array
---
**Summary**

Types of issues allowed to be submitted.

**Type:** array

**Details:**



---
## Methods
<a name="method___construct" class="anchor"></a>
#### public __construct() : void

```
public __construct() : void
```

**Summary**

Constructor

**Description**

Reads the configuration, and crdate a config object to be passed to the other objects.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\MissingConfigException | When a config setting isn't set. |

**Returns:** void


<a name="method_getInfo" class="anchor"></a>
#### public getInfo() : \JiraRestApi\Project\Project

```
public getInfo() : \JiraRestApi\Project\Project
```

**Summary**

Get the Project's Info.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\MissingProjectException | If the project can't be found. |

**Returns:** \JiraRestApi\Project\Project - The information about the project.


<a name="method_getVersions" class="anchor"></a>
#### public getVersions() : \ArrayObject

```
public getVersions() : \ArrayObject
```

**Summary**

Get the Project's Versions.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)

**Returns:** \ArrayObject - A list of version objects.


<a name="method_getIssues" class="anchor"></a>
#### public getIssues() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getIssues(string&amp;#124;null  $type = null) : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Get the Project's Issues.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>string&#124;null</code> | $type  | Filter the Issues by type. |

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getOpenIssues" class="anchor"></a>
#### public getOpenIssues() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getOpenIssues(string&amp;#124;null  $type = null) : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Get the Project's Open Issues.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>string&#124;null</code> | $type  | Filter the Issues by type. |

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getIssue" class="anchor"></a>
#### public getIssue() : \JiraRestApi\Issue\Issue&amp;#124;\JiraRestApi\Issue\IssueV3

```
public getIssue(integer  $id = null) : \JiraRestApi\Issue\Issue&amp;#124;\JiraRestApi\Issue\IssueV3
```

**Summary**

Gets info on a particular issue within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>integer</code> | $id  | The issue id. The integer part without the project key. |
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\Exception | If the issue's id isn't given. |
| \Fr3nch13\Jira\Exception\MissingIssueException | If the project's issue can't be found. |

**Returns:** \JiraRestApi\Issue\Issue&#124;\JiraRestApi\Issue\IssueV3 - the object that has the info of that issue.


<a name="method_getBugs" class="anchor"></a>
#### public getBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Gets a list of issues that are considered bugs.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getOpenBugs" class="anchor"></a>
#### public getOpenBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getOpenBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Gets a list of open issues that are considered bugs.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getAllowedTypes" class="anchor"></a>
#### public getAllowedTypes() : array

```
public getAllowedTypes() : array
```

**Summary**

Returns the allowed types and their settings

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)

**Returns:** array - the content of $this->allowedTypes.


<a name="method_modifyAllowedTypes" class="anchor"></a>
#### public modifyAllowedTypes() : void

```
public modifyAllowedTypes(string  $type, array  $settings = array()) : void
```

**Summary**

Allows you to modify the form allowdTypes to fir your situation.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>string</code> | $type  | The type of issue you want to add/modify. |
| <code>array</code> | $settings  | The settings for the type. |

**Returns:** void


<a name="method_isAllowedType" class="anchor"></a>
#### public isAllowedType() : boolean

```
public isAllowedType(string  $type) : boolean
```

**Summary**

Checks to see if a type is allowed.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>string</code> | $type  | The type to check. |

**Returns:** boolean - if it's allowed or not.


<a name="method_getFormData" class="anchor"></a>
#### public getFormData() : array

```
public getFormData(string&amp;#124;null  $type = null) : array
```

**Summary**

Gets the array for the forms when submitting an issue to Jira.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>string&#124;null</code> | $type  | The type of issue we're submitting. |
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\MissingAllowedTypeException | If that type is not configured. |
| \Fr3nch13\Jira\Exception\Exception | If the form data for that type is missing. |

**Returns:** array - The array of data to fill in the form with.


<a name="method_setFormData" class="anchor"></a>
#### public setFormData() : void

```
public setFormData(\Fr3nch13\Jira\Lib\sting&amp;#124;null  $type, array  $data = array()) : void
```

**Summary**

Sets the formData variable if you want to modify the default/initial values.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Fr3nch13\Jira\Lib\sting&#124;null</code> | $type  | The type you want to set the data for.
 - Needs to be in the allowedTypes already. |
| <code>array</code> | $data  | The definition of the allowed types |
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\MissingAllowedTypeException | If that type is not configured. |

**Returns:** void


<a name="method_submitIssue" class="anchor"></a>
#### public submitIssue() : boolean

```
public submitIssue(array  $data = array()) : boolean
```

**Summary**

Submits the Issue

**Details:**
* Inherited From: [\Fr3nch13\Jira\Lib\JiraProject](../classes/Fr3nch13.Jira.Lib.JiraProject.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>array</code> | $data  | The array of details about the issue. |

**Returns:** boolean - If the request was successfully submitted.

##### Tags
| Tag | Version | Description |
| --- | ------- | ----------- |
| todo |  | Actually submit the form to the jira server. |


---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13.html.md)

---

### Reports
* [Errors - 0](../reports/errors.md)
* [Markers - 1](../reports/markers.md)
* [Deprecated - 0](../reports/deprecated.md)

---

This document was automatically generated from source code comments on 2019-11-26 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
