<?php
namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;

class PostsTableSeeder extends Seeder
{
    use HasFactory;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //リレーションのファクトリ
       //Has Manyリレーション
       //post(1):comment(3)
        Post::factory(5)
          ->has(Comment::factory()->count(2))
          ->create();
    }
}