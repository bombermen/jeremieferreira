<?php

class PublicationController {

    /**
     * @param Publication $publication
     */
    public static function process($publication) {
        $file_url = SITE_BASE . Utils::categoryToUrl($publication->getCategory());
        $content = file_get_contents($file_url);
    }

    public static function getPublicationFromPost() {
        $title = $_POST['title'];
        $shortDescription = $_POST['shortDesc'];
        $visits = 0;
        $category = DAOFactory::getCategoryDAO()->load($_POST['category']);
        $state = DAOFactory::getStateDAO()->load($_POST['state']);

        if ($_POST['sources'] == '')
            $sourcesUrl = null;
        else
            $sourcesUrl = $_POST['sources'];

        $persons = null;
        $ideas = null;
        $technologies = null;
        $tags = null;

        $publication = new Publication(0, $title, $shortDescription, $visits, $category, $state, $sourcesUrl, $persons, $ideas, $technologies, $tags);
        $publication->_content = $_POST['publicationContent'];

        return $publication;
    }

    /**
     * @param Publication $publication
     * @param bool $absolute
     * @return string absolute/relative path to wiki on server
     */
    public static function getPublicationWikiPath($publication, $absolute = true) {
        return self::getPublicationFolder($publication, $absolute) . MAIN_PAGE;
    }

    /**
     * @param Publication $publication
     * @param bool $absolute
     * @return string absolute/relative base folder on server
     */
    public static function getPublicationFolder($publication, $absolute = true) {
        $publicationTitle = Utils::addUnderscores($publication->getTitle(), false);

        $result = $absolute ? SERVER_BASE : '';
        $result .= RESOURCES . PUBLICATIONS_FOLDER . $publicationTitle . '/';

        return $result;
    }
    
    public static function getThumbImageUrl($publication) {
        $publicationTitle = Utils::addUnderscores($publication->getTitle(), false);

        return RESOURCES . PUBLICATIONS_FOLDER . $publicationTitle . '/' . THUMB;
    }

    /**
     * @param Publication $publication
     * @param bool $absolute show site base
     * @return string absolute/relative url
     */
    public static function getPublicationUrl($publication, $absolute = true) {
        $publicationTitle = Utils::addUnderscores($publication->getTitle(), false);

        $result = $absolute ? SITE_BASE : '';
        $result .= PUBLICATIONS_FOLDER . "/" . $publicationTitle;

        return $result;
    }

    public static function getPublicationMainPageUrl($publication, $decoded=true) {
        $publicationTitle = Utils::addUnderscores($publication->getTitle(), false);

        $result = SERVER_BASE . RESOURCES . PUBLICATIONS_FOLDER . $publicationTitle . "/" . MAIN_PAGE;
        
        if($decoded)
            $result = utf8_decode ($result);

        return $result;
    }

    /**
     * @param string $url
     * @return Publication
     */
    private static function getPublicationFromUrl($url) {

        $url = explode('/', $url);
        $categoryName = $url[count($url) - 2];
        $publicationName = end($url);
        
        $url = array_splice($url, URL_BEGIN, count($url));
        $url = implode('/', $url);
        $content = file_get_contents(SERVER_BASE . RESOURCES . PUBLICATIONS_FOLDER . utf8_decode($publicationName) . '/' . MAIN_PAGE);
        
        if (!$content) {
            return null;
        }
        $publicationName = Utils::removeUnderscores($publicationName);
        $statement = 'SELECT idPublication AS id,title,shortDescription,sourcesUrl,visits,category,state FROM Publication p JOIN Category c ON p.category = c.idCategory WHERE title = :title AND c.name = :categoryName';
        $logger = Logger::getRootLogger();
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':title', $publicationName, PDO::PARAM_STR);
        $query->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        
        if($line == null)
            return null;
        
        $publication = Publication::parseArray($line);

        $publication->_content = $content;

        return $publication;
    }

    /**
     * @param Publication $publication
     */
    public static function insertOrUpdatePublication($publication) {

        $error = '';

        //insert
        if ($publication->getId() == 0) {
            //check if a publication already has this title
            //@todo: add method to DAO
            $statement = 'SELECT COUNT(idPublication) FROM Publication WHERE title = :title';
            $query = Connection::getConnection()->prepare($statement);
            $title = $publication->getTitle();
            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->execute();

            if ($query->fetchColumn() != 0)
                return 'Une publication possède déjà ce titre';

            mkdir(self::getPublicationFolder($publication));
            $path = utf8_decode(self::getPublicationWikiPath($publication));
            $file = fopen($path, "w+");
            if (!$file) {
                return 'impossible de créer le fichier ' . $path;
            }
            fputs($file, $publication->_content);


            Connection::getConnection()->beginTransaction();
            $insertFail = DAOFactory::getPublicationDAO()->insert($publication);

            if ($insertFail) {
                Connection::getConnection()->rollBack();
                return 'impossible de créer la publication en base';
            }

            Connection::getConnection()->commit();
        }
        //update
        else {
            
        }

        return $error;
    }

    public static function addModifyPublication($action) {
        $categories = DAOFactory::getCategoryDAO()->selectAll();
        $states = DAOFactory::getStateDAO()->selectAll();
        $publications = DAOFactory::getPublicationDAO()->selectAll();
        require './view/admin/addModifyPublication.php';
    }

    /**
     * Preview a publication using data within $_POST
     * @param Publication $publication
     */
    public static function previewPublication() {
        $publication = self::getPublicationFromPost();
        $_SESSION['publication'] = serialize($publication);
        self::showPublication($publication, $publication->_content);
        require './view/admin/validatePublicationPreview.php';
    }

    /**
     * Display the publication as main_page
     * @param Publication $publication
     */
    private static function showPublication($publication, $content) {
        //$content = Utils::parseWiki($content);
        require './view/commons/publication.php';
    }

    public static function displayPublicationPage($url) {
        $publication = self::getPublicationFromUrl($url);
        if ($publication) {
            self::showPublication($publication, $publication->_content);
        } else {
            Utils::display404();
        }
    }

}
