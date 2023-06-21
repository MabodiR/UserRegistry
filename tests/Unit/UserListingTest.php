<?php

namespace Tests\Unit;

use App\Listing;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserListingTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        // Create dummy users using the Listing model
        $users = factory(Listing::class, 5)->create();

        // Send a GET request to the user-listings.index route
        $response = $this->get('/user-listings');

        // Assert that the response has a successful status code
        $response->assertStatus(200);

    
    }

    public function testStore()
    {
        // Create dummy data for the Listing model
        $listingData = [
            'name' => 'Rofhiwa',
            'surname' => 'Mabodi',
            'email'=> 'rofhiwa.mabodi@gmail.com',
            'position'=> 'Developer'
        ];

        // Send a POST request to the user-listings.store route with the dummy data
        $response = $this->post('/user-listings/store', $listingData);

        // Assert that the response has a successful status code
        $response->assertRedirect();
        
        // Assert that the listing was stored in the database
        $this->assertDatabaseHas('users', $listingData);
    }

    public function testDestroy()
    {
        // Create a dummy listing in the database
        $listing = factory(Listing::class)->create();

        // Send a DELETE request to the user-listings.destroy route with the listing ID
        $response = $this->delete('/user-listings/destroy/'.$listing->id);

        // Assert that the response has a successful status code
        $response->assertJson([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);

        // Assert that the listing was deleted from the database
        $this->assertDatabaseMissing('users', ['id' => $listing->id]);
    }

}