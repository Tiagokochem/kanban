<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cria 2 usuários
        $user1 = User::create([
            'name' => 'Tiago',
            'email' => 'tiago@email.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Outro Usuario',
            'email' => 'outro@email.com',
            'password' => bcrypt('password'),
        ]);

        // Para cada usuário cria um board
        foreach ([$user1, $user2] as $user) {
            $board = $user->boards()->create([
                'title' => 'Board de ' . $user->name,
            ]);

            // Cria 3 categorias padrão
            $categories = ['To Do', 'Doing', 'Done'];

            foreach ($categories as $index => $catName) {
                $category = $board->categories()->create([
                    'name' => $catName,
                    'order' => $index,
                ]);

                // Cria 5 tasks em cada categoria
                for ($i = 1; $i <= 5; $i++) {
                    $category->tasks()->create([
                        'title' => "Task $i em $catName",
                        'description' => "Descrição da task $i na categoria $catName",
                        'order' => $i,
                    ]);
                }
            }
        }
    }
}
