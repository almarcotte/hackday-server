<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all = json_decode(file_get_contents(__DIR__ . '/emission.json'), true);

        $to_insert = [];

        foreach ($all as $playerID => $entry) {
            $category = $entry['category'];
            $position = $entry['position'];
            $yearID = $entry['yearID'];
            $qualifiers = [];

            foreach ($entry['qualifiers'] as $qualif) {
                foreach ($qualif as $qualifier => $value) {
                    $qualifiers[$qualifier] = $value;
                }
            }

            $to_insert[] = [
                'playerID' => $playerID,
                'category' => $category,
                'position' => $position,
                'yearID' => $yearID,
                'qualifiers' => json_encode($qualifiers)
            ];
        }

        app('db')->table('participation_awards')->insert($to_insert);
    }
}
