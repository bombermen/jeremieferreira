<?php
//connection
require_once 'sql/Connection.class.php';

//domain
require_once 'domain/Person.class.php';
require_once 'domain/Publication.class.php';
require_once 'domain/Idea.class.php';
require_once 'domain/Category.class.php';
require_once 'domain/Technology.class.php';
require_once 'domain/TechnologyCategory.class.php';
require_once 'domain/Tag.class.php';
require_once 'domain/State.class.php';
require_once 'domain/DidYouKnow.class.php';

//dao
require_once 'dao/DAOFactory.class.php';
require_once 'dao/PersonDAO.class.php';
require_once 'dao/PublicationDAO.class.php';
require_once 'dao/IdeaDAO.class.php';
require_once 'dao/CategoryDAO.class.php';
require_once 'dao/TechnologyDAO.class.php';
require_once 'dao/TechnologyCategoryDAO.class.php';
require_once 'dao/TagDAO.class.php';
require_once 'dao/StateDAO.class.php';
require_once 'dao/DidYouKnowDAO.class.php';

//daoimpl
require_once 'daoimpl/PersonDAOImpl.class.php';
require_once 'daoimpl/PublicationDAOImpl.class.php';
require_once 'daoimpl/IdeaDAOImpl.class.php';
require_once 'daoimpl/CategoryDAOImpl.class.php';
require_once 'daoimpl/TechnologyDAOImpl.class.php';
require_once 'daoimpl/TechnologyCategoryDAOImpl.class.php';
require_once 'daoimpl/TagDAOImpl.class.php';
require_once 'daoimpl/StateDAOImpl.class.php';
require_once 'daoimpl/DidYouKnowDAOImpl.class.php';
