<?php
namespace sunnnnn\widgets\colorpicker;

use yii\web\AssetBundle;

class ColorPickerAsset extends AssetBundle{
    
    public $sourcePath = __DIR__;
    
    public $css = [
        'css/bootstrap-colorpicker.min.css'
    ];
    
    public $js = [
        'js/bootstrap-colorpicker.min.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
