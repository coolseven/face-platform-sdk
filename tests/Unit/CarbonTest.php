<?php /** @noinspection PhpNonStrictObjectEqualityInspection */
/** @noinspection TypeUnsafeComparisonInspection */

/** @noinspection PhpUnitTestsInspection */


namespace Coolseven\FacePlatformSdk\Tests\Unit;


use Carbon\Carbon;
use Orchestra\Testbench\TestCase;

class CarbonTest extends TestCase
{
    /**
     * @test
     */
    public function carbon_objects_can_not_be_compared_by_operator() : void
    {
        $time1 = Carbon::createFromTimeString('2019-09-25 01:01:01');
        $time2 = Carbon::createFromTimeString('2019-09-25 01:01:01');
        $this->assertTrue($time1 == $time2);
        $this->assertFalse($time1 === $time2);
        $this->assertFalse($time1 > $time2);
        $this->assertFalse($time1 < $time2);

        $time3 = Carbon::createFromTimeString('2019-09-26 01:01:01');
        $time4 = Carbon::createFromTimeString('2019-09-26 02:02:02');
        $this->assertFalse($time3 == $time4);
        $this->assertFalse($time3 === $time4);
        $this->assertTrue($time3 < $time4);
        $this->assertFalse($time3 > $time4);

        $time5 = Carbon::now();
        $time6 = $time5->addMinute();
        $this->assertTrue($time5 == $time6);
        $this->assertTrue($time5 === $time6);
        $this->assertFalse($time5 < $time6);
        $this->assertFalse($time5 > $time6);

        $time7 = Carbon::now()->addMinutes(2);
        $time8 = Carbon::now()->addMinutes(3);
        $this->assertFalse($time7 == $time8);
        $this->assertFalse($time7 === $time8);
        $this->assertTrue($time7 < $time8);
        $this->assertFalse($time7 > $time8);

        $time9 = Carbon::now();
        $time10 = $time9->clone();
        $this->assertTrue($time9 == $time10);
        $this->assertFalse($time9 === $time10);
        $this->assertFalse($time9 < $time10);
        $this->assertFalse($time9 > $time10);
        $this->assertTrue($time9 < $time9->clone()->addMinutes(2));
        $this->assertTrue($time9 > $time9->clone()->subMinutes(10));
    }
}