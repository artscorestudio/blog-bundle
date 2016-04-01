# Artscore Studio Blog Bundle

Blog Bundle is a Symfony 2/3 bundle for create and manage blog features in your Symfony 2/3 application. This package is a part of Artscore Studio Framework.

> IMPORTANT NOTICE: This bundle is still under development. Any changes will be done without prior notice to consumers of this package. Of course this code will become stable at a certain point, but for now, use at your own risk.

> BE CARREFUL : This bundle does not include external libraries, you must install the libraries via Compoer, in accordance with best practices of Symfony documentation.

## Prerequisites

This version of the bundle requires :
* Symfony >= 2.8 / >= 3+
* [ASFWebsiteBundle][1]

### Translations

If you wish to use default texts provided in this bundle, you have to make sure you have translator enabled in your config.

```yaml
# app/config/config.yml
framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](https://symfony.com/doc/current/book/translation.html).

## Installation

### Step 1 : Download ASFBlogBundle using composer

Require the bundle with composer :

```bash
$ composer require artscorestudio/blog-bundle "dev-master"
```

Composer will install the bundle to your project's *vendor/artscorestudio/blog-bundle* directory. It also install dependencies. 

### Step 2 : Enable the bundle

Enable the bundle in the kernel :

```php
// app/AppKernel.php

public function registerBundles()
{
	$bundles = array(
		// ...
		new ASF\BlogBundle\ASFBlogBundle()
		// ...
	);
}
```

### Step 3 : Import ASFBlogBundle routing files

Now that you have activated and configured the bundle, all that is left to do is import the ASFBlogBundle routing files.

By importing the routing files you will have ready made pages for things such as website homepage, etc.

```yaml
asf_blog:
    resource: "@ASFBlogBundle/Resources/config/routing/routing.yml"
```

### Next Steps


[1]: https://packagist.org/packages/artscorestudio/core-bundle
