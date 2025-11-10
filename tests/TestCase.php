<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Run migrations in test database
        $this->artisan('migrate:fresh');
    }

    /**
     * Create authenticated user with specific role
     */
    protected function actingAsAdmin()
    {
        $user = \App\Models\User::factory()->admin()->create();
        return $this->actingAs($user);
    }

    protected function actingAsLembaga()
    {
        $user = \App\Models\User::factory()->lembaga()->create();
        return $this->actingAs($user);
    }

    protected function actingAsSkpd()
    {
        $user = \App\Models\User::factory()->skpd()->create();
        return $this->actingAs($user);
    }

    /**
     * Assert that model has specific fillable attributes
     */
    protected function assertModelHasFillable($model, array $expectedFillable)
    {
        $actualFillable = (new $model)->getFillable();
        
        foreach ($expectedFillable as $field) {
            $this->assertContains(
                $field, 
                $actualFillable, 
                "Field '{$field}' is not fillable in " . class_basename($model)
            );
        }
    }

    /**
     * Assert that model has specific relationships
     */
    protected function assertModelHasRelationship($model, string $relationshipName, string $expectedClass = null)
    {
        $this->assertTrue(
            method_exists($model, $relationshipName),
            "Relationship '{$relationshipName}' does not exist in " . get_class($model)
        );

        if ($expectedClass) {
            $relationship = $model->{$relationshipName}();
            $this->assertInstanceOf(
                $expectedClass,
                $relationship,
                "Relationship '{$relationshipName}' is not of expected type '{$expectedClass}'"
            );
        }
    }

    /**
     * Create test file for upload testing
     */
    protected function createTestFile(string $filename = 'test.pdf', string $mimeType = 'application/pdf')
    {
        return \Illuminate\Http\Testing\File::fake()->create($filename, 100, $mimeType);
    }

    /**
     * Assert validation errors for specific fields
     */
    protected function assertValidationErrors(array $fields, $response = null)
    {
        if ($response) {
            $response->assertSessionHasErrors($fields);
        }

        foreach ($fields as $field) {
            $this->assertTrue(
                session()->has("errors.{$field}"),
                "Validation error for field '{$field}' not found"
            );
        }
    }
}
