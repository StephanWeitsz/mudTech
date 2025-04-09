<?php
  //../../../vendor/bin/phpunit src/Tests/CorporationTest.php

namespace Mudtec\Ezimeeting\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Database\Factories\Corporation\CorporationFactory;
use Mudtec\Ezimeeting\Database\Factories\Department\DepartmentFactory;
use Mudtec\Ezimeeting\Database\Factories\Department\DepatmentFailFactory;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_should_return_empty_list_when_no_departments_exist()
    {
        // Arrange
        $departments = Department::all();
    
        // Act
        $result = $departments->toArray();
    
        // Assert
        $this->assertEmpty($result);
    } //public function test_should_return_empty_list_when_no_departments_exist()

    public function test_should_validate_and_sanitize_input_data_for_security()
    {
        // Arrange
        $corporation = CorporationFactory::new()->create();
     
        $inputData = [
            'name' => '<script>alert("XSS Attack")</script>',
            'description' => 'This is a test corporation',
            'text' => 'Some text',
            'corporation_id' => $corporation->id,
        ];

        // Act
        $sanitizedData = DepartmentFactory::new()
            ->create($inputData)
            ->toArray();

        // Assert
        $this->assertEquals('alert("XSS Attack")', $sanitizedData['name']);
        $this->assertEquals('This is a test corporation', $sanitizedData['description']);
        $this->assertEquals('Some text', $sanitizedData['text']);
        $this->assertEquals($corporation->id, $sanitizedData['corporation_id']);
    } //public function test_should_validate_and_sanitize_input_data_for_security()

    public function test_create_department()
    {
        // Arrange
        $corporation = CorporationFactory::new()->create();   

        $inputData = [
            'corporation_id' => $corporation->id,
        ];
        
        //Act
        $departments = DepartmentFactory::new()->create($inputData);

        // Assert
        $this->assertDatabaseHas('departments', ['id' => $departments->id]);
        $this->assertDatabaseHas('departments', ['corporation_id' => $departments->corporation_id]);
    } //public function test_create_corporation()

    public function test_should_return_list_of_departments_when_multiple_exist()
    {
       
        // Arrange
        $corporation1 = CorporationFactory::new()->create(['name' => 'Corporation 1']);
        $corporation2 = CorporationFactory::new()->create(['name' => 'Corporation 2']);

        $department = DepartmentFactory::new()->create(['name' => 'Department 1','corporation_id' => $corporation1->id]);
        $department = DepartmentFactory::new()->create(['name' => 'Department 2','corporation_id' => $corporation1->id]);
        $department = DepartmentFactory::new()->create(['name' => 'Department 1','corporation_id' => $corporation2->id]);

        // Act
        $departments = Department::all();
    
        // Assert
        $this->assertCount(3, $departments);
        $this->assertEquals('Department 1', $departments[0]->name);
        $this->assertEquals('Department 2', $departments[1]->name);
        $this->assertEquals('Department 1', $departments[2]->name);

        $this->assertEquals($corporation1->id, $departments[0]->corporation_id);
        $this->assertEquals($corporation1->id, $departments[1]->corporation_id);
        $this->assertEquals($corporation2->id, $departments[2]->corporation_id);
    } //public function test_should_return_list_of_departments_when_multiple_exist()

    public function test_should_return_specific_department_when_given_its_id()
    {
        // Arrange
        $corporation = CorporationFactory::new()->create();
        $expectedDepartment = DepartmentFactory::new()->create(['name' => 'Test Department','corporation_id' => $corporation->id]);
    
        // Act
        $result = Department::find($expectedDepartment->id);
    
        // Assert
        $this->assertEquals($expectedDepartment->id, $result->id);
        $this->assertEquals('Test Department', $result->name);
    } //public function test_should_return_specific_department_when_given_its_id()


    public function test_should_update_the_details_of_an_existing_department()
    {
        // Arrange
        $corporation = CorporationFactory::new()->create();

        $existingDepartment = DepartmentFactory::new()->create([
            'name' => 'Old Department',
            'description' => 'Old Description',
            'text' => 'Old Text',
            'corporation_id' => $corporation->id
        ]);

        $updatedData = [
            'name' => 'New Department',
            'description' => 'New Description',
            'text' => 'New Text',
        ];

        // Act
        $existingDepartment->update($updatedData);

        // Assert
        $this->assertEquals('New Department', $existingDepartment->name);
        $this->assertEquals('New Description', $existingDepartment->description);
        $this->assertEquals('New Text', $existingDepartment->text);
        $this->assertEquals($corporation->id, $existingDepartment->corporation_id);
    } //public function test_should_update_the_details_of_an_existing_department()


    public function test_should_delete_a_department_when_given_its_id()
    {
        // Arrange
        $corporation = CorporationFactory::new()->create();
        $existingDepartment = DepartmentFactory::new()->create();
    
        // Act
        $existingDepartment->delete();
    
        // Assert
        $this->assertDatabaseMissing('departments', ['id' => $existingDepartment->id]);
    } //public function test_should_delete_a_department_when_given_its_id()

    public function test_should_return_error_when_creating_corporation_with_missing_required_fields()
    {       
        // Arrange
        $corporation = CorporationFactory::new()->create();

        $inputData = [
            'description' => 'This is a test corporation',
            'text' => 'Some text',
            'website' => 'http://www.example.com',
            'corporation_id' => $corporation->id,
            'updated_at' => '2024-11-15 21:00:28',
            'created_at' => '2024-11-15 21:00:28'
        ];

        $exceptionThrown = null;

        // Act
        try {
            DepartmentFactory::new()
                ->withNoName($inputData)
                ->create($inputData);
        } catch (\Illuminate\Database\QueryException $e) {
            $exceptionThrown = $e->getMessage();
        }

        // Assert
        $this->assertNotEmpty($exceptionThrown);
        
        //$this->assertEquals('SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: corporations.name (Connection: sqlite, SQL: insert into "corporations" ("description", "text", "website", "logo", "updated_at", "created_at") values (This is a test corporation, Some text, http://www.example.com, logo.png, 2024-11-15 21:00:28, 2024-11-15 21:00:28))', $exceptionThrown);
    } //public function test_should_return_error_when_creating_corporation_with_missing_required_fields()


    public function testDepartmentCreationWithMissingCorporationId()
    {
        // Arrange
        
        // Act
        $departmentData = DepartmentFactory::new()->make(['corporation_id' => null])->toArray();
    
        // Assert
        $this->assertDatabaseMissing('departments', $departmentData);
    } //public function testDepartmentCreationWithMissingCorporationId()

    public function testDepartmentCreationWithInvalidCorporationId()
    {
        // Arrange
        $invalidCorporationId = 99999999; // Non-existent corporation id

        // Act
        $departmentData = DepartmentFactory::new()->make(['corporation_id' => $invalidCorporationId])->toArray();
        
        // Assert
        $this->assertDatabaseMissing('departments', $departmentData);
    } //public function testDepartmentCreationWithInvalidCorporationId()
    
    public function testDepartmentRetrievalWithInvalidId()
    {
        // Arrange
        $invalidDepartmentId = 99999999; // Non-existent department id

        // Act
        $result = Department::find($invalidDepartmentId);

        // Assert
        $this->assertNull($result);
    } //public function testDepartmentRetrievalWithInvalidId()

}