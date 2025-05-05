<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Phpml\Classification\DecisionTree;
use Phpml\ModelManager;

class testDecisionTree extends Command
{
    protected $signature = 'DecisionTree';

    public function handle()
    {
        // 訓練數據
        $samples = [
            [22, 30000], // 年齡, 收入
            [35, 70000],
            [28, 50000],
            [40, 80000],
        ];
        $labels = ['入門產品', '高端產品', '經濟型產品', '高端產品'];

        // 訓練模型
        $classifier = new DecisionTree; // 決策樹
        $classifier->train($samples, $labels);

        // 預測
        $result = $classifier->predict([30, 60000]); // 預測年齡30, 收入60000
        echo $result; // 輸出：經濟型產品

        // 保存模型
        $modelManager = new ModelManager;
        $modelManager->saveToFile($classifier, 'decision_tree_model.phpml');

        // 加載模型
        $restoredClassifier = $modelManager->restoreFromFile('decision_tree_model.phpml');
        echo $restoredClassifier->predict([30, 60000]); // 維持相同預測
    }
}
