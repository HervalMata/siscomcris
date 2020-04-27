<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 14:36
 */

namespace Tests\Unit\Courriers;


use App\Shop\Courriers\Courrier;
use App\Shop\Courriers\Exceptions\CourrierInvalidArgumentException;
use App\Shop\Courriers\Exceptions\CourrierNotFoundException;
use App\Shop\Courriers\Repositories\CourrierRepository;
use Tests\TestCase;

class CourrierUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_courriers()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courrierRepository = new CourrierRepository(new Courrier);
        $courrierRepository->createCourrier($data);

        $lists = $courrierRepository->listCourriers();

        foreach ($lists as $list) {
            $this->assertDatabaseHas('courriers', ['name' => $list->name]);
            $this->assertDatabaseHas('courriers', ['description' => $list->description]);
            $this->assertDatabaseHas('courriers', ['url' => $list->url]);
            $this->assertDatabaseHas('courriers', ['is_free' => $list->is_free]);
            $this->assertDatabaseHas('courriers', ['status' => $list->status]);
        }
    }

    /** @test */
    public function it_errors_when_the_courrier_is_not_found()
    {
        $this->expectException(CourrierNotFoundException::class);
        $this->expectExceptionMessage('Moeda não encontrada.');

        $courrierRepository = new CourrierRepository(new Courrier);
        $courrierRepository->findCourrierById(99999);
    }

    /** @test */
    public function it_can_get_the_courriers()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courrierRepository = new CourrierRepository(new Courrier);
        $created = $courrierRepository->createCourrier($data);

        $found = $courrierRepository->findCourrierById($created->id);

        $this->assertDatabaseHas($data['name'], ['name' => $found->name]);
        $this->assertDatabaseHas($data['description'], ['description' => $found->description]);
        $this->assertDatabaseHas($data['url'], ['url' => $found->url]);
        $this->assertDatabaseHas($data['is_free'], ['is_free' => $found->is_free]);
        $this->assertDatabaseHas($data['status'], ['status' => $found->status]);
    }

    /** @test */
    public function it_errors_updating_the_courrier()
    {
        $this->expectException(CourrierNotFoundException::class);

        $courrierRepository = new CourrierRepository(new Courrier);
        $courrierRepository->updateCourrier(['name' => null]);
    }

    /** @test */
    public function it_can_update_the_courriers()
    {
        $courrierRepository = new CourrierRepository($this->courrier);

        $update = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];


        $upated = $courrierRepository->updateCourrier($update);

        $this->assertDatabaseHas($update['name'], ['name' => $upated->name]);
        $this->assertDatabaseHas($update['description'], ['description' => $upated->description]);
        $this->assertDatabaseHas($update['url'], ['url' => $upated->url]);
        $this->assertDatabaseHas($update['is_free'], ['is_free' => $upated->is_free]);
        $this->assertDatabaseHas($update['status'], ['status' => $upated->status]);
    }

    /** @test */
    public function it_errors_creating_the_courrier()
    {
        $this->expectException(CourrierInvalidArgumentException::class);

        $courrierRepository = new CourrierRepository(new Courrier);
        $courrierRepository->createCourrier([]);
    }

    /** @test */
    public function it_can_create_the_courriers()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courrierRepository = new CourrierRepository($this->courrier);
        $created = $courrierRepository->updateCourrier($data);

        $this->assertDatabaseHas($data['name'], ['name' => $created->name]);
        $this->assertDatabaseHas($data['description'], ['description' => $created->description]);
        $this->assertDatabaseHas($data['url'], ['url' => $created->url]);
        $this->assertDatabaseHas($data['is_free'], ['is_free' => $created->is_free]);
        $this->assertDatabaseHas($data['status'], ['status' => $created->status]);
    }
}
