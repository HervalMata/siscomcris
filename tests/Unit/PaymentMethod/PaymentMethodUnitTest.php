<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 17:56
 */

namespace Tests\Unit\PaymentMethod;


use App\Shop\PaymentMethods\Exceptions\PaymentMethodInvalidArgumentException;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodNotFoundException;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class PaymentMethodUnitTest extends TestCase
{
    /** @test */
    public function it_errors_updating_a_payment_method()
    {
        $this->expectException(PaymentMethodInvalidArgumentException::class);

        $paymentMethodRepository = new PaymentMethodRepository($this->paymentMethod);
        $paymentMethodRepository->updatePaymentMethod(['name' => null]);
    }

    /** @test */
    public function it_can_lists_all_the_payment_methods()
    {
        $create = [
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->word),
            'description' => $this->faker->paragraph
        ];

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $payment->createPaymentMethod($create);

        $lists = $payment->listPaymentMethods();

        foreach ($lists as $list) {
            $this->assertDatabaseHas('payments_methods', ['name' => $list->name]);
            $this->assertDatabaseHas('payments_methods', ['description' => $list->description]);
        }

    }

    /** @test */
    public function it_errors_when_the_payment_method_is_not_found()
    {
        $this->expectException(PaymentMethodNotFoundException::class);

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $payment->findPaymentMethodById(99999);
    }

    /** @test */
    public function it_can_get_the_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->word),
            'description' => $this->faker->paragraph
        ];

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $method = $payment->createPaymentMethod($create);

        $payment->findPaymentMethodById($create);

        $this->assertEquals($create['name'], $method->name);
        $this->assertDatabaseHas($create['description'], $method->description);
    }

    /** @test */
    public function it_can_update_the_payment_method()
    {
        $payment = new PaymentMethodRepository($this->paymentMethod);

        $update = [
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->word),
            'description' => $this->faker->paragraph
        ];


        $updated = $payment->updatePaymentMethod($update);

        $this->assertEquals($update['name'], $updated->name);
        $this->assertDatabaseHas($update['description'], $updated->description);
    }

    /** @test */
    public function it_errors_creating_the_payment_method()
    {
        $this->expectException(\ErrorException::class);

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $payment->createPaymentMethod([]);
    }

    /** @test */
    public function it_can_create_the_payment_method()
    {
        $name = $this->faker->name;
        $create = [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph
        ];

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $method = $payment->createPaymentMethod($create);

        $this->assertEquals($create['name'], $method->name);
        $this->assertEquals($create['description'], $method->description);

    }
}
