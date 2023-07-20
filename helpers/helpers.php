<?php
namespace app\helpers;

use yii\helpers\Html;

class Helpers
{
    public static function show_stars($value, $size='small', $count = 5, $active = false)
    {
        $stars = '';

        for ($i = 1; $i <= $count; $i++) {
            $class_name = $i <= $value ? 'fill-star' : '';
            $stars .= Html::tag('span', '&nbsp', ['class' => $class_name]);
        }

        $class_name = 'stars-rating ' . $size;

        if ($active) {
            $class_name .= ' active-stars';
        }

        $result = Html::tag('div', $stars, ['class' => $class_name]);

        return $result;
    }

    public static function transliterate($string) {
        $roman = array("Sch","sch",'Yo','Zh','Kh','Ts','Ch','Sh','Yu','ya','yo','zh','kh','ts','ch','sh','yu','ya','A','B','V','G','D','E','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','','Y','','E','a','b','v','g','d','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','','y','','e');
        $cyrillic = array("Щ","щ",'Ё','Ж','Х','Ц','Ч','Ш','Ю','я','ё','ж','х','ц','ч','ш','ю','я','А','Б','В','Г','Д','Е','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Ь','Ы','Ъ','Э','а','б','в','г','д','е','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','ь','ы','ъ','э');
        return str_replace($roman, $cyrillic, $string);
    }

    public static function getMyTasksMenu($is_performer)
    {
        $items = [];

        if ($is_performer) {
            $items[] = ['label' => 'Новые', 'url' => ['tasks/my', 'status' => 'new']];
            $items[] = ['label' => 'В процессе', 'url' => ['tasks/my', 'status' => 'in_progress']];
            $items[] = ['label' => 'Закрытые', 'url' => ['tasks/my', 'status' => 'closed']];
        } else {
            $items[] = ['label' => 'В процессе', 'url' => ['tasks/my', 'status' => 'in_progress']];
            $items[] = ['label' => 'Просрочено', 'url' => ['tasks/my', 'status' => 'expired']];
            $items[] = ['label' => 'Закрытые', 'url' => ['tasks/my', 'status' => 'closed']];
        }

        return $items;
    }
}