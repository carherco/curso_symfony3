# Cambiando la estructura de directorios

https://symfony.com/doc/current/configuration/override_dir_structure.html



## Override the cache Directory

You can change the default cache directory by overriding the getCacheDir() method in the AppKernel class of your application:

// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/'.$this->environment.'/cache';
    }
}
In this code, $this->environment is the current environment (i.e. dev). In this case you have changed the location of the cache directory to var/{environment}/cache.

CAUTION
You should keep the cache directory different for each environment, otherwise some unexpected behavior may happen. Each environment generates its own cached configuration files, and so each needs its own directory to store those cache files.


## Override the logs Directory

Overriding the logs directory is the same as overriding the cache directory. The only difference is that you need to override the getLogDir() method:

## Override the web Directory

If you need to rename or move your web directory, the only thing you need to guarantee is that the path to the var directory is still correct in your app.php and app_dev.php front controllers. If you simply renamed the directory, you're fine. But if you moved it in some way, you may need to modify these paths inside those files:

require_once __DIR__.'/../path/to/app/autoload.php';
You also need to change the extra.symfony-web-dir option in the composer.json file:

{
    "...": "...",
    "extra": {
        "...": "...",
        "symfony-web-dir": "my_new_web_dir"
    }
}
TIP
Some shared hosts have a public_html web directory root. Renaming your web directory from web to public_html is one way to make your Symfony project work on your shared host. Another way is to deploy your application to a directory outside of your web root, delete your public_html directory, and then replace it with a symbolic link to the web in your project.

## Override the vendor Directory

To override the vendor directory, you need to introduce changes in the app/autoload.php and composer.json files.

The change in the composer.json will look like this:

{
    "config": {
        "bin-dir": "bin",
        "vendor-dir": "/some/dir/vendor"
    },
}
Then, update the path to the autoload.php file in app/autoload.php:

// app/autoload.php

// ...
$loader = require '/some/dir/vendor/autoload.php';
TIP
This modification can be of interest if you are working in a virtual environment and cannot use NFS - for example, if you're running a Symfony application using Vagrant/VirtualBox in a guest operating system.


# Using Parameters within a Dependency Injection Class

https://symfony.com/doc/current/configuration/using_parameters_in_dic.html

# How to Use PHP instead of Twig for Templates

https://symfony.com/doc/current/templating/PHP.html


