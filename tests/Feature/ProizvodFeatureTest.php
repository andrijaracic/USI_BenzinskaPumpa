<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Proizvod;
use Database\Seeders\RolaSeeder;

class ProizvodFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seeduj role pre nego što kreiramo korisnike
        $this->seed(RolaSeeder::class);
    }

    /** @test */
    public function admin_moze_dodati_proizvod()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]);

        $proizvod = [
            'naziv' => 'Benzin BMB 95',
            'cena' => 190,
            'na_akciji' => true,
            'popust_procenat' => 10,
        ];

        $response = $this->actingAs($user)->post(route('admin.proizvodi.store'), $proizvod);

        $response->assertRedirect(route('admin.proizvodi.index'));
        $this->assertDatabaseHas('proizvod', [
            'naziv' => 'Benzin BMB 95',
            'cena' => 190,
        ]);
    }

    /** @test */
    public function ne_admin_ne_moze_dodati_proizvod()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 2]);

        $proizvod = [
            'naziv' => 'Benzin BMB 95',
            'cena' => 190,
        ];

        $response = $this->actingAs($user)->post(route('admin.proizvodi.store'), $proizvod);

        $response->assertStatus(302);
    }

    /** @test */
    public function greska_kada_fali_naziv()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]);

        $proizvod = [
            'cena' => 190,
            'na_akciji' => false,
        ];

        $response = $this->actingAs($user)->post(route('admin.proizvodi.store'), $proizvod);

        $response->assertSessionHasErrors('naziv');
    }

    /** @test */
    public function greska_kada_fali_cena()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]);

        $proizvod = [
            'naziv' => 'Test Proizvod',
            'na_akciji' => false,
        ];

        $response = $this->actingAs($user)->post(route('admin.proizvodi.store'), $proizvod);

        $response->assertSessionHasErrors('cena');
    }

    /** @test */
    /** @test */
    /** @test */
    public function admin_moze_izmeniti_proizvod()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]); // admin

        // Kreiramo proizvod koji ćemo menjati
        $proizvod = Proizvod::factory()->create([
            'naziv' => 'Stari naziv',
            'cena' => 150,
            'na_akciji' => false,
            'popust_procenat' => 0,
        ]);

        $update = [
            'naziv' => 'Izmenjeni naziv',
            'cena' => 250,
            'na_akciji' => true,
            'popust_procenat' => 15,
        ];

        $response = $this->actingAs($user)
                        ->put(route('admin.proizvodi.update', $proizvod), $update);

        // Proveravamo da li je redirect ka listi proizvoda
        $response->assertRedirect(route('admin.proizvodi.index'));

        // Proveravamo da li su vrednosti u bazi ažurirane
        $this->assertDatabaseHas('proizvod', [
            'id' => $proizvod->id,
            'naziv' => 'Izmenjeni naziv',
            'cena' => 250,
        ]);
    }


}
