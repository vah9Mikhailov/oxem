<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Float_;
use Ramsey\Uuid\Uuid;
use function Illuminate\Events\queueable;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'created_at' => now(),
            'updated_at' => now(),
            'price' => $this->faker->numberBetween(10,1000),
            'quantity' => $this->faker->numberBetween(0,15),
            'external_id' => Uuid::uuid4()->toString(),
        ];
    }
}
