# Magenerds_Ldap
[![Latest Stable Version](https://img.shields.io/packagist/v/magenerds/ldap.svg?style=flat-square)](https://packagist.org/packages/magenerds/ldap)
[![License](https://img.shields.io/packagist/l/magenerds/ldap.svg?style=flat-square)](https://packagist.org/packages/magenerds/ldap)

## Installation through Composer
Add `"magenerds/ldap": "~2.0"` to the require block in your composer.json and then run `composer install`.

```json
{
	"require": {
		"magenerds/ldap": "~2.0"
	}
}
```

Alternatively, you can simply run the following from the command line:

```sh
composer require magenerds/ldap "~2.0"
```

## Configuration
There are several ways to configure the ldap module for your instance and your 
environment. You can use Magento's `setup:config:set` command and/or set the options
within the `setup:install` command. However, in each case Magento will persist the
configuration data in `app/etc/env.php`. You can edit this file manually and deploy
or mount it to your target environment.

### Command options 
for `setup:config:set` and `setup:install`
```sh
     --ldap-host                  Ldap host
     --ldap-port                  Ldap Port (default: "389")
     --ldap-use-tls               For the sake of security, this should be `yes` if the server has the necessary certificate installed.
     --ldap-use-ssl               Possibly used as an alternative to useStartTls
     --ldap-bind-requires-dn      Required and must be `yes`, as OpenLDAP requires that usernames be in DN form when performing a bind.
     --ldap-base-dn               As with all servers, this option is required and indicates the DN under which all accounts being authenticated are located.
     --ldap-bind-dn               Required and must be a DN, as OpenLDAP requires that usernames be in DN form when performing a bind. Try to use an unprivileged account.
     --ldap-bind-password         The password corresponding to the username above, but this may be omitted if the LDAP server permits an anonymous binding to query user accounts.
     --ldap-allow-empty-password  Allow empty password
     --ldap-cache-password        To save the user password in the Magento database. Then, users will be able to log in even when the LDAP server is not reachable.
     --ldap-role                  Role that is assigned by default if the LDAP attribute is not set or not set to a valid role name
     --ldap-user-filter           Ldap search filter. Placeholders are ":usernameAttribute" and ":username". (default: "(&(objectClass=*)(:usernameAttribute=:username))")
     --ldap-attribute-username    Attribute in LDAP defining the user’s username. (default: "uid")
     --ldap-attribute-first-name  Attribute in LDAP defining the user’s first name. (default: "givenname")
     --ldap-attribute-last-name   Attribute in LDAP defining the user’s last name. (default: "sn")
     --ldap-attribute-email       Attribute in LDAP defining the user’s email. (default: "mail")
     --ldap-attribute-role        Attribute in LDAP defining the Magento role. (default: role specified in --ldap-role")

```

Use `bin/magento setup:config:set --help` or `bin/magento setup:install --help`
for further information. 

Also see at [LDAP Authentication](https://framework.zend.com/manual/1.10/en/zend.auth.adapter.ldap.html) for a more details.

#### Ldap user filter
Minimal search filter

```
(&(objectClass=*)(:usernameAttribute=:username))
```

Example for memberOf

```
(&(memberOf=cn=magento,ou=groups,dc=github,dc=com)(objectClass=person)(:usernameAttribute=:username))
```


### (optional) env.php
```php
'ldap' => array(
    'host' => 'ldap',
    'port' => '389',
    'base-dn' => 'ou=users,dc=github,dc=com',
    'bind-dn' => 'cn=admin,dc=github,dc=com',
    'bind-password' => 'password',
    'role' => 'Administrator',
    'user-filter' => '(&(objectClass=*)(:usernameAttribute=:username))',
    'attribute' => array(
        'username' => 'uid',
        'first-name' => 'givenname',
        'last-name' => 'sn',
        'email' => 'mail',
        'role' => 'magerole',
    ),
    'allow-empty-password' => false,
    'cache-password' => false,
    'use-tls' => false,
    'use-ssl' => false,
    'bind-requires-dn' => false,
)
```

## Licence

magenerds/ldap is distributed under the terms of the [OSL-3.0](https://github.com/magenerds/ldap/blob/master/LICENSE.md)

 
