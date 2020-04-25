<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 14:41
 */

namespace Tests\Feature\Addresses;


use Tests\TestCase;

class AddressFeatureTest extends TestCase
{
    /** @test */
    public function it_can_create_address()
    {
        $params = [
            'alias' => $this->faker->unique()->word,
            'address_1' => $this->faker->unique()->word,
            'address_2' => null,
            'zip' => 1101,
            'country_id' => $this->country->id,
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'status' => 1
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('addresses.store', $params))
            ->assertStatus(302)
            ->assertRedirect(route('addresses.index'))
            ->assertSessionHas('message');
    }
}
