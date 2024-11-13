<?php

namespace App\Console\Commands;
use App\Services\FixtureGenerator;
use Illuminate\Console\Command;
use App\Models\Game;

class GenerateFixtures extends Command
{
    protected $signature = 'generate:fixtures';

    protected $description = 'Takımlar arasında fikstür oluşturur';

    public function handle()
    {
            // Önce mevcut maçları sil (eğer varsa)
            Game::truncate();

            // Fikstürü oluştur
            $generator = new FixtureGenerator();
            $generator->generate();
    
            $this->info('Fikstür başarıyla oluşturuldu.');
    }
}
