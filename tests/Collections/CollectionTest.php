<?php

namespace Tests\Collections;

use Minerva\Collections\Basis\Exceptions\InvalidOffsetException;
use Minerva\Collections\Basis\Exceptions\MaxCapacityReachedException;
use Minerva\Collections\Collection;

/**
 * Class CollectionTest
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Tests\Collections
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInsertion()
    {
        $collection = new Collection();
        $collection->add(1);
        $collection->add(2);
        $collection->add(3);
        $collection->add(4);
        $collection->add(5);

        $this->assertEquals(5, $collection->count());
    }

    public function testReading()
    {
        $pessoa1 = new \stdClass();
        $pessoa1->idade = 2;

        $pessoa2 = new \stdClass();
        $pessoa2->idade = 5;

        $collection = new Collection();
        $collection->add($pessoa1);
        $collection->add($pessoa2);

        $filter1 = $collection->filter(function($pessoa){
           return $pessoa->idade < 4;
        });

        $filter2 = $collection->filter(function($pessoa){
           return $pessoa->idade > 4;
        });

        $this->assertEquals($filter1->count(), 1);
        $this->assertEquals($filter2->count(), 1);
        $this->assertEquals($collection->count(), 2);
    }

    /**
     * @expectedException \Minerva\Collections\Basis\Exceptions\ReadOnlyStorageException
     */
    public function testReadyOnly()
    {
        $collection = new Collection();
        $collection->add('Item 1');
        $collection->lock();
        $collection->add('Item 2');
    }

    public function testCapacity()
    {
        $collection = new Collection();
        $collection->setCapacity(1);
        $collection->add('Item 1');

        try
        {
            $collection->add('Item 2');
        }
        catch(MaxCapacityReachedException $ex)
        {
            $this->assertTrue(true);
        }

        $this->assertCount(1, $collection);
    }

    public function testArrayAccess()
    {
        $lucas = new \stdClass();
        $lucas->idade = 21;

        $matheus = new \stdClass();
        $matheus->idade = 15;

        $collection = new Collection();
        $collection->add($lucas);
        $collection->add($matheus);

        $maioresDeIdade = $collection->filter(function($pessoa){
            return $pessoa->idade >= 18;
        });

        $this->assertEquals($maioresDeIdade[0]->idade, $lucas->idade);
        $this->assertCount(1, $maioresDeIdade);
    }

    public function testInvalidOffset()
    {
        $collection = new Collection();
        $exception1 = false;
        $exception2 = false;

        try
        {
            $collection->offsetGet('ronaldo');
        }
        catch (InvalidOffsetException $ex)
        {
            $exception1 = true;
        }

        try
        {
            $collection->offsetUnset('ronaldo');
        }
        catch (InvalidOffsetException $ex)
        {
            $exception2 = true;
        }

        $this->assertTrue($exception1);
        $this->assertTrue($exception2);
    }
}