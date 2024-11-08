<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // php artisan db:seed --class=EventSeeder
        Event::create([
            'name' => 'Web Development Workshop',
            'description' => 'Learn the basics of web development with HTML, CSS, and JavaScript.',
            'event_date' => Carbon::now()->addDays(7),
        ]);

        Event::create([
            'name' => 'Data Science Conference',
            'description' => 'Explore the latest trends in data science and machine learning.',
            'event_date' => Carbon::now()->addDays(14),
        ]);

        Event::create([
            'name' => 'Digital Marketing Seminar',
            'description' => 'Master the art of digital marketing and social media strategies.',
            'event_date' => Carbon::now()->addDays(21),
        ]);
    }
}
