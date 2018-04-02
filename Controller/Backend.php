<?php

/**
 * Backend.php
 *
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusController
 */
namespace Blogimus\Controller;

/**
 * Backend
 */
class Backend
{
    public $oControllerIndex;
    public $oModelIndex;
    public $oModelBackend;

    /**
     * Constructor
     * @param object $oControllerIndex
     * @access public
     * @return void 
     */
    public function __construct($oControllerIndex)
    {        
        $sModelIndex = \MVC\Registry::get('BLOG_CLASS_MODEL_INDEX');
        $sModelBackend = \MVC\Registry::get('BLOG_CLASS_MODEL_BACKEND');
        
        $this->oControllerIndex = $oControllerIndex;
        $this->oModelIndex = new $sModelIndex(); # \Blogimus\Model\Index();
        $this->oModelBackend = new $sModelBackend(); # \Blogimus\Model\Backend();
        
        $this->oControllerIndex->oView->assign('aParam', (isset($_GET['a'])) ? json_decode($_GET['a'], true) : array());        
        $this->oControllerIndex->oView->assign('BLOG_CREATE_MAX_TITLE', ((\MVC\Registry::isRegistered('BLOG_CREATE_MAX_TITLE')) ? \MVC\Registry::get('BLOG_CREATE_MAX_TITLE') : ''));
        $this->oControllerIndex->oView->assign('BLOG_CREATE_MAX_CONTENT', ((\MVC\Registry::isRegistered('BLOG_CREATE_MAX_CONTENT')) ? \MVC\Registry::get('BLOG_CREATE_MAX_CONTENT') : ''));
    }

    /**
     * checks login into backend and delegates actions
     * @param type $sRequest
     * @access public
     * @return void 
     */
    public function backend($sRequest = '')
    {
        // Logout
        if ('@logout' === $sRequest)
        {
            $this->oModelBackend->logout();
        }

        if (true === \MVC\Registry::isRegistered('BLOG_BACKEND'))
        {
            $aBlogBackend = \MVC\Registry::get('BLOG_BACKEND');

            // checks login
            if (
                (isset($_SESSION['blogixx']['login']) && true === $_SESSION['blogixx']['login']) || (
                isset($_POST['user']) && isset($_POST['password']) && (
                '' !== trim($_POST['user']) || '' !== trim($_POST['password'])
                ) && array_key_exists(\MVC\Registry::get('MVC_ENV'), $aBlogBackend) && is_array($aBlogBackend[\MVC\Registry::get('MVC_ENV')]) && true === in_array(
                    array(
                    'user' => $_POST['user'],
                    'password' => $_POST['password'],
                    ), $aBlogBackend[\MVC\Registry::get('MVC_ENV')]
                )
                )
            )
            {
                // login successful
                (!isset($_SESSION['blogixx'])) ? $_SESSION['blogixx'] = array() : false;
                $_SESSION['blogixx']['login'] = true;

                switch ($sRequest)
                {
                    case '@':
//                        $this->_overview();
                        \MVC\Request::REDIRECT('/');
                        break;

                    case '@edit':
                        $this->_edit();
                        break;

                    case '@create':
                        $this->_create();
                        break;

                    case '@delete':
                        $this->_delete();
                        break;

                    default:
                        \MVC\Request::REDIRECT('/@');
                        break;
                }
            }
            // show login Form
            else
            {
                $this->_loginForm();
            }
        }
    }

    /**
     * shows overview
     * @param string $sRequest
     * @access private
     * @return void 
     */
    private function _overview($sRequest = '')
    {
        // get all posts
        $aPost = $this->oModelIndex->getPostsOverview();
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('aPost', $aPost);

        // get all pages
        $aPage = json_decode(file_get_contents(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPage.json'), true);
        $this->oControllerIndex->oView->assign('aPage', $aPage);

        $this->oControllerIndex->oView->assign(
            'sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/overview.tpl')
        );
    }

    /**
     * edit contents
     * @access public
     * @return void 
     */
    private function _edit()
    {
        /** @see https://stackoverflow.com/a/44687900/2487859 */
        header('X-XSS-Protection:0');
        
        $bSuccess = false;
        $sSuccess = '';
        $sMarkdown = '';
        $sMessage = '';
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('sContent', '');

        (!isset($_GET['a'])) ? \MVC\Request::REDIRECT('/@') : false;
        $aParam = json_decode($_GET['a'], true);

        // invalid request
        (!isset($aParam['type']) || !isset($aParam['url'])) ? \MVC\Request::REDIRECT('/@') : false;
        (!in_array($aParam['type'], array('page', 'post'))) ? \MVC\Request::REDIRECT('/@') : false;

        if ('post' === $aParam['type'])
        {
            $aSet = ('' === $this->oModelBackend->getPostOnUrl($aParam['url'])) ? \MVC\Request::REDIRECT('/@') : $this->oModelBackend->getPostOnUrl($aParam['url']);
        }
        elseif ('page' === $aParam['type'])
        {
            $aSet = ('' === $this->oModelBackend->getPageOnUrl($aParam['url'])) ? \MVC\Request::REDIRECT('/@') : $this->oModelBackend->getPageOnUrl($aParam['url']);
        }
        
        if (!array_key_exists('sFilePath', $aSet))
        {
            \MVC\Request::REDIRECT('/@');
        }

        $sFilePath = $aSet['sFilePath'];
        $sFilePathNew = $sFilePath;

        (isset($_POST['title'])) ? $_POST['title'] = trim(str_replace(array('/', '\\'), array('|', '|'), $_POST['title'])) : false;
        (isset($_POST['sMarkdown'])) ? $_POST['sMarkdown'] = trim($_POST['sMarkdown']) : false;

        // Date
        (isset($_POST['date'])) ? $sDate = $this->oModelBackend->sDate($_POST['date']) : false;

        // new filename
        if (isset($_POST['type']) && isset($_POST['title']))
        {
            $sFilePathNew = \MVC\Registry::get('BLOG_DATA_DIR') . '/' . $_POST['type'] . '/' . ((isset($sDate)) ? $sDate . '.' : '') . $_POST['title'] . '.md';
        }
        
        if ($_POST)
        {            
            (false === isset($_POST['sMarkdown'])) ? $sMessage .= 'Missing Content.<br>' : false;
            (true === file_exists($sFilePathNew) && $sFilePathNew !== $sFilePath) ? $sMessage .= 'a  ' . ucfirst($_POST['type']) . ' "' . $_POST['title'] . '" ' . ((isset($sDate)) ? ' with date "' . $sDate . '" ' : '') . 'already exists.<br>' : false;
        }

        if  (
                    isset($sFilePathNew) 
                && (
                        !file_exists($sFilePathNew)     // new filename; make sure there is no file named so yet
                    ||  $sFilePathNew === $sFilePath    // no changes in filename; still the same
                ) 
                &&  isset($_POST['sMarkdown'])
        )
        {
            // delete old
            (file_exists($sFilePath)) ? unlink($sFilePath) : false;      
            
            $_POST['sMarkdown'] = trim(''
                // prepend new tag
                . ((!empty($_POST['taggles'])) ? '<tag>' . implode(',', $_POST['taggles']) . '</tag>' . "\n" : '')
                // remove former tags from markup
                . preg_replace('#<tag>(.*?)</tag>#', '', $_POST['sMarkdown'])
            );
            
            // write new
            $bSuccess = (boolean) file_put_contents(
                $sFilePathNew, 
                $_POST['sMarkdown'], 
                LOCK_EX
            );
            $sSuccess = ((true === $bSuccess) ? 'true' : 'false');
            
            $sRedirect = '/@edit?a={"type":"' . $aParam['type'] . '","url":"/' . $aParam['type'] . ((isset($sDate)) ? '/' . str_replace('-', '/', $sDate) : '') . '/' . \Blogimus\Model\Index::seoname($_POST['title']) . '/"}';
            \MVC\Request::REDIRECT($sRedirect);
        }

        // load content
        $sMarkdown = (file_exists($sFilePath)) ? file_get_contents($sFilePath) : '';
        $aTagArray = $this->oModelIndex->getTagArrayFromString($sMarkdown);
        $sTag = (!empty($aTagArray)) ? "'" . implode("','", $aTagArray) . "'" : "";

        $this->oControllerIndex->oView->assign('sTag', $sTag);
        
        $sMarkdown = preg_replace('#<tag>(.*?)</tag>#', '', $sMarkdown);

        $this->oControllerIndex->oView->assign('sError', $sMessage);
        $this->oControllerIndex->oView->assign('bSuccess', $sSuccess);
        $this->oControllerIndex->oView->assign('sNotifyText', (('true' == $sSuccess) ? 'successfully edited' : ''));
        $this->oControllerIndex->oView->assign('sDate', (isset($aSet['sCreateStamp'])) ? $aSet['sCreateStamp'] : '');
        $this->oControllerIndex->oView->assign('sName', $aSet['sName']);
        $this->oControllerIndex->oView->assign('sType', $aParam['type']);
        $this->oControllerIndex->oView->assign('sUrl', $aSet['sUrl']);
        $this->oControllerIndex->oView->assign('sMarkdown', $sMarkdown);
        $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/edit.tpl'));
    }

    /**
     * creates content
     * @access private
     * @return boolean success
     */
    private function _create()
    {
        /** @see https://stackoverflow.com/a/44687900/2487859 */
        header('X-XSS-Protection:0');
        
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('bSuccess', 'false');
        $this->oControllerIndex->oView->assign('sFilename', '');
        $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/create.tpl'));

        if ($_POST)
        {
            if (!isset($_POST['type']) || ($_POST['type'] != 'page' && $_POST['type'] != 'post'))
            {
                return false;
            }
            
            if ($_POST['type'] == 'post' && (!isset($_POST['date']) || empty($_POST['date'])))
            {
                return false;
            }
            
            if ('' == trim($_POST['title']) || '' == trim($_POST['sMarkdown']))
            {
                return false;
            }

            // Path
            $sFilePath = '';
            ('post' == $_POST['type']) ? $sFilePath = \MVC\Registry::get('BLOG_DATA_DIR') . '/post/' : false;
            ('page' == $_POST['type']) ? $sFilePath = \MVC\Registry::get('BLOG_DATA_DIR') . '/page/' : false;

            if ('' === $sFilePath)
            {
                return false;
            }

            $_POST['title'] = trim(str_replace(array('/', '\\'), array('|', '|'), $_POST['title']));
            $_POST['sMarkdown'] = trim($_POST['sMarkdown']);

            // Date
            (isset($_POST['date'])) ? $sDate = $this->oModelBackend->sDate($_POST['date']) : false;

            $sFilename = $sFilePath . ((isset($_POST['date'])) ? $_POST['date'] . '.' : '') . $_POST['title'] . '.md';
            $sMessage = '';
            
            if (file_exists($sFilename))
            {
                $sMessage .= 'a  ' . ucfirst($_POST['type']) . ' "' . $_POST['title'] . '" ' . ((isset($sDate)) ? ' with date "' . $sDate . '" ' : '') . 'already exists.<br>';
            }
            
            $_POST['sMarkdown'] = ''
                // prepend new tag
                . ((!empty($_POST['taggles'])) ? '<tag>' . implode(',', $_POST['taggles']) . '</tag>' . "\n" : '')
                // remove former tags from markup
                . preg_replace('#<tag>(.*?)</tag>#', '', $_POST['sMarkdown']);
            
            // save
            if (false === file_put_contents($sFilename, $_POST['sMarkdown'], LOCK_EX))
            {
                return false;
            }

            $this->oControllerIndex->oView->assign('sError', $sMessage);
            $this->oControllerIndex->oView->assign('bSuccess', 'true');
            $this->oControllerIndex->oView->assign('sNotifyText', 'successfully created: ' . basename($sFilename, '.md'));
            $this->oControllerIndex->oView->assign('sFilename', basename($sFilename, '.md'));
            $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/create.tpl'));
            
            return true;
        }
        
        return false;
    }

    /**
     * deletes a page or post
     * @access private
     * @return void 
     */
    private function _delete()
    {
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('sContent', '');

        (!isset($_GET['a'])) ? \MVC\Request::REDIRECT('/@') : false;
        $aParam = json_decode($_GET['a'], true);

        // valid request
        if  (
                    (isset($aParam['type']) && isset($aParam['url']))
                ||  (in_array($aParam['type'], array('page', 'post')))
        )
        {
            $sMarkdown = '';

            if ('post' === $aParam['type'])
            {
                $aPost = json_decode(file_get_contents(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPost.json'), true);
                (!array_key_exists($aParam['url'], $aPost['sUrl'])) ? \MVC\Request::REDIRECT('/@') : false;
                $aSet = $aPost['sUrl'][$aParam['url']];
                $sFilePath = $aSet['sFilePath'];
            }
            elseif ('page' === $aParam['type'])
            {
                $aPage = json_decode(file_get_contents(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPage.json'), true);
                (!array_key_exists($aParam['url'], $aPage)) ? \MVC\Request::REDIRECT('/@') : false;
                $aSet = $aPage[$aParam['url']];
                $sFilePath = $aSet['sFilePath'];
            }

            if (file_exists($sFilePath))
            {
                \MVC\Helper::DISPLAY($sFilePath);
                unlink($sFilePath);
            }
        }

        \MVC\Request::REDIRECT('/@');
    }

    /**
     * shows login form
     * @access private
     * @return void 
     */
    private function _loginForm()
    {
        unset($_SESSION['blogixx']);
        $_SESSION['blogixx'] = null;

        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/index.tpl';
        
        $this->oControllerIndex->oView->assign(
            'sContent', 
            $this->oControllerIndex->oView->loadTemplateAsString('backend/login.tpl')
        );
    }
}
