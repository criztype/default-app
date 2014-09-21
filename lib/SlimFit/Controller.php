<?php namespace SlimFit;

use SlimFit\Request;
use SlimFit\Response;
use SlimFit\View;

/**
 * Main SlimFit Controller
 *
 * @author cvgellhorn
 */
class Controller
{
	/**
	 * @const Global controller defaults
	 */
	const DEFAULT_CONTROLLER = 'index';
	const DEFAULT_ACTION     = 'index';
	const ACTION_SUFFIX      = 'Action';
	const CONTROLLER_SUFFIX  = 'Controller';

	/**
	 * @var bool Load action view
	 */
	private $_renderView = true;
	
	/**
	 * @var bool Load layout template
	 */
	private $_useTemplate = true;
	
	/**
	 * @var string Use another view
	 */
	private $_useView;
	
	/**
	 * @var Request
	 */
	protected $request;
	
	/**
	 * @var View
	 */
	protected $view;
	
	/**
	 * Main controller constructor
	 */
	public function __construct()
	{
		$this->request = Request::load();
		$this->view = new View();

		// Call child constructor
		$this->_init();
	}
	
	/**
	 * Constructor for child classes
	 */
	protected function _init()
	{}
	
	/**
	 * Is called before an action is dispatched
	 */
	public function preDispatch()
	{}
	
	/**
	 * Is called after an action is dispatched
	 */
	public function postDispatch()
	{}
	
	/**
	 * Do SlimFit authentication
	 */
	public function __doAuth()
	{
		// Do Auth
		/*if($this->request->isInternal())
			return;
		
		if (App_Ini::get('auth')) {
			//-- Do auth
			require_once 'SlimFit/Auth.php';
			$auth = App_Auth::getInstance();
		}*/
	}
	
	/**
	 * Load action view
	 */
	public function __loadView()
	{
		if ($this->_renderView) {
			$action = (null !== $this->_useView) ? $this->_useView :
				$this->request->getActionName();
			$controller = $this->request->getControllerName();
			
			if($this->request->isInternal() || !$this->_useTemplate) {
				$this->view->loadView($action, $controller);
			} else {
				$this->view->loadLayoutView($action, $controller);
			}
		}
	}
	
	/**
	 * Set no view renderer
	 */
	protected function setNoRender()
	{
		$this->_renderView = false;
	}
	
	/**
	 * Set no layout template
	 */
	protected function setNoTemplate()
	{
		$this->_useTemplate = false;
	}
	
	/**
	 * Set another view to render
	 * 
	 * @param string $view View to render
	 */
	protected function useView($view)
	{
		$this->_renderView = true;	
		$this->_useView = $view;
	}
	
	/**
	 * Redirect to given uri
	 * 
	 * @param string $uri Uri to redirect
	 */
	protected function redirect($uri)
	{
		Response::load()->redirect($uri);
	}
}