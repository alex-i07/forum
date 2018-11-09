<?php

use App\Thread;
use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    public $threads;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->threads = factory(Thread::class, 50)->create();

        $this->threads = $this->users->each(function ($user) {
            factory(App\User::class, 1)->create([
                'user_id' => $user->id
            ]);
        });
    }
}
