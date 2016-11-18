<?php

namespace Tests\Collections;

use Minerva\Collections\Basis\Exceptions\OverrideOperationException;
use Minerva\Collections\Dictionary;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testOffsetSet()
    {
        $thrown = false;

        try
        {
            $dictionary = new Dictionary();
            $dictionary->setOverrideAllowed(false);

            $dictionary['tank'] = 'panzer';
            $dictionary['tank'] = 'tanque';
        }
        catch (OverrideOperationException $ex)
        {
            $thrown = true;
            $this->assertCount(1, $dictionary);
            $this->assertEquals('panzer', $dictionary['tank']);
        }

        $this->assertTrue($thrown);
    }
}