[![Build Status](https://travis-ci.org/balihoo/phockito-unit.png?branch=master)](https://travis-ci.org/balihoo/phockito-unit)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/balihoo/phockito-unit/badges/quality-score.png?s=dc520b8a38a519cd2a32e98420a557a5ccb71195)](https://scrutinizer-ci.com/g/balihoo/phockito-unit/)
[![Code Coverage](https://scrutinizer-ci.com/g/balihoo/phockito-unit/badges/coverage.png?s=ae903273910ea4d214ba4bf65a4681d77bffddf3)](https://scrutinizer-ci.com/g/balihoo/phockito-unit/)
[![Latest Stable Version](https://poser.pugx.org/balihoo/phockito-unit/v/stable.png)](https://packagist.org/packages/balihoo/phockito-unit)
[![Total Downloads](https://poser.pugx.org/balihoo/phockito-unit/downloads.png)](https://packagist.org/packages/balihoo/phockito-unit)
[![Latest Unstable Version](https://poser.pugx.org/balihoo/phockito-unit/v/unstable.png)](https://packagist.org/packages/balihoo/phockito-unit)

PhockitoUnit
============

PhockitoUnit exists to marry [PHP Unit](https://github.com/sebastianbergmann/phpunit/) with the [Phockito](https://github.com/hafriedlander/phockito) mocking framework in an everlasting love praised by PHP developers everywhere.  It's features are rather simple:
* Automatically generate mocks that your tests require
* Automatically generate spys that your tests require
* Automatically turn on hamcrest matching
That's it!

PhockitoUnit in Action
============
Here is a very classic PHP Unit test that uses Phockito to mock a dependency
```
class SomeTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){
    Phockito::include_hamcrest();
  }
  
  testSomeMethod(){
    /** @var SomeDependency $mockDependency **/
    $mockDependency = Phockito::mock('SomeDependency');
    Phockito::when($mockDependency->dependentMethod(anything()))->return("value");
    
    $instance = new ThingThatNeedsDependency($mockDependency);
    
    $this->assertEquals("value", $instance->methodThatUsesDependency());
  }
  
  testSomeMethodWhenSomeDependencyThrows(){
    /** @var SomeDependency $mockDependency **/
    $mockDependency = Phockito::mock('SomeDependency');
    Phockito::when($mockDependency->dependentMethod(anything()))->throw(new Exception("Some error"));
    
    $instance = new ThingThatNeedsDependency($mockDependency);
    try{
      $instance->methodThatUsesDependency());
      $this->fail("Expected exception not thrown");
    } catch(Exception $ex) {
      $this->assertEquals("Some error", $ex->getMessage());
    }
  }
}
```
Certainly you have encoutnered or written a unit tests that is at least similar to this structure.  PhockitoUnit simplifies this structure by eliminating some common boilerplate, here it is:

```
class SomeTest extends \PhockitoUnit\PhockitoUnitTestCase
{
  
  /** @var SomeDependency **/
  protected $mockDependency;
  
  testSomeMethod(){
    
    Phockito::when($this->mockDependency->dependentMethod(anything()))->return("value");
    
    $instance = new ThingThatNeedsDependency($mockDependency);
    
    $this->assertEquals("value", $instance->methodThatUsesDependency());
  }
  
  testSomeMethodWhenSomeDependencyThrows(){

    Phockito::when($this->mockDependency->dependentMethod(anything()))->throw(new Exception("Some error"));
    
    $instance = new ThingThatNeedsDependency($mockDependency);
    try{
      $instance->methodThatUsesDependency());
      $this->fail("Expected exception not thrown");
    } catch(Exception $ex) {
      $this->assertEquals("Some error", $ex->getMessage());
    }
  }
}
```
It's not a monsterous change, but it helps quite a bit, eliminating the chance of class name typos, class rename refactorings, etc.  And in more advanced scenarios where you are mocking an domain object graph it can make it easier to write more tests.  More tests means more coverage of intent.  Here's an example that sets up a graph and uses a spy:
```
class FamilyTest extends \PhockitoUnit\PhockitoUnitTestCase
{
  
  /** @var Child **/
  protected $mockChild1;
  
  /** @var Child **/
  protected $spyChild2;
  
  /** @var Parent **/
  protected $mockParent;
  
  public function setUp(){
    parent::setUp();
    
    Phockito::when($this->mockParent->getEledestChild())->return($this->mockChild1);
    Phockito::when($this->mockParent->getYoungestChild())->return($this->spyChild1);
    
  }
  
  testGetEldestChildNickName(){
    
    Phockito::when($this->mockChild1->getNickName())->return("Oldie");
    
    $family = new Family(array($this->mockParent));
    
    $this->assertEquals("Oldie", $family->getElestChildNickName());
  }
  
  testGetYoungestchildFullName(){
    
    Phockito::when($this->spyChild2->getFirstName())->return("Youngy");
    Phockito::when($this->spyChild2->getLastName())->return("McYoung");
    
    $family = new Family(array($this->mockParent));
    
    $this->assertEquals("Youngy McYoung", $parent->testGetYoungestchildFullName());
  }
}
```


Do you use a DI Framework?
============
If you use Phockito to mock things, then you likely use a DI framework.  If you do we suggest building a package on top of this to register your mocks in your DI container automatically.  We use [PHP-DI](https://github.com/mnapoli/PHP-DI) and so we have built [PhockitoUnit-PHP-DI](https://github.com/balihoo/phockito-unit-php-di) to make it that much easier to test application code.
