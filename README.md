ToolboxBundle
===================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/52227642-f384-4a42-8669-f207bae22e6d/mini.png)](https://insight.sensiolabs.com/projects/c607d9d8-329b-461a-82f8-8ad30be60be8)
[![Latest Stable Version](https://poser.pugx.org/clavicula-nox/toolbox-bundle/v/stable)](https://packagist.org/packages/clavicula-nox/toolbox-bundle)
[![License](https://poser.pugx.org/clavicula-nox/toolbox-bundle/license)](https://packagist.org/packages/clavicula-nox/toolbox-bundle)
[![Total Downloads](https://poser.pugx.org/clavicula-nox/toolbox-bundle/downloads)](https://packagist.org/packages/clavicula-nox/toolbox-bundle)
[![Symfony](https://img.shields.io/badge/Symfony-%203.4%20&%204.x-green.svg "Supports Symfony 3.4 & 4.x")](https://symfony.com/)
[![codecov](https://codecov.io/gh/Clavicula-Nox/ToolboxBundle/branch/master/graph/badge.svg)](https://codecov.io/gh/Clavicula-Nox/ToolboxBundle)
[![Build Status](https://travis-ci.org/Clavicula-Nox/ToolboxBundle.svg?branch=master)](https://travis-ci.org/Clavicula-Nox/ToolboxBundle)


**Requirements**

  * php 7.1+
  * Symfony 3.4 and 4.x applications

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
