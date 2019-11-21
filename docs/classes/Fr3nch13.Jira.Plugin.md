# [CakePHP Jira Plugin API Documentation](../home)

# Class: \Fr3nch13\Jira\Plugin
### Namespace: [\Fr3nch13\Jira](../namespaces/Fr3nch13.Jira)
---
**Summary:**

Plugin Definitions

---
### Constants
* No constants found
---
### Properties
---
### Methods
* [public bootstrap()](../classes/Fr3nch13.Jira.Plugin#method_bootstrap)
* [public console()](../classes/Fr3nch13.Jira.Plugin#method_console)
* [public middleware()](../classes/Fr3nch13.Jira.Plugin#method_middleware)
* [public routes()](../classes/Fr3nch13.Jira.Plugin#method_routes)
---
### Details
* File: [Plugin.php](../files/Plugin)
* Package: Default
* Class Hierarchy: 
  * [\Cake\Core\BasePlugin]()
  * \Fr3nch13\Jira\Plugin

---
## Methods
<a name="method_bootstrap" class="anchor"></a>
#### public bootstrap() : void

```
public bootstrap(\Cake\Core\PluginApplicationInterface  $app) : void
```

**Summary**

Bootstraping for this specific plugin.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Plugin](../classes/Fr3nch13.Jira.Plugin)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\Core\PluginApplicationInterface</code> | $app  | The app object. |

**Returns:** void


<a name="method_console" class="anchor"></a>
#### public console() : object

```
public console(object  $commands) : object
```

**Summary**

Add plugin specific commands here.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Plugin](../classes/Fr3nch13.Jira.Plugin)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>object</code> | $commands  | The passed commands object. |

**Returns:** object - The modified commands object.


<a name="method_middleware" class="anchor"></a>
#### public middleware() : object

```
public middleware(object  $middleware) : object
```

**Summary**

Load needed Middleware

**Details:**
* Inherited From: [\Fr3nch13\Jira\Plugin](../classes/Fr3nch13.Jira.Plugin)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>object</code> | $middleware  | The passed middleware object. |

**Returns:** object - The modified middleware object.


<a name="method_routes" class="anchor"></a>
#### public routes() : void

```
public routes(object  $routes) : void
```

**Summary**

Add plugin specific routes here.

**Details:**
* Inherited From: [\Fr3nch13\Jira\Plugin](../classes/Fr3nch13.Jira.Plugin)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>object</code> | $routes  | The passed routes object. |

**Returns:** void



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