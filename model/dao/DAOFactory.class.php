<?php

/**
 * Description of DAOFactory
 *
 * @author Jeremie FERREIRA
 */
class DAOFactory {
    /**
     * @return PersonDAO
     */
    public static function getPersonDAO() {
        return new PersonDAO();
    }

    /**
     * @return PublicationDAO
     */
    public static function getPublicationDAO() {
        return new PublicationDAO();
    }

    /**
     * @return IdeaDAO
     */
    public static function getIdeaDAO() {
        return new IdeaDAO();
    }

    /**
     * @return CategoryDAO
     */
    public static function getCategoryDAO() {
        return new CategoryDAO();
    }

    /**
     * @return TechnologyDAO
     */
    public static function getTechnologyDAO() {
        return new TechnologyDAO();
    }

    /**
     * @return TechnologyCategoryDAO
     */
    public static function getTechnologyCategoryDAO() {
        return new TechnologyCategoryDAO();
    }

    /**
     * @return TagDAO
     */
    public static function getTagDAO() {
        return new TagDAO();
    }

    /**
     * @return StateDAO
     */
    public static function getStateDAO() {
        return new StateDAO();
    }

    /**
     * @return DidYouKnowDAO
     */
    public static function getDidYouKnowDAO() {
        return new DidYouKnowDAO();
    }

}