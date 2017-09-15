ToolboxBundle
===================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c607d9d8-329b-461a-82f8-8ad30be60be8/mini.png)](https://insight.sensiolabs.com/projects/c607d9d8-329b-461a-82f8-8ad30be60be8)
[![Symfony](https://img.shields.io/badge/Symfony-%202.7%20and%203.x-green.svg "Supports Symfony 2.7 and 3.x")](https://symfony.com/)

**Requirements**

  * Symfony 3.x applications
  * Doctrine ORM entities

**Reporting an issue or a feature request**

Issues and feature requests are tracked in the Github issue tracker.

Installation
------------

### Step 1: Download the Bundle

```bash
$ composer require clavicula-nox/toolbox-bundle
```

This command requires you to have Composer installed globally, as explained
in the [Composer documentation](https://getcomposer.org/doc/00-intro.md).

### Step 2: Enable the Bundle

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new ClaviculaNox\ToolboxBundle\ToolboxBundle(),
        );
    }

    // ...
}
```
