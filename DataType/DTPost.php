<?php

/**
 * @name $BlogimusDataType
 */
namespace Blogimus\DataType;

class DTPost
{
	const DTHASH = '2b11912954b3afb092c511acad5dc50d';

	/**
	 * @var string
	 */
	protected $sMethod;

	/**
	 * @var string
	 */
	protected $sAction;

	/**
	 * @var string
	 */
	protected $oParam;

	/**
	 * @var string
	 */
	protected $sUrl;

	/**
	 * @var string
	 */
	protected $sType;

	/**
	 * @var string
	 */
	protected $sTitle;

	/**
	 * @var string
	 */
	protected $sDate;

	/**
	 * @var string
	 */
	protected $sMarkdown;

	/**
	 * @var array
	 */
	protected $aTaglist;

	/**
	 * @var string
	 */
	protected $oDataRecent;

	/**
	 * DTPost constructor.
	 * @param array $aData
	 */
	public function __construct(array $aData = array())
	{
		$this->sMethod = '';
		$this->sAction = '';
		$this->oParam = '';
		$this->sUrl = '';
		$this->sType = '';
		$this->sTitle = '';
		$this->sDate = '';
		$this->sMarkdown = '';
		$this->aTaglist = array();
		$this->oDataRecent = '';

		foreach ($aData as $sKey => $mValue)
		{
			$sMethod = 'set_' . $sKey;

			if (method_exists($this, $sMethod))
			{
				$this->$sMethod($mValue);
			}
		}
	}

    /**
     * @param array $aData
     * @return DTPost
     */
    public static function create(array $aData = array())
    {
        $oObject = new self($aData);

        return $oObject;
    }

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sMethod($mValue)
	{
		$this->sMethod = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sAction($mValue)
	{
		$this->sAction = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_oParam($mValue)
	{
		$this->oParam = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sUrl($mValue)
	{
		$this->sUrl = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sType($mValue)
	{
		$this->sType = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sTitle($mValue)
	{
		$this->sTitle = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sDate($mValue)
	{
		$this->sDate = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sMarkdown($mValue)
	{
		$this->sMarkdown = $mValue;

		return $this;
	}

	/**
	 * @param array $mValue 
	 * @return $this
	 */
	public function set_aTaglist($mValue)
	{
		$this->aTaglist = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_oDataRecent($mValue)
	{
		$this->oDataRecent = $mValue;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_sMethod()
	{
		return $this->sMethod;
	}

	/**
	 * @return string
	 */
	public function get_sAction()
	{
		return $this->sAction;
	}

	/**
	 * @return string
	 */
	public function get_oParam()
	{
		return $this->oParam;
	}

	/**
	 * @return string
	 */
	public function get_sUrl()
	{
		return $this->sUrl;
	}

	/**
	 * @return string
	 */
	public function get_sType()
	{
		return $this->sType;
	}

	/**
	 * @return string
	 */
	public function get_sTitle()
	{
		return $this->sTitle;
	}

	/**
	 * @return string
	 */
	public function get_sDate()
	{
		return $this->sDate;
	}

	/**
	 * @return string
	 */
	public function get_sMarkdown()
	{
		return $this->sMarkdown;
	}

	/**
	 * @return array
	 */
	public function get_aTaglist()
	{
		return $this->aTaglist;
	}

	/**
	 * @return string
	 */
	public function get_oDataRecent()
	{
		return $this->oDataRecent;
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sMethod()
	{
        return 'sMethod';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sAction()
	{
        return 'sAction';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_oParam()
	{
        return 'oParam';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sUrl()
	{
        return 'sUrl';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sType()
	{
        return 'sType';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sTitle()
	{
        return 'sTitle';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sDate()
	{
        return 'sDate';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sMarkdown()
	{
        return 'sMarkdown';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_aTaglist()
	{
        return 'aTaglist';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_oDataRecent()
	{
        return 'oDataRecent';
	}

	/**
	 * @return false|string JSON
	 */
	public function __toString()
	{
        return $this->getPropertyJson();
	}

	/**
	 * @return false|string
	 */
	public function getPropertyJson()
	{
        return json_encode($this->getPropertyArray());
	}

	/**
	 * @return array
	 */
	public function getPropertyArray()
	{
        return get_object_vars($this);
	}

	/**
	 * @return array
	 * @throws \ReflectionException
	 */
	public function getConstantArray()
	{
		$oReflectionClass = new \ReflectionClass($this);
		$aConstant = $oReflectionClass->getConstants();

		return $aConstant;
	}

	/**
	 * @return $this
	 */
	public function flushProperties()
	{
		foreach ($this->getPropertyArray() as $sKey => $aValue)
		{
			$sMethod = 'set_' . $sKey;

			if (method_exists($this, $sMethod)) 
			{
				$this->$sMethod('');
			}
		}

		return $this;
	}

	/**
	 * @return string JSON
	 */
	public function getDataTypeConfigJSON()
	{
		return '{"name":"DTPost","file":"DTPost.php","extends":"","namespace":"Blogimus\\\\DataType","constant":[],"property":[{"key":"sMethod","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sAction","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"oParam","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sUrl","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sType","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sTitle","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sDate","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sMarkdown","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"aTaglist","var":"array","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"oDataRecent","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true}],"createHelperMethods":true}';
	}

}
