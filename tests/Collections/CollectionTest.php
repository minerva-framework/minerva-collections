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

    public function testCopyTo()
    {
        $array = [3, 2, 1, 4, 5, 6];

        $collection = new Collection();
        $collection->add(1);
        $collection->add(2);
        $collection->add(3);

        // Copiando com override
        $collection->copyTo($array);
        $this->assertEquals(1, $collection[0]);
        $this->assertEquals(2, $collection[1]);
        $this->assertEquals(3, $collection[2]);

        // Copiando sem override
        $array = [9];
        $collection->copyTo($array, false);
        $this->assertEquals(9, $array[0]);
        $this->assertEquals(2, $array[1]);
        $this->assertEquals(3, $array[2]);
        $this->assertCount(3, $array);

        // Copiando para outra coleção
        $numbers = new Collection();
        $collection->copyTo($numbers);
        $this->assertCount(3 , $numbers);
    }

    /**
     * @expectedException  \Minerva\Collections\Basis\Exceptions\ReadOnlyStorageException
     */
    public function testReadOnlyOffsetUnset()
    {
        $collection = new Collection();
        $collection->add('Lucas');
        $collection->lock();

        $collection->offsetUnset(0);
    }

    public function testToArray()
    {
        $collection = new Collection();
        $array = $collection->toArray();

        $this->assertFalse(is_array($collection));
        $this->assertTrue(is_array($array));
    }
}