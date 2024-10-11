# kjm prayer board (php)

## how to run locally

### how to configure local environment

1. [download thread safe executable](https://windows.php.net/download#php-8.3)
1. extract to `c:\php`
1. create `test.php` as `<?php echo phpInfo() ?>`
1. execute `php .\test.php`
1. paste output [here](https://xdebug.org/wizard) and follow instructions from there

### how to run locally

1. uncomment *(delete the semicolon)* `extension=mysqli` in `php.ini`
1. set the properties under `[MySQLi]`
    1. mysqli.default_host =localhost
    1. mysqli.default_user =....
    1. mysqli.default_pw =........
1. execute `php -S localhost:8000`

### recommended vs code extensions

1. PHP Intelephense

### launch.json

``` json
{
    // Use IntelliSense to learn about possible attributes.
    // Hover to view descriptions of existing attributes.
    // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 0,
            "runtimeArgs": [
                "-dxdebug.start_with_request=yes"
            ],
            "env": {
                "XDEBUG_MODE": "debug,develop",
                "XDEBUG_CONFIG": "client_port=${port}"
            }
        },
        {
            "name": "Launch Built-in web server",
            "type": "php",
            "request": "launch",
            "runtimeArgs": [
                "-dxdebug.mode=debug",
                "-dxdebug.start_with_request=yes",
                "-S",
                "localhost:0"
            ],
            "program": "",
            "cwd": "${workspaceRoot}",
            "port": 9003,
            "serverReadyAction": {
                "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                "uriFormat": "http://localhost:%s",
                "action": "openExternally"
            }
        }
    ]
}
```

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
1. uncomment *(delete the semicolon)* `extension=mysqli` in `php.ini`
1. set the properties under `[MySQLi]`
    1. mysqli.default_host =localhost
    1. mysqli.default_user =....
    1. mysqli.default_pw =........

### how to deploy to server

1. copy files to `htdocs\`

### how to run server

1. navigate to `C:\Apache24\bin` and execute `httpd`