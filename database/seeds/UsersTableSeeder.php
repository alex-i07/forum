<?php

use App\User;
use App\Reply;
use App\Thread;
use App\Channel;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $users;

    protected $threads;

    protected $channels;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->users = factory(User::class, 50)->create();

//        $this->channels = create(Channel::class, ['10']);  //olumn not found: 1054 Unknown column '0' in 'field list' (SQL: insert into `channels` (`name`, `slug`, `0`, `updated_at`, `created_at`) values (ullam, ullam, 1970-01-01 00:00:10, 2018-11-16 15:11:20, 2018-11-16 15:11:20))

        $this->channels = factory(Channel::class, 10)->create();

        $this->threads = collect([]);

        $this->users->each(function ($user){
            $this->threads->push(factory(Thread::class, 1)->create(['user_id' => $user->id, 'channel_id' => $this->channels->pluck('id')->random()]));
        });

        $this->threads->each(function ($thread){

            factory(Reply::class, 5)->create(['thread_id' => $thread[0]->id,
                                              'user_id' => $this->users->pluck('id')->random()]);
        });
    }
}
