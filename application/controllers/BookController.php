<?php

class BookController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout->setLayout('layout');
    }

    public function bookAction()
    {
        if(!$this->getRequest()->isPost()) return ;
        $bookData=$this->getRequest()->getPost();
        $saveBook=Application_Model_Book::saveBookData($bookData);
        $this->redirect('/booklist');
    }

    public function booklistAction(){

        // create new session
        $session = new Zend_Session_Namespace();

        // get books from DB
    	$getBook=Application_Model_Book::getBookData();
    	$this->view->getBook = $getBook;

        // delete alert action
        $this->view->isDelete = 0;
        $del = $session->action;
        $session->action = '';
        if($del == 'delete'){
            $this->view->isDelete = 1;
        }

        // get id to delete
        $id = $this->getRequest()->getParam('id', '');
        if($id == '') return ; // id must not be empty
        if(!is_numeric($id)) return ; // id must be numeric

        $session->action = 'delete';

        // do delete
        Application_Model_Book::deleteData($id);

        // redirect after delete
        $this->redirect('/booklist?del=1');
        
    }

}
?>