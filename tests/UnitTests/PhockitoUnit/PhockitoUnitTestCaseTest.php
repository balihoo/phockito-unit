<?php

namespace UnitTests\PhockitoUnit;

use Phockito;

use PhockitoUnit\PhockitoUnitTestCase;

class MockableFacet
{
    public function mockableMethod(){
        return 5;
    }

    public function mockableMethod2(){
        return 5;
    }
}


class PhockitoUnitTestCaseTest extends PhockitoUnitTestCase
{
    /** @var  MockableFacet */
    private $mockPrivate;

    /** @var  MockableFacet */
    protected $mockProtected;

    /** @var  MockableFacet */
    public $mockPublic;


    /** @var  MockableFacet */
    private $spyPrivate;

    /** @var  MockableFacet */
    protected $spyProtected;

    /** @var  MockableFacet */
    public $spyPublic;

    /** @var  MockableFacet */
    public $someOtherThing;

    public function testMockGeneration()
    {

        $this->assertNull($this->someOtherThing, "non matching prefix remains");

        $this->assertNotNull($this->mockPrivate);
        $this->assertNotNull($this->mockProtected);
        $this->assertNotNull($this->mockPublic);

        Phockito::when($this->mockPrivate->mockableMethod())->return("Private");
        Phockito::when($this->mockProtected->mockableMethod())->return("Protected");
        Phockito::when($this->mockPublic->mockableMethod())->return("Public");

        $this->assertEquals("Private", $this->mockPrivate->mockableMethod() );
        $this->assertEquals("Protected", $this->mockProtected->mockableMethod() );
        $this->assertEquals("Public", $this->mockPublic->mockableMethod() );

    }


    public function testSpyGeneration()
    {

        $this->assertNotNull($this->spyPrivate);
        $this->assertNotNull($this->spyProtected);
        $this->assertNotNull($this->spyPublic);

        Phockito::when($this->spyPrivate->mockableMethod())->return("Private");
        Phockito::when($this->spyProtected->mockableMethod())->return("Protected");
        Phockito::when($this->spyPublic->mockableMethod())->return("Public");

        $this->assertEquals("Private", $this->spyPrivate->mockableMethod() );
        $this->assertEquals("Protected", $this->spyProtected->mockableMethod() );
        $this->assertEquals("Public", $this->spyPublic->mockableMethod() );

        $this->assertEquals(5, $this->spyPrivate->mockableMethod2() );
        $this->assertEquals(5, $this->spyProtected->mockableMethod2() );
        $this->assertEquals(5, $this->spyPublic->mockableMethod2() );


    }

    public function testHamcrestEnabled(){
        $this->assertTrue(anything() instanceof \Hamcrest_Matcher);
    }
}