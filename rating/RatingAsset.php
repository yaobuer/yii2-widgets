<?php
namespace sunnnnn\widgets\rating;

use yii\web\AssetBundle;

class RatingAsset extends AssetBundle{

    public $sourcePath = __DIR__;
    
    public $css = [
        'css/star-rating.min.css'
    ];
    
    public $js = [
        'js/star-rating.min.js',
        'js/locales/zh.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
