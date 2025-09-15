<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Proizvod;

class ProizvodTest extends TestCase
{
    /** @test */
public function testProizvodSviPodaci()
{
    $proizvod = new Proizvod([
        'naziv' => 'Benzin BMB 95',
        'cena' => 190,
        'na_akciji' => true,
        'popust_procenat' => 10,
    ]);

    $this->assertEquals('Benzin BMB 95', $proizvod->naziv);
    $this->assertEquals(190, $proizvod->cena);
    $this->assertTrue($proizvod->na_akciji);
    $this->assertEquals(10, $proizvod->popust_procenat);
}
}
