# [CakePHP Jira Plugin API Documentation](../home.md)

# Class: \Fr3nch13\Jira\View\Helper\JiraHelper
### Namespace: [\Fr3nch13\Jira\View\Helper](../namespaces/Fr3nch13.Jira.View.Helper.md)
---
**Summary:**

Jira Helper

**Description:**

Helper to write out stuff about your jira project.

---
### Constants
* No constants found
---
### Properties
* [public $helpers](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#property_helpers)
* [public $Url](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#property_Url)
* [public $Html](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#property_Html)
* [protected $JiraProject](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#property_JiraProject)
---
### Methods
* [public __construct()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method___construct)
* [public getInfo()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getInfo)
* [public getVersions()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getVersions)
* [public getIssues()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getIssues)
* [public getOpenIssues()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getOpenIssues)
* [public getIssue()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getIssue)
* [public getBugs()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getBugs)
* [public getOpenBugs()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_getOpenBugs)
* [public bugLink()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_bugLink)
* [public frLink()](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md#method_frLink)
---
### Details
* File: [View/Helper/JiraHelper.php](../files/View.Helper.JiraHelper.md)
* Package: Default
* Class Hierarchy: 
  * [\Cake\View\Helper]()
  * \Fr3nch13\Jira\View\Helper\JiraHelper
---
## Properties
<a name="property_helpers"></a>
#### public $helpers : array
---
**Summary**

List of loaded helpers.

**Type:** array

**Details:**


<a name="property_Url"></a>
#### public $Url : \Cake\View\Helper\UrlHelper
---
**Type:** \Cake\View\Helper\UrlHelper

**Details:**


<a name="property_Html"></a>
#### public $Html : \Cake\View\Helper\HtmlHelper
---
**Type:** \Cake\View\Helper\HtmlHelper

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
public __construct(\Cake\View\View  $View, array  $config = array()) : void
```

**Summary**

Initialize the helper

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\View\View</code> | $View  | The view object |
| <code>array</code> | $config  | Helper config settings |

**Returns:** void


<a name="method_getInfo" class="anchor"></a>
#### public getInfo() : object

```
public getInfo() : object
```

**Summary**

Get the information about the Jira Project

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\MissingProjectException | If the project can't be found. |

**Returns:** object - Object containing the information about your project.


<a name="method_getVersions" class="anchor"></a>
#### public getVersions() : \ArrayObject

```
public getVersions() : \ArrayObject
```

**Summary**

Gets a list of all versions within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)

**Returns:** \ArrayObject - A list of version objects.


<a name="method_getIssues" class="anchor"></a>
#### public getIssues() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getIssues() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Gets a list of all issues within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getOpenIssues" class="anchor"></a>
#### public getOpenIssues() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getOpenIssues() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Gets a list of all open issues within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getIssue" class="anchor"></a>
#### public getIssue() : object

```
public getIssue(integer  $id = null) : object
```

**Summary**

Gets info on a particular issue within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>integer</code> | $id  | The issue id. The integer part without the project key. |
##### Throws:
| Type | Description |
| ---- | ----------- |
| \Fr3nch13\Jira\Exception\MissingIssueException | If the project's issue can't be found. |

**Returns:** object - the object that has the info of that issue.


<a name="method_getBugs" class="anchor"></a>
#### public getBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Gets a list of all issues that are bugs within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_getOpenBugs" class="anchor"></a>
#### public getOpenBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3

```
public getOpenBugs() : \JiraRestApi\Issue\IssueSearchResult&amp;#124;\JiraRestApi\Issue\IssueSearchResultV3
```

**Summary**

Gets a list of all open issues that are bugs within your project.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)

**Returns:** \JiraRestApi\Issue\IssueSearchResult&#124;\JiraRestApi\Issue\IssueSearchResultV3 - A list of issue objects.


<a name="method_bugLink" class="anchor"></a>
#### public bugLink() : string

```
public bugLink(\Fr3nch13\Jira\View\Helper\sting&amp;#124;null  $name = null, array&amp;#124;string&amp;#124;null  $url = array(), array  $options = array()) : string
```

**Summary**

Created the link to submit a bug.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Fr3nch13\Jira\View\Helper\sting&#124;null</code> | $name  | Name of the link |
| <code>array&#124;string&#124;null</code> | $url  | An alternate url, if needed. |
| <code>array</code> | $options  | Additional options, also passthrough to HtmlHelper::link() |

**Returns:** string - The generated link html.

##### Tags
| Tag | Version | Description |
| --- | ------- | ----------- |
| TODO |  | Build out the forms frontend |

<a name="method_frLink" class="anchor"></a>
#### public frLink() : string

```
public frLink(\Fr3nch13\Jira\View\Helper\sting&amp;#124;null  $name = null, array&amp;#124;string&amp;#124;null  $url = array(), array  $options = array()) : string
```

**Summary**

Created the link to submit a feature request.

**Details:**
* Inherited From: [\Fr3nch13\Jira\View\Helper\JiraHelper](../classes/Fr3nch13.Jira.View.Helper.JiraHelper.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Fr3nch13\Jira\View\Helper\sting&#124;null</code> | $name  | Name of the link |
| <code>array&#124;string&#124;null</code> | $url  | An alternate url, if needed. |
| <code>array</code> | $options  | Additional options, also passthrough to HtmlHelper::link() |

**Returns:** string - The generated link html.

##### Tags
| Tag | Version | Description |
| --- | ------- | ----------- |
| TODO |  | Build out the forms frontend |


---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13.html.md)

---

### Reports
* [Errors - 0](../reports/errors.md)
* [Markers - 2](../reports/markers.md)
* [Deprecated - 0](../reports/deprecated.md)

---

This document was automatically generated from source code comments on 2019-11-26 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
