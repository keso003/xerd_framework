<?php
class Loader
{
	protected $_models = array();
        // From ZF  
        // Autodiscover the path from the class name
        // Implementation is PHP namespace-aware, and based on
        // Framework Interop Group reference implementation:
        // http://groups.google.com/group/php-standards/web/psr-0-final-proposal
	function loadClass($class, $params=array())
	{                
		$className = ltrim($class, '\\');
		$file      = '';
		$namespace = '';
		if ($lastNsPos = strripos($className, '\\')) {
		    $namespace = substr($className, 0, $lastNsPos);
		    $className = substr($className, $lastNsPos + 1);
		    $file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		
		$file = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		require_once($file);
		
		
		$file_info =  array('namespace'=>$namespace,'className'=>$className,'file'=>$file,);
	}


	public function model($name) {
		static $_list_model = array();
		
		if(in_array($name, $_list_model)) {
			return ;
		}

		if(in_array($name, $this->_models)) {
			return;
		}

		$I =& get_instance();

		load_class($name);



		$I->$name = new $name();
		$_list_model[$name] = $name;

		return ;
	}


}