PhockitoUnit
============

PhockitoUnit exists to marry [PHP Unit](https://github.com/sebastianbergmann/phpunit/) with the [Phockito](https://github.com/hafriedlander/phockito) mocking framework in an everlasting love praised by PHP developers everywhere.  It's features are rather simple:
* Automatically generate mocks that your tests require
* Automatically generate spys that your tests require
* Automatically turn on hamcrest matching
That's it!

PhockitoUnit in Action
============


Do you use DI?
============
If you use Phockito to mock things, then you likely use DI.  If you do we suggest building a package on top of this to register your mocks in your DI container automatically.  We use [PHP-DI](https://github.com/mnapoli/PHP-DI) and so we have built [PhockitoUnit-PHP-DI](https://github.com/mnapoli/PHP-DI) to make it that much easier to test application code.
