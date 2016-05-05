<?php

/**
 * Backend.php.
 *
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */
/**
 * @name $BlogixxController
 */


namespace Blogixx\Controller;


/**
 * Backend.
 */
class Backend
{

	/**
	 * \Blogixx\Controller\Index.
	 * 
	 * @var \Blogixx\Controller\Index
	 */
	public $oControllerIndex;

	/**
	 * \Blogixx\Model\Backend.
	 * 
	 * @var \Blogixx\Model\Backend
	 */
	public $oModelBackend;


	/**
	 * Constructor.
	 */
	public function __construct ($oControllerIndex)
	{
		$this->oControllerIndex = $oControllerIndex;
		$this->oModelIndex = new \Blogixx\Model\Index();
		$this->oModelBackend = new \Blogixx\Model\Backend();

		$this->oControllerIndex->oBlogixxViewIndex->assign ('BLOG_CREATE_MAX_TITLE', ((\MVC\Registry::isRegistered ('BLOG_CREATE_MAX_TITLE')) ? \MVC\Registry::get ('BLOG_CREATE_MAX_TITLE') : ''));
		$this->oControllerIndex->oBlogixxViewIndex->assign ('BLOG_CREATE_MAX_CONTENT', ((\MVC\Registry::isRegistered ('BLOG_CREATE_MAX_CONTENT')) ? \MVC\Registry::get ('BLOG_CREATE_MAX_CONTENT') : ''));
	}

	/**
	 * checks login into backend and delegates actions.
	 * 
	 * @param type $sRequest
	 */
	public function backend ($sRequest = '')
	{
		// Logout
		if ('@logout' === $sRequest)
		{
			$this->oModelBackend->logout ();
		}

		if (true === \MVC\Registry::isRegistered ('BLOG_BACKEND'))
		{
			$aBlogBackend = \MVC\Registry::get ('BLOG_BACKEND');

			// checks login
			if	(
						(isset ($_SESSION['blogixx']['login']) && true === $_SESSION['blogixx']['login']) 
					||	(
								isset ($_POST['user']) 
							&&	isset ($_POST['password']) 
							&&	(
										'' !== trim ($_POST['user']) 
									||	'' !== trim ($_POST['password'])
								) 
							&&	array_key_exists (\MVC\Registry::get ('MVC_ENV'), $aBlogBackend) 
							&&	is_array ($aBlogBackend[\MVC\Registry::get ('MVC_ENV')]) 
							&&	true === in_array (
								array (
									'user' => $_POST['user'],
									'password' => $_POST['password'],
								), 
								$aBlogBackend[\MVC\Registry::get ('MVC_ENV')]
							)
						)
				)
			{
				// login successful
				(!isset ($_SESSION['blogixx'])) ? $_SESSION['blogixx'] = array () : false;
				$_SESSION['blogixx']['login'] = true;

				switch ($sRequest)
				{
					case '@':
						$this->_overview ();
						break;

					case '@edit':
						$this->_edit ();
						break;

					case '@create':
						$this->_create ();
						break;

					case '@delete':
						$this->_delete ();
						break;

					default:
						\MVC\Request::REDIRECT ('/@');
						break;
				}
			}
			// show login Form
			else
			{
				$this->_loginForm ();
			}

			$this->oControllerIndex->oBlogixxViewIndex->sTemplate = 'layout/backend.tpl';
		}
	}

	/**
	 * shows overview.
	 * 
	 * @param type $sRequest
	 */
	private function _overview ($sRequest = '')
	{
		// get all posts
		$aPost = $this->oModelIndex->getPostsOverview ();
		$this->oControllerIndex->oBlogixxViewIndex->assign ('aPost', $aPost);

		// get all pages
		$aPage = json_decode (file_get_contents (\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/aPage.json'), true);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('aPage', $aPage);

		$this->oControllerIndex->oBlogixxViewIndex->assign (
			'sContent', 
			$this->oControllerIndex->oBlogixxViewIndex->loadTemplateAsString ('backend/overview.tpl')
		);
	}

	/**
	 * edit contents.
	 */
	private function _edit ()
	{
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sContent', '');

		(!isset ($_GET['a'])) ? \MVC\Request::REDIRECT ('/@') : false;
		$aParam = json_decode ($_GET['a'], true);

		// invalid request
		(!isset ($aParam['type']) || !isset ($aParam['url'])) ? \MVC\Request::REDIRECT ('/@') : false;
		(!in_array ($aParam['type'], array ('page', 'post'))) ? \MVC\Request::REDIRECT ('/@') : false;

		$sMarkdown = '';

		if ('post' === $aParam['type'])
		{
			$aSet = ('' === $this->oModelBackend->getPostOnUrl ($aParam['url'])) ? \MVC\Request::REDIRECT ('/@') : $this->oModelBackend->getPostOnUrl ($aParam['url']);
		}
		elseif ('page' === $aParam['type'])
		{
			$aSet = ('' === $this->oModelBackend->getPageOnUrl ($aParam['url'])) ? \MVC\Request::REDIRECT ('/@') : $this->oModelBackend->getPageOnUrl ($aParam['url']);
		}

		if (!array_key_exists ('sFilePath', $aSet))
		{
			\MVC\Request::REDIRECT ('/@');
		}

		$sFilePath = $aSet['sFilePath'];
		$sFilePathNew = $sFilePath;

		(isset ($_POST['title'])) ? $_POST['title'] = trim (str_replace (array ('/', '\\'), array ('|', '|'), $_POST['title'])) : false;
		(isset ($_POST['sMarkdown'])) ? $_POST['sMarkdown'] = trim ($_POST['sMarkdown']) : false;

		// Date
		(isset ($_POST['date'])) ? $sDate = $this->oModelBackend->sDate ($_POST['date']) : false;

		// new filename
		if (isset ($_POST['type']) && isset ($_POST['title']))
		{
			$sFilePathNew = realpath (__DIR__ . '/../') . '/data/' . $_POST['type'] . '/' . ((isset ($sDate)) ? $sDate . '.' : '') . $_POST['title'] . '.md';
		}

		$sMessage = '';
		if ($_POST)
		{
			(false === isset ($_POST['sMarkdown'])) ? $sMessage .= 'Missing Content.<br>' : false;
			(true === file_exists ($sFilePathNew) && $sFilePathNew !== $sFilePath) ? $sMessage .= 'a  ' . ucfirst ($_POST['type']) . ' "' . $_POST['title'] . '" ' . ((isset ($sDate)) ? ' with date "' . $sDate . '" ' : '') . 'already exists.<br>' : false;
		}

		if (
			isset ($sFilePathNew) && (
			!file_exists ($sFilePathNew)  // new filename; make sure there is no file named so yet
			|| $sFilePathNew === $sFilePath // no changes in filename; still the same
			) && isset ($_POST['sMarkdown'])
		)
		{
			// delete old
			(file_exists ($sFilePath)) ? unlink ($sFilePath) : false;

			// write new
			file_put_contents (
				$sFilePathNew, $_POST['sMarkdown'], LOCK_EX
			);

			$sRedirect = '/@edit?a={"type":"' . $aParam['type'] . '","url":"/' . $aParam['type'] . ((isset ($sDate)) ? '/' . str_replace ('-', '/', $sDate) : '') . '/' . \Blogixx\Model\Index::seoname ($_POST['title']) . '/"}';
			\MVC\Request::REDIRECT ($sRedirect);
		}

		// load content
		$sMarkdown = (file_exists ($sFilePath)) ? file_get_contents ($sFilePath) : '';

		$this->oControllerIndex->oBlogixxViewIndex->assign ('sError', $sMessage);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('aParam', $aParam);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sDate', (isset ($aSet['sCreateStamp'])) ? $aSet['sCreateStamp'] : '');
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sName', $aSet['sName']);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sType', $aParam['type']);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sUrl', $aSet['sUrl']);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sMarkdown', $sMarkdown);
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sContent', $this->oControllerIndex->oBlogixxViewIndex->loadTemplateAsString ('backend/edit.tpl'));
	}

	private function _create ()
	{
		$this->oControllerIndex->oBlogixxViewIndex->assign ('bSuccess', 'false');
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sFilename', '');
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sContent', $this->oControllerIndex->oBlogixxViewIndex->loadTemplateAsString ('backend/create.tpl'));

		if ($_POST)
		{
			if (!isset ($_POST['type']) || ($_POST['type'] != 'page' && $_POST['type'] != 'post'))
			{
				return false;
			}
			if ($_POST['type'] == 'post' && (!isset ($_POST['date']) || empty ($_POST['date'])))
			{
				return false;
			}
			if ('' == trim ($_POST['title']) || '' == trim ($_POST['sMarkdown']))
			{
				return false;
			}

			// Path
			$sFilePath = '';
			('post' == $_POST['type']) ? $sFilePath = realpath (__DIR__ . '/../') . '/data/post/' : false;
			('page' == $_POST['type']) ? $sFilePath = realpath (__DIR__ . '/../') . '/data/page/' : false;

			if ('' === $sFilePath)
			{
				return false;
			}

			$_POST['title'] = trim (str_replace (array ('/', '\\'), array ('|', '|'), $_POST['title']));
			$_POST['sMarkdown'] = trim ($_POST['sMarkdown']);

			// Date
			(isset ($_POST['date'])) ? $sDate = $this->oModelBackend->sDate ($_POST['date']) : false;

			$sFilename = $sFilePath . ((isset ($_POST['date'])) ? $_POST['date'] . '.' : '') . $_POST['title'] . '.md';

			$sMessage = '';
			if (file_exists ($sFilename))
			{
				$sMessage .= 'a  ' . ucfirst ($_POST['type']) . ' "' . $_POST['title'] . '" ' . ((isset ($sDate)) ? ' with date "' . $sDate . '" ' : '') . 'already exists.<br>';
			}

			if (false === file_put_contents (
					$sFilename, $_POST['sMarkdown'], LOCK_EX
				))
			{
				return false;
			}

			$this->oControllerIndex->oBlogixxViewIndex->assign ('sError', $sMessage);
			$this->oControllerIndex->oBlogixxViewIndex->assign ('bSuccess', 'true');
			$this->oControllerIndex->oBlogixxViewIndex->assign ('sFilename', basename ($sFilename, '.md'));
			$this->oControllerIndex->oBlogixxViewIndex->assign ('sContent', $this->oControllerIndex->oBlogixxViewIndex->loadTemplateAsString ('backend/create.tpl'));
		}

		return true;
	}

	/**
	 * deletes a page or post.
	 */
	private function _delete ()
	{
		$this->oControllerIndex->oBlogixxViewIndex->assign ('sContent', '');

		(!isset ($_GET['a'])) ? \MVC\Request::REDIRECT ('/@') : false;
		$aParam = json_decode ($_GET['a'], true);

		// valid request
		if (
			(isset ($aParam['type']) && isset ($aParam['url'])) || (in_array ($aParam['type'], array ('page', 'post')))
		)
		{
			$sMarkdown = '';

			if ('post' === $aParam['type'])
			{
				$aPost = json_decode (file_get_contents (\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/aPost.json'), true);
				(!array_key_exists ($aParam['url'], $aPost['sUrl'])) ? \MVC\Request::REDIRECT ('/@') : false;
				$aSet = $aPost['sUrl'][$aParam['url']];
				$sFilePath = $aSet['sFilePath'];
			}
			elseif ('page' === $aParam['type'])
			{
				$aPage = json_decode (file_get_contents (\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/aPage.json'), true);
				(!array_key_exists ($aParam['url'], $aPage)) ? \MVC\Request::REDIRECT ('/@') : false;
				$aSet = $aPage[$aParam['url']];
				$sFilePath = $aSet['sFilePath'];
			}

			if (file_exists ($sFilePath))
			{
				\MVC\Helper::DISPLAY ($sFilePath);
				unlink ($sFilePath);
			}
		}

		\MVC\Request::REDIRECT ('/@');
	}

	/**
	 * shows login form.
	 */
	private function _loginForm ()
	{
		unset ($_SESSION['blogixx']);
		$_SESSION['blogixx'] = null;

		$this->oControllerIndex->oBlogixxViewIndex->assign (
			'sContent', $this->oControllerIndex->oBlogixxViewIndex->loadTemplateAsString ('backend/login.tpl')
		);
	}

}
