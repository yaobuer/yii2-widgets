<?php
namespace sunnnnn\widgets\slider;

use yii\web\AssetBundle;

class SliderAsset extends AssetBundle{

    public $sourcePath = __DIR__;
    
    public $css = [
        'css/bootstrap-slider.min.css'
    ];
    
    public $js = [
        'js/bootstrap-slider.min.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
