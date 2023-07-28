<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Location;
use App\Models\Dress;

use Faker\Factory as Faker;

class DressSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Faker::create();

        $womanOutfit = [
            // Women's Wedding Dresses
            "Enchanted Elegance A-Line Gown",
            "Fairytale Dreams Ball Gown",
            "Siren's Serenade Mermaid Dress",
            "Timeless Glamour Sheath Dress",
            "Celestial Empire Waist Gown",
            "Romantic Garden Tea-Length Dress",
            "Princess Dreams Wedding Dress",
            "Cherished Allure Fit and Flare",
            "Heavenly Halo Off-the-Shoulder Gown",
            "Starlit Visions V-Neck Dress",
            "Ethereal Halter Wedding Gown",
            "Blissful Sweetheart Dress",
            "Serenading Sleeveless Gown",
            "Captivating Cap Sleeve Dress",
            "Eternal Love Long Sleeve Gown",
            "Whimsical Illusion Neckline Dress",
            "Timeless Treasures Bateau Dress",
            "Charming Scoop Neck Wedding Gown",
            "Heirloom High Neck Bridal Dress",
            "Enchanted Beauty Strapless Gown",
            "Mesmerizing Backless Wedding Gown",
            "Belle of the Ball Corset Dress",
            "Lace Cascade Fairy Tale Gown",
            "Tulle Enchantment Bridal Dress",
            "Chiffon Whispers Wedding Gown",
            "Satin Serenade Bridal Dress",
            "Garden of Dreams Organza Gown",
            "Majestic Mikado Wedding Dress",
            "Whispers of Love Crepe Gown",
            "Beaded Enchantment Wedding Dress",
            "Embroidered Elegance Bridal Gown",
            "Vintage Visions Wedding Dress",
            "Destination Dreams Bridal Gown",
            "Breezy Beach Wedding Dress",
            "Boho Love Story Bridal Gown",
            "Modern Daydream Wedding Dress",
            "Timeless Traditions Bridal Gown",
            "Sweetheart Serenade Bridal Dress",
            "Glamorous Soirée Wedding Gown",
            "Chic Minimalist Bridal Dress",
            "Rustic Reverie Wedding Gown",
        ];

        $menOutfit = [
            "Regal Charm Tailcoat Suit",
            "Classic Elegance Tuxedo",
            "Starry Night Black Tie Suit",
            "Timeless Sophistication Tux",
            "Enchanting Evening Tailcoat",
            "Charming Charcoal Suit",
            "Navy Dream Wedding Attire",
            "Sleek Midnight Tuxedo",
            "Garden Gala Summer Suit",
            "Elegant Grey Morning Coat",
            "Vintage Memories Tuxedo",
            "Majestic Maroon Wedding Suit",
            "Enchanted Forest Green Suit",
            "Burgundy Bliss Formal Attire",
            "Royal Blue Evening Suit",
            "Ivory Whisper Morning Coat",
            "Beachside Bliss Linen Suit",
            "Whimsical Woodland Attire",
            "Modern Gray 3-Piece Suit",
            "Timeless Tweed Wedding Suit",
            "Classic Black Dinner Jacket",
            "Dapper Plaid Wedding Outfit",
            "Sophisticated Slate Gray Suit",
            "Noble Navy Double-Breasted Suit",
            "Elegant Cream Dinner Jacket",
            "Rustic Brown Wedding Attire",
            "Blissful Blue Wedding Suit",
            "Slate Blue Garden Wedding Suit",
            "Bespoke Charcoal Tailcoat",
            "Indigo Allure Tuxedo",
            "Enchanted Emerald Suit",
            "Beige Linen Summer Suit",
            "Chic Gray Peak Lapel Tux",
            "Burgundy Velvet Evening Suit",
            "Glamorous Gold Tuxedo",
            "Timeless Taupe Wedding Attire",
            "Charming Checkered Suit",
            "Rustic Brown Tweed Outfit",
            "Vintage Olive Green Suit",
            "Sapphire Serenade Formal Suit",
            "Ivory Cream Summer Tux",
        ];

        for ($i = 0; $i < 21; $i++) {
            $dressName = $faker->unique()->randomElement($womanOutfit);
            $query = str_replace(" ", "-", $dressName);
            $query = strtolower($query);
            Dress::create([
                'name' => $dressName,
                'price' => $faker->numberBetween(100000, 5000000),
                'image' => "assets/".($i+1).".jpg",
                'location_id' => mt_rand(1, 3),
                'description' => $faker->text($maxNbChars = 1000),
                'gender' => 2,
            ]);
        }

        for ($i = 0; $i < 21; $i++) {
            $dressName = $faker->unique()->randomElement($menOutfit);
            $query = str_replace(" ", "-", $dressName);
            $query = strtolower($query);
            Dress::create([
                'name' => $dressName,
                'price' => $faker->numberBetween(100000, 5000000),
                'image' => "assets/".($i+22).".jpg",
                'location_id' => mt_rand(1, 3),
                'description' => $faker->text($maxNbChars = 500),
                'gender' => 1,
            ]);
        }

    }
}
