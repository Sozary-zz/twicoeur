<?php
class context
{
    private $data;
    const SUCCESS="Success";
    const ERROR="Error";
    const NONE="None";
	private $name;
	private static $instance=null;

	 /**
     * @return context
     */
	public static function getInstance()
	{
		if(self::$instance==null)
		  self::$instance=new context();
		return self::$instance;
	}

	public function init($name)
	{
       $this->name=$name;
	}

	public function getLayout()
	{
		 return $this->layout;
	}

	public function setLayout($layout)
	{
		$this->layout=$layout;
	}

	public function redirect($url)
	{
		header("location:".$url);
	}

	public function executeAction($action,$request)
	{
		$this->layout="layout";
		if(!method_exists('mainController',$action))
		  return false;

		return  mainController::$action($request,$this);

	}

	public function getSessionAttribute($attribute)
	{
    if(isset($_SESSION[$attribute]))
		  return $_SESSION[$attribute];
	}

	public function setSessionAttribute($attribute,$value)
	{
		$_SESSION[$attribute]=$value;
	}

  public function updateSessionAttribute($attribute,$value){

  }

  public function __isset($key) {
    return isset($this->data[$key]);
  }

	public function __get($prop)
    {
        return $this->data[$prop];
    }

    public function __set($prop,$value)
    {
        $this->data[$prop]=$value;
    }


}
