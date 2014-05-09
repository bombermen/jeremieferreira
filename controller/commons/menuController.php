<?php

class MenuGenerator {

    const TOP_MENU = 1;
    const LATERAL_MENU = 2;
    static $_categories;

    /**
     * @param type $menu
     */
    static function generateMenu($menu) {
        //Result
        $result = '<ul>';

        $classNameToAppend = 'lateral_menu_button';
        
        if(is_null(self::$_categories))
            self::$_categories = DAOFactory::getCategoryDAO()->selectAllOrderBy('level, sort');
        
        if ($menu == self::TOP_MENU) {
            $result .= '<li><a id="main_menu_button" class="menu_button">JF</a></li>';
            $classNameToAppend = 'large_menu_button';
        } else {
            $result .= '<li id="lateral_title">Navigation</li>';
        }

        foreach (self::$_categories as $category) {
            if ($category->getLevel() == 0)
                $result .= '<li><a class="'. $classNameToAppend .' menu_button" href="' . Utils::categoryToUrl($category) . '">' . $category->getName() . '</a></li>';
        }

        return $result . '</ul>';
    }
}