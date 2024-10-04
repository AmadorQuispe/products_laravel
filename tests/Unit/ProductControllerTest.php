<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test obtener todos los productos cuando no hay productos.
     */
    public function test_get_all_products_empty()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJson(['message' => 'No hay productos registrados']);
    }

    /**
     * Test crear un producto.
     */
    public function test_create_product()
    {
        $data = [
            'name' => 'Producto de prueba',
            'description' => 'Descripción del producto de prueba',
            'price' => 100.50,
            'stock' => 10
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Producto de prueba',
                'description' => 'Descripción del producto de prueba',
            ]);

        $this->assertDatabaseHas('products', ['name' => 'Producto de prueba']);
    }

    /**
     * Test obtener producto por id existente.
     */
    public function test_get_product_by_id()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $product->id,
                'name' => $product->name,
            ]);
    }

    /**
     * Test obtener producto por id inexistente.
     */
    public function test_get_product_by_id_not_found()
    {
        $response = $this->getJson('/api/products/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Producto con 999 no encontrado.']);
    }



    /**
     * Test obtener todos los productos.
     */
    public function test_get_all_products()
    {
        Product::factory()->count(1)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }

    /**
     * Test crear un producto con datos inválidos.
     */
    public function test_create_product_validation_error()
    {
        $data = [
            'name' => '', // Nombre vacío
            'description' => 'Descripción corta',
            'price' => -10, // Precio negativo
            'stock' => -5   // Stock negativo
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(404)
            ->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Test actualizar un producto.
     */
    public function test_update_product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => 'Nombre actualizado',
            'description' => 'Descripción actualizada',
            'price' => 150.75,
            'stock' => 20
        ];

        $response = $this->putJson('/api/products/' . $product->id, $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Producto actualizado correctamente']);

        $this->assertDatabaseHas('products', ['name' => 'Nombre actualizado']);
    }

    /**
     * Test actualizar un producto no existente.
     */
    public function test_update_product_not_found()
    {
        $data = [
            'name' => 'Nombre actualizado',
            'description' => 'Descripción actualizada',
            'price' => 150.75,
            'stock' => 20
        ];

        $response = $this->putJson('/api/products/999', $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Producto con 999no encontrado.']);
    }

    /**
     * Test eliminar un producto.
     */
    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Producto con id ' . $product->id . ' fué eliminado.']);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /**
     * Test eliminar un producto no existente.
     */
    public function test_delete_product_not_found()
    {
        $response = $this->deleteJson('/api/products/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Producto con id 999 no encontrado']);
    }
}
