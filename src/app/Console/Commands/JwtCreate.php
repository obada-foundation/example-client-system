<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ClientHelper\Token;
use App\Models\User;
use Faker\Generator as Faker;

class JwtCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:create {userId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected Token $token;

    protected Faker $faker;

    public function __construct(Token $token, Faker $faker) {
        parent::__construct();

        $this->token = $token;
        $this->faker = $faker;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $user = $userId
            ? User::find($userId)
            : User::create([
                'name'     => $this->faker->name,
                'email'    => $this->faker->email,
                'password' => '12345678'
            ]);

        $this->info($this->token->create($user));
    }
}
