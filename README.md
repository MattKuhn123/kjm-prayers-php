# kjm prayer board (php)

## how to run locally

### how to configure local environment

1. [download thread safe executable](https://windows.php.net/download#php-8.3)
1. extract to `c:\php`
1. create `test.php` as `<?php echo phpInfo() ?>`
1. execute `php .\test.php`
1. paste output [here](https://xdebug.org/wizard) and follow instructions from there

### how to run locally

1. execute `php -S localhost:8000`

### recommended vs code extensions

1. PHP Intelephense

## how to run on server

[reference](https://www.sitepoint.com/how-to-install-php-on-windows/#installingapacheoptional)

### how to configure server environment

1. [download thread safe executable](https://windows.php.net/download#php-8.3)
1. extract to `c:\php`
1. [download apache lounge](https://www.apachelounge.com/download/VS17/binaries/httpd-2.4.62-240904-win64-VS17.zip)
1. extract Apache24 to `c:\Apache24`
1. *(may not be needed, but:)* [download vc_redist_x64](https://aka.ms/vs/17/release/VC_redist.x64.exe)
1. edit `httpd.conf`, add lines

    ``` properties
    # PHP8 module
    PHPIniDir "C:/php"
    LoadModule php_module "C:/php/php8apache2_4.dll"
    AddType application/x-httpd-php .php
    ```

1. edit `httpd.conf`

    ```xml
    <!-- change -->
    <IfModule dir_module>
        DirectoryIndex index.html
    </IfModule>
    ```

    ``` xml
    <!-- to -->
    <IfModule dir_module>
        DirectoryIndex index.php index.html
    </IfModule>
    ```

### how to deploy to server

1. copy files to `htdocs\`

### how to run server

1. navigate to `C:\Apache24\bin` and execute `httpd`