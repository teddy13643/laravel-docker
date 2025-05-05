<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Phpml\Classification\KNearestNeighbors;

class testKNN extends Command
{
    protected $signature = 'KNN';

    public function handle()
    {
        $classifier = new KNearestNeighbors;
        $samples = [[1, 2], [3, 4], [5, 6]];
        $labels = ['a', 'b', 'a'];
        $classifier->train($samples, $labels);

        echo $classifier->predict([4, 5]); // 可能返回 'b'
    }
}
