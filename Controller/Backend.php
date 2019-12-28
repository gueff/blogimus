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

use MVC\Registry;

/**
 * Backend
 */
class Backend
{
    /**
     * @var \Blogimus\Controller\Index
     */
    public $oControllerIndex;

    /**
     * @var \Blogimus\Model\Index
     */
    public $oModelIndex;

    /**
     * @var \Blogimus\Model\Backend
     */
    public $oModelBackend;

    /**
     * pages callable at backend
     * @var array
     */
    protected $aPage = array(
        '@',
        '@create', '@edit',
        '@delete'
    );

    /**
     * Backend constructor.
     * @param $oControllerIndex
     * @throws \ReflectionException
     */
    public function __construct($oControllerIndex)
    {        
        $sModelIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_INDEX'];
        $sModelBackend = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_BACKEND'];
        
        $this->oControllerIndex = $oControllerIndex;
        $this->oModelIndex = new $sModelIndex();
        $this->oModelBackend = new $sModelBackend();
        
        $this->oControllerIndex->oView->assign('aParam', (isset($_GET['a'])) ? json_decode($_GET['a'], true) : array());        
        $this->oControllerIndex->oView->assign('BLOG_CREATE_MAX_TITLE', (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_TITLE'])) ? Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_TITLE'] : '');
        $this->oControllerIndex->oView->assign('BLOG_CREATE_MAX_CONTENT', (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_CONTENT'])) ? Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_CONTENT'] : '');
    }

    /**
     * checks login into backend and delegates actions
     * @param string $sRequest
     * @throws \ReflectionException
     */
    public function backend($sRequest = '')
    {
        // Logout
        if ('@logout' === $sRequest)
        {
            $this->oModelBackend->logout();
        }

        if (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BACKEND']))
        {
            /** @var array $aBlogBackend */
            $aBlogBackend = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BACKEND'];

            // invalid page request
            if (false === in_array($sRequest, $this->aPage))
            {
                $this->oControllerIndex->oView->sendHeader404();
                $this->oControllerIndex->oView->assign('sTitle', '404');
                $this->oControllerIndex->oView->assign('aSet', array());
                $this->oControllerIndex->oView->assign('sPage', trim($this->oControllerIndex->oView->loadTemplateAsString ('index/404.tpl')));
            }

            // checks login
            if  (
                    // login already succeeded before
                    (
                            isset($_SESSION['blogimus']['login'])
                        &&  true === $_SESSION['blogimus']['login']
                    )
                    OR
                    // login success first time
                    (
                            isset($_POST['user'])
                        &&  isset($_POST['password'])
                        &&  (
                                    '' !== trim($_POST['user'])
                                ||  '' !== trim($_POST['password'])
                            )
                        &&  is_array($aBlogBackend)
                        &&  true === in_array(
                            array(
                                'user' => $_POST['user'],
                                'password' => $_POST['password'],
                            ),
                            $aBlogBackend
                        )
                    )
                )
            {
                // login successful
                (!isset($_SESSION['blogimus'])) ? $_SESSION['blogimus'] = array() : false;
                $_SESSION['blogimus']['login'] = true;

                switch ($sRequest)
                {
                    case '@':
                        \MVC\Request::REDIRECT('/');
                        break;

                    case '@edit':
                    case '@create':
                        $this->_admin($sRequest);
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
     * @param string $sRequest
     * @return bool
     * @throws \ReflectionException
     */
    private function _admin($sRequest = '')
    {
        /** @see https://stackoverflow.com/a/44687900/2487859 */
        header('X-XSS-Protection:0');

        $aParam = (true === isset($_GET['a'])) ? json_decode($_GET['a'], true) : array();
        $aInfo = array();

        if (true === isset($aParam['type']) && 'page' === $aParam['type'])
        {
            $aInfo = $this->oModelBackend->getPageOnUrl($aParam['url']);
        }
        if (true == isset($aParam['type']) && 'post' === $aParam['type'])
        {
            $aInfo = $this->oModelBackend->getPostOnUrl($aParam['url']);
        }

        $sMarkdown = ((true === isset($aInfo['sFilePath']) && true === file_exists($aInfo['sFilePath'])) ? file_get_contents($aInfo['sFilePath']) : '');
        $aTagArray = $this->oModelIndex->getTagArrayFromString($sMarkdown);
        $sTag = (!empty($aTagArray)) ? "'" . implode("','", $aTagArray) . "'" : "";
        $sMarkdown = trim(preg_replace('#<tag>(.*?)</tag>#', '', $sMarkdown));

        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';
        $this->oControllerIndex->oView->assign('sRequest', $sRequest);
        $this->oControllerIndex->oView->assign('bSuccess', 'false');
        $this->oControllerIndex->oView->assign('sFilename', ((true === isset($aInfo['sFilePath'])) ? basename($aInfo['sFilePath']) : ''));

        $this->oControllerIndex->oView->assign('aInfo', $aInfo);
        $this->oControllerIndex->oView->assign('sError', '');
        $this->oControllerIndex->oView->assign('sName', ((true === isset($aInfo['sName'])) ? $aInfo['sName'] : ''));
        $this->oControllerIndex->oView->assign('sDate', ((true === isset($aInfo['aDate']['sDate'])) ? $aInfo['aDate']['sDate'] : ''));
        $this->oControllerIndex->oView->assign('sType', ((true === isset($aParam['type'])) ? $aParam['type'] : ''));
        $this->oControllerIndex->oView->assign('sMarkdown', $sMarkdown);
        $this->oControllerIndex->oView->assign('sNotifyText', '');
        $this->oControllerIndex->oView->assign('sUrl', ((true === isset($aInfo['sUrl'])) ? $aInfo['sUrl'] : ''));
        $this->oControllerIndex->oView->assign('sTag', $sTag);
        $this->oControllerIndex->oView->assign('aParam', array('url' => ((true === isset($aInfo['sUrl'])) ? $aInfo['sUrl'] : '')));

        $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/admin.tpl'));

        return false;
    }
    /**
     * deletes a page or post
     * @throws \ReflectionException
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
                $aPost = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPost.json'), true);
                (!array_key_exists($aParam['url'], $aPost['sUrl'])) ? \MVC\Request::REDIRECT('/@') : false;
                $aSet = $aPost['sUrl'][$aParam['url']];
                $sFilePath = $aSet['sFilePath'];
            }
            elseif ('page' === $aParam['type'])
            {
                $aPage = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPage.json'), true);
                (!array_key_exists($aParam['url'], $aPage)) ? \MVC\Request::REDIRECT('/@') : false;
                $aSet = $aPage[$aParam['url']];
                $sFilePath = $aSet['sFilePath'];
            }

            if (file_exists($sFilePath))
            {
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
        unset($_SESSION['blogimus']);
        $_SESSION['blogimus'] = null;

        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/index.tpl';
        
        $this->oControllerIndex->oView->assign(
            'sContent', 
            $this->oControllerIndex->oView->loadTemplateAsString('backend/login.tpl')
        );
    }
}
