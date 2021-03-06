<?php

namespace Tests\Entities;

use Portal\Entities\EventEntity;
use \Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

class EventEntityTest extends TestCase
{
    public function testValidateExistsAndLength()
    {
        $characterLength = 255;
        $eventName = 'Hiring Event';
        $result = EventEntity::ValidateExistsAndLength($eventName, $characterLength);
        $this->assertEquals($result, 'Hiring Event');
    }

    public function testValidateExistsAndLengthFailure()
    {
        $characterLength = 20;
        $eventName = '';
        $this->expectException(Exception::class);
        EventEntity::ValidateExistsAndLength($eventName, $characterLength);
    }

    public function testValidateExistsAndLengthLongFailure()
    {
        $characterLength = 20;
        $location = '1 Widcombe Cres, Bath BA2 6AH 1 Widcombe Cres, Bath BA2 6AH 1 Widcombe Cres, Bath BA2 6AH';
        $this->expectException(Exception::class);
        EventEntity::ValidateExistsAndLength($location, $characterLength);
    }

    public function testValidateExistsAndLengthMalform()
    {
        $characterLength = 10;
        $name = [11, 22, 33];
        $this->expectException(TypeError::class);
        EventEntity::ValidateExistsAndLength($name, $characterLength);
    }

    public function testValidateLengthSuccess()
    {
        $characterLength = 255;
        $location = '1 Widcombe Cres, Bath BA2 6AH';
        $result = EventEntity::ValidateLength($location, $characterLength);
        $this->assertEquals($result, '1 Widcombe Cres, Bath BA2 6AH');
    }

    public function testValidateLengthFailure()
    {
        $characterLength = 20;
        $location = '1 Widcombe Cres, Bath BA2 6AH 1 Widcombe Cres, Bath BA2 6AH 1 Widcombe Cres, Bath BA2 6AH';
        $this->expectException(Exception::class);
        EventEntity::ValidateLength($location, $characterLength);
    }

    public function testValidateLengthMalform()
    {
        $characterLength = 20;
        $name = [11, 22, 33];
        $this->expectException(TypeError::class);
        EventEntity::ValidateLength($name, $characterLength);
    }

    public function testGetEventIdSuccess()
    {
        $name = new EventEntity(
            1,
            'hiring event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-04',
            '18:00',
            '21:00',
            '',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getEventId();
        $this->assertEquals($result, 1);
    }

    public function testGetEventNameSuccess()
    {
        $name = new EventEntity(
            1,
            'hiring event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-04',
            '18:00',
            '21:00',
            '',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getName();
        $this->assertEquals($result, 'hiring event');
    }

    public function testGetCategorySuccess()
    {
        $name = new EventEntity(
            1,
            'hiring event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '1970-01-01',
            '12:34',
            '16:00',
            '',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getCategory();
        $this->assertEquals($result, 2);
    }

    public function testValidateCategoryExistsSuccess()
    {
        $category = 3;
        $categoryList = ['1' => 'Other', '2' => 'Tasty', '3' => 'Armageddon', '4' => 'Visit'];
        $expected = 3;
        $result = EventEntity::validateCategoryExists($category, $categoryList);
        $this->assertEquals($expected, $result);
    }

    public function testValidateCategoryExistsInvalidCategory()
    {
        $category = 9;
        $categoryList = ['1' => 'Other', '2' => 'Tasty', '3' => 'Armageddon', '4' => 'Visit'];
        $this->expectException(Exception::class);
        EventEntity::validateCategoryExists($category, $categoryList);
    }

    public function testGetLocationSuccess()
    {
        $name = new EventEntity(
            1,
            'Taster Session',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-02',
            '18:00',
            '21:00',
            'notes',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getLocation();
        $this->assertEquals($result, '1 Widcombe Cres, Bath BA2 6AH');
    }

    public function testGetDateSuccess()
    {
        $name = new EventEntity(
            1,
            'hiring event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-02',
            '18:00',
            '21:00',
            'notes',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getDate();
        $this->assertEquals($result, '2019-10-02');
    }

    public function testGetStartTimeSuccess()
    {
        $name = new EventEntity(
            1,
            'Misc Event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-02',
            '18:00',
            '21:00',
            'notes',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getStartTime();
        $this->assertEquals($result, '18:00');
    }

    public function testGetEndTimeSuccess()
    {
        $name = new EventEntity(
            1,
            'hiring event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-02',
            '18:34',
            '21:00',
            '',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getEndTime();
        $this->assertEquals($result, '21:00');
    }

    public function testGetNotesSuccess()
    {
        $name = new EventEntity(
            1,
            'hiring event',
            2,
            '1 Widcombe Cres, Bath BA2 6AH',
            '2019-10-02',
            '18:00',
            '21:00',
            'notes',
            ['1' => 'Other', '2' => 'Hiring Event']
        );
        $result = $name->getNotes();
        $this->assertEquals($result, 'notes');
    }

    public function testValidateStartEndTimeSuccess()
    {
        $startTime = '18:00';
        $endTime = '20:00';
        $result = EventEntity::validateStartEndTime($startTime, $endTime);
        $this->assertEquals($result, true);
    }

    public function testValidateStartEndTimeFailure()
    {
        $startTime = '22:00';
        $endTime = '20:00';
        $this->expectException(Exception::class);
        EventEntity::validateStartEndTime($startTime, $endTime);
    }

    public function testValidateTimeSuccess()
    {
        $time = '18:00';
        $result = EventEntity::validateTime($time);
        $this->assertEquals($result, $time);
    }

    public function testValidateTimeFailure()
    {
        $time = 'This is not how time looks like';
        $this->expectException(Exception::class);
        EventEntity::validateTime($time);
    }

    public function testValidateDateSuccess()
    {
        $date = '2019-10-01';
        $result = EventEntity::validateDate($date);
        $this->assertEquals($result, '2019-10-01');
    }

    public function testValidateDateFailure()
    {
        $date = 'This is not how date looks like';
        $this->expectException(Exception::class);
        EventEntity::validateDate($date);
    }

    public function testNewEventEntitySuccess()
    {
        $newEventEntity = new EventEntity(
            1,
            'new event',
            2,
            '1 widcomb',
            '2019-01-01',
            "12:00",
            "14:00",
            '',
            ['1' => 'Thing', '2' => 'Wing']
        );
        $this->assertInstanceOf(EventEntity::class, $newEventEntity);
    }
}
