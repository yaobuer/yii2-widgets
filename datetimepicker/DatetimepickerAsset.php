<?php
namespace sunnnnn\widgets\datetimepicker;

use yii\web\AssetBundle;

class DatetimepickerAsset extends AssetBundle{ 
    
    public $sourcePath = __DIR__;
    
    public $css = [
        'css/bootstrap-datetimepicker.min.css'
    ];
    
    public $js = [
        'js/moment/moment.min.js',
        'js/moment/locales.min.js',
        'js/bootstrap-datetimepicker.min.js'
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
