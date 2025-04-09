<?php
  //../../../vendor/bin/phpunit src/Tests/CorporationTest.php

namespace Mudtec\Ezimeeting\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Database\Factories\Corporation\CorporationFactory;
use Mudtec\Ezimeeting\Database\Factories\Corporation\CorporationFailFactory;

//use Tests\TestCase;

class CorporationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_should_return_empty_list_when_no_corporations_exist()
    {
        // Arrange
        $corporations = Corporation::all();
    
        // Act
        $result = $corporations->toArray();
    
        // Assert
        $this->assertEmpty($result);
    } //public function test_should_return_empty_list_when_no_corporations_exist()

    public function test_should_validate_and_sanitize_input_data_for_security()
    {
        // Arrange
        $inputData = [
            'name' => '<script>alert("XSS Attack")</script>',
            'description' => 'This is a test corporation',
            'text' => 'Some text',
            'website' => 'http://www.example.com',
            'logo' => 'logo.png',
        ];

        // Act
        $sanitizedData = CorporationFactory::new()->create($inputData)->toArray();

        // Assert
        $this->assertEquals('alert("XSS Attack")', $sanitizedData['name']);
        $this->assertEquals('This is a test corporation', $sanitizedData['description']);
        $this->assertEquals('Some text', $sanitizedData['text']);
        $this->assertEquals('http://www.example.com', $sanitizedData['website']);
        $this->assertEquals('logo.png', $sanitizedData['logo']);
    } //public function test_should_validate_and_sanitize_input_data_for_security()

    public function test_create_corporation()
    {
        // Use the CorporationFactory to create a new corporation
        $corporation = CorporationFactory::new()->create();

        // Assert that the corporation was created successfully
        $this->assertDatabaseHas('corporations', ['id' => $corporation->id]);
    } //public function test_create_corporation()

    public function test_should_return_list_of_corporations_when_multiple_exist()
    {
       
        // Arrange
        $corporation = CorporationFactory::new()->create(['name' => 'Corporation 1']);
        $corporation = CorporationFactory::new()->create(['name' => 'Corporation 2']);

        // Act
        $corporations = Corporation::all();
    
        // Assert
        $this->assertCount(2, $corporations);
        $this->assertEquals('Corporation 1', $corporations[0]->name);
        $this->assertEquals('Corporation 2', $corporations[1]->name);
    } //public function test_should_return_list_of_corporations_when_multiple_exist()


    public function test_should_return_specific_corporation_when_given_its_id()
    {
        // Arrange
        $expectedCorporation = CorporationFactory::new()->create(['name' => 'Test Corporation']);
    
        // Act
        $result = Corporation::find($expectedCorporation->id);
    
        // Assert
        $this->assertEquals($expectedCorporation->id, $result->id);
        $this->assertEquals('Test Corporation', $result->name);
    } //public function test_should_return_specific_corporation_when_given_its_id()
   
    public function test_should_update_the_details_of_an_existing_corporation()
    {
        // Arrange
        $existingCorporation = CorporationFactory::new()->create([
            'name' => 'Old Corporation',
            'description' => 'Old Description',
            'text' => 'Old Text',
            'website' => 'http://www.old.com',
            'logo' => 'old_logo.png',
        ]);

        $updatedData = [
            'name' => 'New Corporation',
            'description' => 'New Description',
            'text' => 'New Text',
            'website' => 'http://www.new.com',
            'logo' => 'new_logo.png',
        ];

        // Act
        $existingCorporation->update($updatedData);

        // Assert
        $this->assertEquals('New Corporation', $existingCorporation->name);
        $this->assertEquals('New Description', $existingCorporation->description);
        $this->assertEquals('New Text', $existingCorporation->text);
        $this->assertEquals('http://www.new.com', $existingCorporation->website);
        $this->assertEquals('new_logo.png', $existingCorporation->logo);
    } //public function test_should_update_the_details_of_an_existing_corporation()/

    public function test_should_delete_a_corporation_when_given_its_id()
    {
        // Arrange
        $existingCorporation = CorporationFactory::new()->create();
    
        // Act
        $existingCorporation->delete();
    
        // Assert
        $this->assertDatabaseMissing('corporations', ['id' => $existingCorporation->id]);
    } //public function test_should_delete_a_corporation_when_given_its_id()
    
    public function test_should_return_error_when_creating_corporation_with_missing_required_fields()
    {
        // Arrange
        $inputData = [
            'description' => 'This is a test corporation',
            'text' => 'Some text',
            'website' => 'http://www.example.com',
            'logo' => 'logo.png',
            'updated_at' => '2024-11-15 21:00:28',
            'created_at' => '2024-11-15 21:00:28'
        ];

        $exceptionThrown = null;

        // Act
        try {
            CorporationFailFactory::new()->create($inputData);
        } catch (\Illuminate\Database\QueryException $e) {
            $exceptionThrown = $e->getMessage();
        }

        // Assert
        //$this->assertEquals('SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: corporations.name (Connection: sqlite, SQL: insert into "corporations" ("description", "text", "website", "logo", "updated_at", "created_at") values (This is a test corporation, Some text, http://www.example.com, logo.png, 2024-11-15 21:00:28, 2024-11-15 21:00:28))', $exceptionThrown);

        $this->assertStringContainsString('null value in column "name"', $exceptionThrown);
    } //public function test_should_return_error_when_creating_corporation_with_missing_required_fields()
        

} //class CorporationTest extends TestCase