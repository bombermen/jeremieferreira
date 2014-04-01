<?php

/**
 * Description of DAOFactory
 *
 * @author Jeremie FERREIRA
 */
class DAOFactory {
    /**
     * @return PersonDAOImpl
     */
    public static function getPersonDAO() {
        return new PersonDAOImpl();
    }

    /**
     * @return PublicationDAOImpl
     */
    public static function getPublicationDAO() {
        return new PublicationDAOImpl();
    }

    /**
     * @return IdeaDAOImpl
     */
    public static function getIdeaDAO() {
        return new IdeaDAOImpl();
    }

    /**
     * @return CategoryDAOImpl
     */
    public static function getCategoryDAO() {
        return new CategoryDAOImpl();
    }

    /**
     * @return TechnologyDAOImpl
     */
    public static function getTechnologyDAO() {
        return new TechnologyDAOImpl();
    }

    /**
     * @return TechnologyCategoryDAOImpl
     */
    public static function getTechnologyCategoryDAO() {
        return new TechnologyCategoryDAOImpl();
    }

    /**
     * @return TagDAOImpl
     */
    public static function getTagDAO() {
        return new TagDAOImpl();
    }

    /**
     * @return StateDAOImpl
     */
    public static function getStateDAO() {
        return new StateDAOImpl();
    }

    /**
     * @return DidYouKnowDAOImpl
     */
    public static function getDidYouKnowDAO() {
        return new DidYouKnowDAOImpl();
    }

}