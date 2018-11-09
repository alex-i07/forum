<?php

use App\Reply;
use Illuminate\Database\Seeder;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Reply::class, 50)->create();

        $this->threads->each(function ($thread) {
            factory(App\Reply::class, 10)->create(['thread_id' => $thread->id]);
        });
    }
}
