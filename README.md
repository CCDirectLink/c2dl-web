# https://c2dl.info

Content of the c2dl.info website(s)

## Environment

```
- PHP: 7.3
- Composer
- NodeJS (over php)
- MySQL
```

Possibilities:

- Page creation fully with php
- Page creation with html templates
- Static html
- Page creation with nodejs

## Environment Variables

### Global

| Variable          | Git Directory        | Used                                                   |
|:----------------- |:-------------------- |:------------------------------------------------------ |
| C2DL_ROOT         | /                    | Git root                                               |
| `C2DL_SYS`        | /src                 | Global sources (can be used for multiples sub/domains) |
| `C2DL_SYS_PAGE`   | /src/page            | Helper for page creation                               |
| `C2DL_LOG`        | /logs                | Log directory                                          |

| Variable          | Value                | Used                                                   |
|:----------------- |:-------------------- |:------------------------------------------------------ |
| `APPLICATION_ENV` | `prod`               | Production environment                                 |
| `APPLICATION_ENV` | `dev`                | Developpment environment                               |

### Page specific

| Variable          | Git Directory        | Used                                                   |
|:----------------- |:-------------------- |:------------------------------------------------------ |
| `C2DL_WWW`        | /www-c2dl            | <https://c2dl.info> page root                          |
| `C2DL_WWW_LOG`    | /logs/www-c2dl       | Logs for <https://c2dl.info> (*.log)                   |
| `C2DL_WWW_RES`    | /www-c2dl/res        | Resource directory                                     |
| `C2DL_LOG`        | /logs                | Log directory                                          |

### Additional - may be required In development environment

This environment variables are automatically configured and not accessible in the Production environment.
They are required in your development environment.

| Variable            | Used                                                  |
|:------------------- |:----------------------------------------------------- |
| `C2DL_DB_MAIN_USER` | User for database `main`                              |
| `C2DL_DB_MAIN_PASS` | Password for database `main`                          |
| `C2DL_DB_MAIN_HOST` | Host for database `main`                              |
| `C2DL_DB_MAIN_DB`   | Database name for database `main`                     |
| `C2DL_NODE_EXEC`    | NodeJS executable                                     |
| `C2DL_NPM_EXEC`     | NPM executable                                        |

## Structure

```
/
  .internal             (1)
    - ommited -

  .local                (2)
    - ommited -

  logs                  (3)
     www-c2dl           (3.1)
     .htaccess          (3.2)

  src                   (4)
     _internal          (4.1)
       envGetter.php    (4.1.1)

     page               (4.2)
       vendor           (4.2.1)
         - ommited -
       composer.json    (4.2.2)
       composer.lock    (4.2.3)

     .htaccess          (4.3)
     Database.php       (4.4)
     Node.php           (4.5)
     Redirect.php       (4.6)
     Service.php        (4.7)

  usage (5)
    - ommited -

  www-c2dl (6)
    admin (6.1)
      - ommited -
    
    cc                  (6.2)
      .htaccess         (6.2.1)
      index.php         (6.2.2)
    
    media               (6.3)
      - ommited -
    
    res                 (6.4)
      img               (6.4.1)
      js                (6.4.2)
      style             (6.4.3)
        colorset        (6.4.3.1)
          dark.css      (6.4.3.1.1)
          light.css     (6.4.3.1.2)
        
        base.css        (6.4.3.2)
        main.css        (6.4.3.3)
        
      template          (6.4.4)
        _component      (6.4.4.1)
          .htaccess     (6.4.4.1.1)
          uri-list.html (6.4.4.1.2)
          
        .htaccess       (6.4.4.2)
        base.html       (6.4.4.3)
        main.html       (6.4.4.4)
    
    .user.ini           (6.5)
    index.php           (6.6)
    robots.txt          (6.7)
  
  .gitignore            (7)
  .htaccess             (8)
  index.php             (9)
  README.md            (10)
```

### Root

| Id   | Name        | Type      | Used                                                   |
|:---- |:----------- |:--------- |:------------------------------------------------------ |
| 1    | .internal/  | Directory | Internal use only (excluded from repo)                 |
| 2    | .local/     | Directory | NodeJS environment (excluded from repo)                |
| 3    | logs/       | Directory | Log directory (*.log files excluded from repo)         |
| 4    | src/        | Directory | Global sources (can be used for multiples sub/domains) |
| 5    | usage/      | Directory | Reserved (web statistics)                              |
| 6    | www-c2dl/   | Directory | <https://c2dl.info> page root                          |
| 7    | .gitignore  | File      | Git ignore                                             |
| 8    | .htaccess   | File      | Global access settings (.ini)                          |
| 9    | index.php   | File      | Empty - prevents from showing content (not used)       |
| 10   | README.md   | File      | Information and examples                               |

### Logs

| Id   | Name        | Type      | Used                                                   |
|:---- |:----------- |:--------- |:------------------------------------------------------ |
| 3.1  | www-c2dl/   | Directory | Logs directory for <https://c2dl.info>                 |
| 3.2  | .htaccess   | File      | Access settings (denied)                               |

### Global sources (src)

| Id      | Name          | Type      | Used                                                   |
|:------- |:------------- |:--------- |:------------------------------------------------------ |
| 4.1     | _internal/    | Directory | Limited service functions (use only allowed in src)    |
| 4.1.1   | envGetter.php | File      | Interface for protected environment variables          |
| 4.2     | page          | Directory | Helper for page creation                               |
| 4.2.1-3 | ...           | ...       | Composer files, folder & build                         |
| 4.3     | .htaccess     | File      | Access settings (denied)                               |
| 4.4     | Database.php  | File      | Database interface - PDO Access                        |
| 4.5     | Node.php      | File      | NodeJS interface                                       |
| 4.6     | Redirect.php  | File      | Redirect logic                                         |
| 4.7     | Service.php   | File      | Service functions                                      |

### Page root

| Id        | Name          | Type      | Used                                                     |
|:--------- |:------------- |:--------- |:-------------------------------------------------------- |
| 6.1       | admin/        | Directory | Admin interface (**currently** excluded from repo)       |
| 6.2       | cc/           | Directory | Main page location                                       |
| 6.2.1     | .htaccess     | File      | Rewrite every url to index.php?id=...                    |
| 6.2.2     | index.php     | File      | Main page                                                |
| 6.3       | media/        | Directory | Downloadable content (excluded from repo)                |
| 6.4       | res/          | Directory | Resource directory (images, stylesheets, templates, ...) |
| 6.4.1     | img/          | Directory | Image resources                                          |
| 6.4.2     | js/           | Directory | JavaScript resources                                     |
| 6.4.3     | style/        | Directory | Stylesheets                                              |
| 6.4.3.1   | colorset/     | Directory | Color-Set                                                |
| 6.4.3.1.1 | dark.css      | File      | Color-Set (dark)                                         |
| 6.4.3.1.2 | light.css     | File      | Color-Set (light)                                        |
| 6.4.3.2   | base.css      | File      | Base structure                                           |
| 6.4.3.3   | main.css      | File      | Main page specifics                                      |
| 6.4.4     | template/     | Directory | HTML Templates (not accessible from website)             |
| 6.4.4.1   | _component    | Directory | Template components                                      |
| 6.4.4.1.1 | .htaccess     | File      | Access settings (denied)                                 |
| 6.4.4.1.2 | uri-list.html | File      | URI-List Component                                       |
| 6.4.4.2   | .htaccess     | File      | Access settings (denied)                                 |
| 6.4.4.3   | base.html     | File      | Basic HTML structure                                     |
| 6.4.4.4   | main.html     | File      | Main page specifics                                      |
| 6.5       | .user.ini     | File      | PHP-ini-File (has to be in page root)                    |
| 6.6       | index.php     | File      | Redirect to <https://c2dl.info/cc>                       |
| 6.7       | robots.txt    | File      | Robots                                                   |

## PHP Components & Templates

Reference:

- https://github.com/PhpGt/Dom
- https://github.com/PhpGt/DomTemplate

## Predefined PHP Interfaces

### Database

```php
require_once( getenv('C2DL_SYS', true) . '/Database.php');
use c2dl\sys\db\Database;

$databaseArray = Database::createPDO();
```

`main` Database (if available): `$databaseArray['main']`

#### Interface

```
Database::createPDO( [ array $options ] ) : iterable;
```

Reference: <https://www.php.net/manual/en/book.pdo.php>

### NodeJS Content

```php
require_once( getenv('C2DL_SYS') . '/Node.php' );
use \c2dl\sys\node\Node;

echo (Node::nodeJS('-v'));
```

or

```
echo (Node::nodeJS('example.js'));
```

#### Interface

```
Node::nodeJS( string $command [, array &$output [, int &$return_var ]] ) : string;
```

-------

CCDirectLink <info@c2dl.info>
