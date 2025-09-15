<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Transakcija;

class TransakcijaTest extends TestCase
{
    /** @test */
    public function testTransakcijaSviPodaci()
    {
        $transakcija = new Transakcija([
            'user_id' => 1,
            'datum' => '2025-09-15',
        ]);

        $this->assertEquals(1, $transakcija->user_id);
        $this->assertEquals('2025-09-15', $transakcija->datum);
    }
}

