TheMizzi\HelloWorld
===================

This is a very basic hello world module for Magento 2 v1.0.0-alpha.

#### etc/module.xml

First we define our module. Notice that Magento 2 uses schemas but not namespaces. The schema is declared in the xsi:noNamespaceSchemaLocation attribute. The module tag includes the name of the module using an underscore syntax and the setup version. This is similar to Magento 1, just in a different place.
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="../../../../../lib/internal/Magento/Framework/Module/etc/module.xsd">
    <module name="TheMizzi_HelloWorld" setup_version="0.0.1" />
</config>
```

#### etc/frontend/routes.xml

Next we define our router and a route. The router with id "standard" is the frontend router. Inside we include a route with an id of "helloworld" and a frontName of "helloword". The frontName is the part that is important for defining the url. This will allow us to use http://myserver.com/helloworld as the base for our routes.

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="../../../../../../lib/internal/Magento/Framework/App/etc/routes.xsd">
    <router id="standard">
        <route id="helloworld" frontName="helloworld">
            <module name="TheMizzi_HelloWorld"/>
        </route>
    </router>
</config>
```

#### Controller/Display/Index.php

Now we will create our first controller. We want to display a basic page, and for this, Magento 2 includes a basic PageFactory class that will do a lot of the work for us. Inside a controller action, during the "dispatch" function of the parent class, a call to "execute()" is made on the current class. While not defined in the interface or an abstract class (though it should be in my opinion), this is the function we use to display our page. Here we are simply going to call create() on the PageFactory.

```php
<?php

namespace TheMizzi\HelloWorld\Controller\Display;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package TheMizzi\HelloWorld\Controller\Index
 * @author  Joe Mizzi <jmizzi@gorillagroup.com>
 */
class Index extends Action
{
    /**
     * The PageFactory to render with.
     *
     * @var PageFactory
     */
    protected $_resultsPageFactory;

    /**
     * Set the Context and Result Page Factory from DI.
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->_resultsPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Show the Hello World Index Page.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        return $this->_resultsPageFactory->create();
    }
}
```

#### Block/HelloWorld.php

We are going to define a very basic block. Though we don't need this step and could use the standard Magento\Framework\View\Element\Template class, I feel this is worth illustrating. We are simply extending the provided class. In this class, we could define functions to access data. In Magento 2, core practice for display blocks appears to be to do any accessing of data from within the block and not the controller, keeping controllers very lean.

```php
<?php

namespace TheMizzi\HelloWorld\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class HelloWorld
 *
 * @package TheMizzi\HelloWorld\Block
 * @author  Joe Mizzi <jmizzi@gorillagroup.com>
 */
class HelloWorld extends Template
{

}
```

#### view/frontend/layout/helloworld_display_index.xml

Layout files for a route are defined by the syntax of frontName_controllerName_actionName.xml. This layout file will automatically be loaded for that route. Notice that we are using our own block class and defining a template file of helloworld.phtml. Unlike Magento 1, we are doing all of this within our own module directory structure. This will look for a file in view/frontend/templates/helloworld.phtml in our module.

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="../../../../../../../lib/internal/Magento/Framework/View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="TheMizzi\HelloWorld\Block\HelloWorld" name="helloworld" template="helloworld.phtml" />
        </referenceContainer>
    </body>
</page>
```

#### view/frontend/templates/helloworld.phtml

As stated above, our module will automatically look in view/frontend/templates for frontend templates. Here we define a very basic hello world template.

```php
<h1>Hello World!</h1>
```

#### composer.json

Magento 2 allows us to use composer to install modules. Here I have included a basic composer json. Once uploaded to a repository (like this one), you can add this repository to your projects composer json and require "themizzi/magento2-helloworld" to grab this module.

```json
{
    "name": "themizzi/magento2-helloworld",
    "description": "Basic hello world module for Magento 2",
    "require": {
        "php": "~5.5.0|~5.6.0",
        "magento/module-store": "1.0.0-alpha",
        "magento/framework": "1.0.0-alpha",
        "magento/magento-composer-installer": "*"
    },
    "type": "magento2-module",
    "version": "0.0.1",
    "license": [
        "GPL-3.0"
    ],
    "extra": {
        "map": [
            [
                "*",
                "TheMizzi/HelloWorld"
            ]
        ]
    }
}
```

#### Final Steps

After installing this module, you need to activate it, run setup, and clear your cache. To do this, run the following commands from the root of your project

```shell
php bin/magento module:enable TheMizzi_HelloWorld
php bin/magento setup:upgrade
php bin/magento cache:flush --all
```

You should now be able to visit http://myserver.com/helloworld/display (you do not need index as usual, though you can add it) and see the following:

![](https://raw.githubusercontent.com/themizzi/magento2-helloworld/master/assets/helloworld.png)