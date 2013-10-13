PhockitoUnit
============

PhockitoUnit exists to marry [PHP Unit](https://github.com/sebastianbergmann/phpunit/) with the [Phockito](https://github.com/hafriedlander/phockito) mocking framework in an everlasting love praised by PHP developers everywhere.  It's features are rather simple:
* Automatically generate mocks that your tests require
* Automatically generate spys that your tests require
That's it!

Example
============


Do you use DI?
============
Hopefully you use DI.  If you do we suggest building a package on top of this to register your mocks in your DI container automatically.  We use [PHP-DI]
