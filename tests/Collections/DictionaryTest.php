<?php

namespace Tests\Collections;

use Minerva\Collections\Basis\Exceptions\OverrideOperationException;
use Minerva\Collections\Dictionary;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testOffsetSet()
    {
        $thrown = false;

        $dictionary = new Dictionary();
        $dictionary->setOverrideAllowed(false);

        try
        {
            $dictionary['tank'] = 'panzer';
            $dictionary['tank'] = 'tanque';
        }
        catch (OverrideOperationException $ex)
        {
            $thrown = true;
        }

        $this->assertCount(1, $dictionary);
        $this->assertEquals('panzer', $dictionary['tank']);
        $this->assertTrue($thrown);

        $dictionary->setOverrideAllowed(true);
        $thrown = false;

        try
        {
            $dictionary['tank'] = 'panzer';
            $dictionary['tank'] = 'tanque';
        }
        catch (OverrideOperationException $ex)
        {
            $thrown = true;
        }

        $this->assertFalse($thrown);
        $this->assertEquals('tanque', $dictionary['tank']);
    }
}