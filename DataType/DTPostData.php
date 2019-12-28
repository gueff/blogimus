<?php

/**
 * @name $BlogimusDataType
 */
namespace Blogimus\DataType;

class DTPostData
{
	const DTHASH = '04d627b3548114f3507e9f32b26a8531';

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
	 * @var string
	 */
	protected $sFolder;

	/**
	 * @var string
	 */
	protected $sFileNameAbs;

	/**
	 * @var string
	 */
	protected $sFileNameAbsRecent;

	/**
	 * @var \Blogimus\DataType\DTFileInfo
	 */
	protected $oInfo;

	/**
	 * DTPostData constructor.
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
		$this->sFolder = '';
		$this->sFileNameAbs = '';
		$this->sFileNameAbsRecent = '';
		$this->oInfo = null;

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
     * @return DTPostData
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
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sFolder($mValue)
	{
		$this->sFolder = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sFileNameAbs($mValue)
	{
		$this->sFileNameAbs = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sFileNameAbsRecent($mValue)
	{
		$this->sFileNameAbsRecent = $mValue;

		return $this;
	}

	/**
	 * @param \Blogimus\DataType\DTFileInfo $mValue 
	 * @return $this
	 */
	public function set_oInfo($mValue)
	{
		$this->oInfo = $mValue;

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
	public function get_sFolder()
	{
		return $this->sFolder;
	}

	/**
	 * @return string
	 */
	public function get_sFileNameAbs()
	{
		return $this->sFileNameAbs;
	}

	/**
	 * @return string
	 */
	public function get_sFileNameAbsRecent()
	{
		return $this->sFileNameAbsRecent;
	}

	/**
	 * @return \Blogimus\DataType\DTFileInfo
	 */
	public function get_oInfo()
	{
		return $this->oInfo;
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
	 * @return string
	 */
	public static function getPropertyName_sFolder()
	{
        return 'sFolder';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sFileNameAbs()
	{
        return 'sFileNameAbs';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sFileNameAbsRecent()
	{
        return 'sFileNameAbsRecent';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_oInfo()
	{
        return 'oInfo';
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
		return '{"name":"DTPostData","file":"DTPostData.php","extends":"","namespace":"Blogimus\\\\DataType","constant":[],"property":[{"key":"sMethod","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sAction","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"oParam","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sUrl","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sType","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sTitle","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sDate","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sMarkdown","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"aTaglist","var":"array","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"oDataRecent","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFolder","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFileNameAbs","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFileNameAbsRecent","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"oInfo","var":"\\\\Blogimus\\\\DataType\\\\DTFileInfo","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true}],"createHelperMethods":true}';
	}

}
