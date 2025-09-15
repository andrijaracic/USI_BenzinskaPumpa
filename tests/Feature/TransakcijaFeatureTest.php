<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Proizvod;
use App\Models\Transakcija;
use Database\Seeders\RolaSeeder;

class TransakcijaFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolaSeeder::class);
    }

    /** @test */
    public function admin_moze_dodati_transakciju()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]);

        $proizvod1 = Proizvod::factory()->create();
        $proizvod2 = Proizvod::factory()->create();

        $transakcija = [
            'user_id' => $user->id,
            'datum' => now()->toDateString(),
            'stavke' => [
                ['proizvod_id' => $proizvod1->id, 'kolicina' => 2],
                ['proizvod_id' => $proizvod2->id, 'kolicina' => 3],
            ],
        ];

        $response = $this->actingAs($user)->post(route('admin.transakcije.store'), $transakcija);

        $response->assertRedirect(route('admin.transakcije.index'));

        $this->assertDatabaseHas('transakcija', [
            'user_id' => $user->id,
            'datum' => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('stavka_transakcija', [
            'proizvod_id' => $proizvod1->id,
            'kolicina' => 2,
        ]);

        $this->assertDatabaseHas('stavka_transakcija', [
            'proizvod_id' => $proizvod2->id,
            'kolicina' => 3,
        ]);
    }

    /** @test */
    public function ne_admin_ne_moze_dodati_transakciju()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 2]); 
        $proizvod = Proizvod::factory()->create();

        $transakcija = [
            'user_id' => $user->id,
            'datum' => now()->toDateString(),
            'stavke' => [
                ['proizvod_id' => $proizvod->id, 'kolicina' => 1],
            ],
        ];

        $response = $this->actingAs($user)->post(route('admin.transakcije.store'), $transakcija);

        
        $response->assertRedirect();
        $response->assertStatus(302);
    }

    /** @test */
    public function greska_kada_fali_user_id()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]);
        $proizvod = Proizvod::factory()->create();

        $transakcija = [
            'datum' => now()->toDateString(),
            'stavke' => [
                ['proizvod_id' => $proizvod->id, 'kolicina' => 1],
            ],
        ];

        $response = $this->actingAs($user)->post(route('admin.transakcije.store'), $transakcija);

        $response->assertSessionHasErrors('user_id');
    }

    

    /** @test */
    public function admin_moze_izmeniti_transakciju()
    {
        /** @var User $user */
        $user = User::factory()->create(['rola_id' => 1]);

        $transakcija = Transakcija::factory()->create();
        $proizvod = Proizvod::factory()->create();

        $update = [
            'user_id' => $user->id,
            'datum' => now()->addDay()->toDateString(),
            'stavka_transakcija' => [
                ['proizvod_id' => $proizvod->id, 'kolicina' => 5],
            ],
        ];

        $response = $this->actingAs($user)->put(route('admin.transakcije.update', $transakcija), $update);

        $response->assertRedirect(route('admin.transakcije.index'));

        $this->assertDatabaseHas('transakcija', [
            'id' => $transakcija->id,
            'user_id' => $user->id,
            'datum' => now()->addDay()->toDateString(),
        ]);

        $this->assertDatabaseHas('stavka_transakcija', [
            'proizvod_id' => $proizvod->id,
            'kolicina' => 5,
        ]);
    }
}
