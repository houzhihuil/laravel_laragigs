<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(5)->create();
        $user = User::factory()->create([
        'name' => 'testNom',
        'email' => 'test@gmail.com' 
        ]);
        Listing::factory(5)->create([
            'user_id'=> $user->id
        ]);

       /*    Listing::create([
            'title'=>'Toronto senior developer',
            'tags'=>'laravel, javascript',
            'company'=>'Acme Corp',
            'location'=>'Boston, MA',
            'email'=>'email1@email.com',
            'website'=>'https://acme.com',
            'description'=>'Lorem ipsum dolor ist...'
        ] 
        );

        Listing::create([
            'title'=>'Montreal senior developer',
            'tags'=>'full stack engineer, java ',
            'company'=>'Regent',
            'location'=>'Montreal, QC',
            'email'=>'email2@email.com',
            'website'=>'https://acme.com',
            'description'=>'Lorem ipsum dolor ist...'
        ] 
        );
  
        Listing::create([
            'title'=>'New York senior developer',
            'tags'=>'full stack engineer, java ',
            'company'=>'Regent',
            'location'=>'Montreal, QC',
            'email'=>'email2@email.com',
            'website'=>'https://acme.com',
            'description'=>'Lorem ipsum dolor ist...'
        ] 
        ); */ 

    }
}
