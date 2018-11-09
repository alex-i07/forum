<?php

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $users;

    protected $threads;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->users = factory(User::class, 50)->create();

        $this->threads = collect([]);

        $this->users->each(function ($user){
            $this->threads->push(factory(Thread::class, 1)->create(['user_id' => $user->id]));
        });

        $this->threads->each(function ($thread){

            factory(Reply::class, 5)->create(['thread_id' => $thread[0]->id, 'user_id' => $this->users->pluck('id')->random()]);
        });
    }
}
