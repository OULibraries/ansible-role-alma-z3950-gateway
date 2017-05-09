OULibraries.alma-z3950-gateway
=========

Alma Z39.50 Gateway for OU Libraries

Requirements
------------

CentOS 7.x
Apache
MariaDB

Role Variables
--------------

See defaults/main.yml here and in roles noted as dependencies.

Dependencies
------------

```
- src: https://github.com/OULibraries/ansible-role-apache2
  version: v2016-10-17.0
  name: OULibraries.apache2

- src: https://github.com/OULibraries/ansible-role-centos7
  version: v2016-10-21.0
  name: OULibraries.centos7

- src: https://github.com/OULibraries/ansible-role-mariadb
  version: v2016-09-26.0
  name: OULibraries.mariadb

- src: https://github.com/OULibraries/ansible-role-users
  version: v2016-11-14.0
  name: OULibraries.users
```

Example Playbook
----------------

License
-------

[MIT](https://github.com/OULibraries/ansible-role-zlma-z3950-gateway/blob/master/LICENSE)

Author Information
------------------

Jason Sherman
