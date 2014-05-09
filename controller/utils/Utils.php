<?php

function formatTitle($matches) {
    $level = intval($matches[1]) + 1;
    $title = $matches[2];
    $lowerTitle = Utils::addUnderscores($title);
    return '<h'.$level.' id="'.$lowerTitle.'"';
}

class Utils {

    /** static class */
    function Utils() {
        
    }
    
    public static function display404() {
        require './view/commons/404.html';
    }

    /**
     * @param Category $category
     * @return category URL
     */
    static function categoryToUrl($category) {
        if (is_null($category->getParent())) {
            return SITE_BASE . $category->getName();
        }
        return categoryToUrl($category->getParent()) . '/' . $category->getName();
    }
    
    public static function addUnderscores($title, $toLower = true) {
        $title = trim($title);
        if($toLower)
            $title = strtolower($title);
        $title = preg_replace('/\s/', '_', $title);
        return $title;
    }
    
    public static function removeUnderscores($title) {
        $title = trim($title);
        $title = preg_replace('/_/', ' ', $title);
        return $title;
    }

    public static function parseWiki($wiki) {
        $wiky = new wiky;
        return self::parseTitles( $wiky->parse( $wiki ) );
    }
    
    public static function parseTitles($text) {
        $pattern = '/<h([0-9]+) id=\"([^>]*)\"/';

        $result = preg_replace_callback($pattern, 'formatTitle', $text);
        return $result;
    }

    /**
     * @param string $text
     * @param string $maxLevel
     */
    static function generateTableOfContents($text, $title = TOC_TITLE, $maxLevel = 3) {
        $result = '<div id="toc">';
        $result .= '<div id="toc_title">'.$title.'</div>';
        
        $pattern = '/<h([0-9])+ id=\"([^\"]+)\">([^<]+)/';
        $titles = array();
        
        if(preg_match_all($pattern, $text, $titles)) {
            $lastLevel = 0;
            $hierarchy = array();
            
            for($i = 0; $i < count($titles[0]); ++$i) {
                $currentLevel = intval($titles[1][$i]);
                
                $currentItem = array('begin' => '<li><a href="#'.$titles[2][$i].'">', 'end' => ' '.$titles[3][$i].'</a></li>');

                if($currentLevel > $lastLevel) {
                    $hierarchy[] = 1;
                    $result .= '<ul class="level'.$currentLevel.'">'.$currentItem['begin'] . implode('.', $hierarchy) . $currentItem['end'];
                } else if($currentLevel < $lastLevel) {
                    $gap = $lastLevel - $currentLevel;
                    $hierarchy = array_slice($hierarchy, 0, count($hierarchy) - $gap);
                    $hierarchy[] = array_pop($hierarchy) + 1;
                    while($gap--) {
                        $result .= '</ul>';
                    }
                    $result .= $currentItem['begin'] . implode('.', $hierarchy) . $currentItem['end'];
                } else {
                    $hierarchy[] = array_pop($hierarchy) + 1;
                    $result .= $currentItem['begin'] . implode('.', $hierarchy) . $currentItem['end'];
                    
                }
                
                $lastLevel = $currentLevel;
            }
        }
        
        $result .= '</div>';

        return $result;
    }

    public static function displayCodeFile($filepath, $lang, $lineBegin) {
        echo "<pre class=\"prettyprint lang-" . $lang . " linenums=" . $lineBegin . "\">\n";
        echo htmlentities(file_get_contents($filepath));
        echo "</pre>\n";
    }
    
}
