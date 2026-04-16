<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $sourceDir = database_path('references/translations');
        $targetDir = base_path('lang');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        foreach (glob($sourceDir . '/*.json') as $file) {
            $code = pathinfo($file, PATHINFO_FILENAME);
            $data = json_decode(file_get_contents($file), true);

            if ($data === null) {
                $this->command->warn("Skipping {$code}.json: invalid JSON");
                continue;
            }

            $target = $targetDir . '/' . $code . '.json';
            file_put_contents(
                $target,
                json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n"
            );

            $this->command->info("Seeded {$code}.json (" . count($data) . " strings)");
        }
    }
}
