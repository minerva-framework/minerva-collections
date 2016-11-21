<?php

namespace Tests\Collections;

use Minerva\Collections\Collection;
use Zend\EventManager\Event;

/**
 * DictionaryTest
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Tests\Collections
 */
class TriggerTest extends \PHPUnit_Framework_TestCase
{
    public function testClear()
    {
        $beforeClearTriggered = false;
        $afterClearTriggered = false;

        $collection = new Collection();
        $collection->add('Lucas');

        $collection->getEventManager()->attach('beforeClear', function(Event $e) use(&$beforeClearTriggered){
            $beforeClearTriggered = true;
            $this->assertTrue($e->getTarget() instanceof Collection);
            $this->assertCount(1, $e->getTarget());
        });

        $collection->getEventManager()->attach('afterClear', function(Event $e) use(&$afterClearTriggered){
            $afterClearTriggered = true;
            $this->assertTrue($e->getTarget() instanceof Collection);
            $this->assertCount(0, $e->getTarget());
        });

        $collection->clear();

        $this->assertTrue($beforeClearTriggered);
        $this->assertTrue($afterClearTriggered);
    }
}