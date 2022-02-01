<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_suppliers_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;

        SupplierAddress::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/suppliers');

        $response->assertStatus(200);

        $suppliers = $response->original['data'];

        $this->assertCount($expectedCount, $suppliers);
    }

    public function test_a_supplier_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('suppliers', 0);

        $addressExpectedAttributes = [
            'zip_code' => '3100',
            'street' => 'Calle de prueba',
            'number' => 1234
        ];

        $supplierExpectedAttributes = [
            'CUIT' => '2023456798',
            'company_name' => 'Razón social de prueba'
        ];

        $parameters = array_merge($addressExpectedAttributes, $supplierExpectedAttributes);

        $response = $this->postJson('api/suppliers', $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseCount('supplier_addresses', 1);
        $this->assertDatabaseHas('supplier_addresses', $addressExpectedAttributes);

        $this->assertDatabaseCount('suppliers', 1);
        $this->assertDatabaseHas('suppliers', $supplierExpectedAttributes);
    }

    public function test_a_supplier_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $address = SupplierAddress::create([
            'zip_code' => '3100',
            'street' => 'Calle de prueba',
            'number' => 1234
        ]);

        $expectedSupplier = Supplier::create([
            'supplier_address_id' => $address->id,
            'CUIT' => '2023456798',
            'company_name' => 'Razón social de prueba'
        ]);

        $response = $this->getJson('api/suppliers/' . $expectedSupplier->id);

        $response->assertStatus(200);

        $supplier = $response->original['data'];

        $this->assertEquals($expectedSupplier->getAttributes(), $supplier->getAttributes());
    }

    public function test_a_supplier_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $address = SupplierAddress::create([
            'zip_code' => '3100',
            'street' => 'Calle de prueba',
            'number' => 1234
        ]);

        $supplier = Supplier::create([
            'supplier_address_id' => $address->id,
            'CUIT' => '2023456798',
            'company_name' => 'Razón social de prueba'
        ]);

        $response = $this->putJson('api/suppliers/' . $supplier->id, [
            'company_name' => 'Razón social de prueba actualizado!',
            'street' => 'Cambio de calle'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'company_name' => 'Razón social de prueba actualizado!'
        ]);

        $this->assertDatabaseHas('supplier_addresses', [
            'id' => $address->id,
            'street' => 'Cambio de calle'
        ]);
    }

    public function test_a_supplier_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $address = SupplierAddress::create([
            'zip_code' => '3100',
            'street' => 'Calle de prueba',
            'number' => 1234
        ]);

        $supplier = Supplier::create([
            'supplier_address_id' => $address->id,
            'CUIT' => '2023456798',
            'company_name' => 'Razón social de prueba'
        ]);

        $response = $this->deleteJson('api/suppliers/' . $supplier->id);

        $response->assertStatus(200);

        $this->assertDeleted($supplier);
    }
}