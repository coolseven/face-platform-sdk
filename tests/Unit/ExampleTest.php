<?php


namespace Coolseven\FacePlatformSdk\Tests\Unit;



use Coolseven\FacePlatformSdk\Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function helloWorld()
    {
        $hello = 'hello';
        $this->assertEquals('hello',$hello);
    }
}