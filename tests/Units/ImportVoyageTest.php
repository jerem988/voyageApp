<?php

namespace Tests\Unit;

include(__DIR__.'/../../voyageController.php');

use PHPUnit\Framework\TestCase;
use Controller\voyageController as Voyage;

class ImportVoyageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testInsertionBadFormatJson()
    {
        $voyage = new Voyage;
        $this->assertFalse($voyage->store(__DIR__.'/../files/badformat.json'));
    }

    public function testInsertionEmptyJson()
    {
        $voyage = new Voyage;
        $this->assertFalse($voyage->store(__DIR__.'/../files/empty.json'));
    }

    public function testInsertionTypeNotSpecifiedJson()
    {
        $voyage = new Voyage;
        $this->assertFalse($voyage->store(__DIR__.'/../files/typenotspecified.json'));
    }

    public function testInsertionSameDepartureJson()
    {
        $voyage = new Voyage;
        $this->assertFalse($voyage->store(__DIR__.'/../files/samedeparture.json'));
    }

    public function testInsertionEmptyEtapeJson()
    {
        $voyage = new Voyage;
        $this->assertFalse($voyage->store(__DIR__.'/../files/emptyetape.json'));
    }

    public function testInsertionValideJson()
    {
        $voyage = new Voyage;
        $this->assertTrue($voyage->store(__DIR__.'/../files/Voyage1.json'));
    }
}