<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Product;

class ProductTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function login(Browser $browser)
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $browser->visit('/login')
            ->type('email', $user->email)
            ->type('password', $password)
            ->press('Login')
            ->assertPathIs('/products'); // Adjust path if necessary
    }

    protected function logout(Browser $browser)
    {
        $browser->visit('/logout')
            ->assertPathIs('/login'); // Adjust path if necessary
    }

    /** @test */
    public function create_product()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/products/create')
                ->type('name', 'Test Product')
                ->type('price', '99.99')
                ->press('Save')
                ->assertSee('Product created successfully');

            $this->assertDatabaseHas('products', [
                'name' => 'Test Product',
                'price' => '99.99',
            ]);

            $this->logout($browser);
        });
    }

    /** @test */
    public function read_products()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $this->login($browser);

            $browser->visit('/products')
                ->assertSee($product->name);

            $browser->visit('/products/' . $product->id)
                ->assertSee($product->name)
                ->assertSee($product->price);

            $this->logout($browser);
        });
    }

    /** @test */
    public function update_product()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $this->login($browser);

            $browser->visit('/products/' . $product->id . '/edit')
                ->type('name', 'Updated Product')
                ->type('price', '79.99')
                ->press('Update')
                ->assertSee('Product updated successfully');

            $this->assertDatabaseHas('products', [
                'id' => $product->id,
                'name' => 'Updated Product',
                'price' => '79.99',
            ]);

            $this->logout($browser);
        });
    }

    /** @test */
    public function delete_product()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $this->login($browser);

            $browser->visit('/products')
                ->press('Delete')
                ->assertSee('Product deleted successfully');

            $this->assertDatabaseMissing('products', [
                'id' => $product->id,
            ]);

            $this->logout($browser);
        });
    }
}