<?php
  //../../../vendor/bin/phpunit src/Tests/CorporationTest.php

namespace Mudtec\Ezimeeting\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Role;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Database\Factories\Corporation\CorporationFactory;
use Mudtec\Ezimeeting\Database\Factories\Department\DepartmentFactory;
use Mudtec\Ezimeeting\Database\Factories\Department\DepatmentFailFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_should_return_empty_user_list_when_no_users_exist()
    {
        // Arrange
        $users = User::all();
    
        // Act
        $result = $users->toArray();
    
        // Assert
        $this->assertEmpty($result);
    } // public function test_should_return_empty_user_list_when_no_users_exist()

}