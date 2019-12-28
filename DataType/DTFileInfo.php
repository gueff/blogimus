<?php

/**
 * @name $BlogimusDataType
 */
namespace Blogimus\DataType;

class DTFileInfo
{
	const DTHASH = '1866ca2e9d62301be39b46e594adfd98';

	/**
	 * @var string
	 */
	protected $sFolder;

	/**
	 * @var string
	 */
	protected $sFilename;

	/**
	 * @var string
	 */
	protected $sFilenameAbsolute;

	/**
	 * @var string
	 */
	protected $sDate;

	/**
	 * @var int
	 */
	protected $iYear;

	/**
	 * @var int
	 */
	protected $iMonth;

	/**
	 * @var int
	 */
	protected $iDay;

	/**
	 * @var string
	 */
	protected $sName;

	/**
	 * @var string
	 */
	protected $sUrl;

	/**
	 * @var string
	 */
	protected $sCreateStamp;

	/**
	 * @var string
	 */
	protected $sChangeStamp;

	/**
	 * @var bool
	 */
	protected $bFileExists;

	/**
	 * DTFileInfo constructor.
	 * @param array $aData
	 */
	public function __construct(array $aData = array())
	{
		$this->sFolder = '';
		$this->sFilename = '';
		$this->sFilenameAbsolute = '';
		$this->sDate = '';
		$this->iYear = 0;
		$this->iMonth = 0;
		$this->iDay = 0;
		$this->sName = '';
		$this->sUrl = '';
		$this->sCreateStamp = '';
		$this->sChangeStamp = '';
		$this->bFileExists = false;

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
     * @return DTFileInfo
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
	public function set_sFolder($mValue)
	{
		$this->sFolder = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sFilename($mValue)
	{
		$this->sFilename = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sFilenameAbsolute($mValue)
	{
		$this->sFilenameAbsolute = $mValue;

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
	 * @param int $mValue 
	 * @return $this
	 */
	public function set_iYear($mValue)
	{
		$this->iYear = $mValue;

		return $this;
	}

	/**
	 * @param int $mValue 
	 * @return $this
	 */
	public function set_iMonth($mValue)
	{
		$this->iMonth = $mValue;

		return $this;
	}

	/**
	 * @param int $mValue 
	 * @return $this
	 */
	public function set_iDay($mValue)
	{
		$this->iDay = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sName($mValue)
	{
		$this->sName = $mValue;

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
	public function set_sCreateStamp($mValue)
	{
		$this->sCreateStamp = $mValue;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 */
	public function set_sChangeStamp($mValue)
	{
		$this->sChangeStamp = $mValue;

		return $this;
	}

	/**
	 * @param bool $mValue 
	 * @return $this
	 */
	public function set_bFileExists($mValue)
	{
		$this->bFileExists = $mValue;

		return $this;
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
	public function get_sFilename()
	{
		return $this->sFilename;
	}

	/**
	 * @return string
	 */
	public function get_sFilenameAbsolute()
	{
		return $this->sFilenameAbsolute;
	}

	/**
	 * @return string
	 */
	public function get_sDate()
	{
		return $this->sDate;
	}

	/**
	 * @return int
	 */
	public function get_iYear()
	{
		return $this->iYear;
	}

	/**
	 * @return int
	 */
	public function get_iMonth()
	{
		return $this->iMonth;
	}

	/**
	 * @return int
	 */
	public function get_iDay()
	{
		return $this->iDay;
	}

	/**
	 * @return string
	 */
	public function get_sName()
	{
		return $this->sName;
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
	public function get_sCreateStamp()
	{
		return $this->sCreateStamp;
	}

	/**
	 * @return string
	 */
	public function get_sChangeStamp()
	{
		return $this->sChangeStamp;
	}

	/**
	 * @return bool
	 */
	public function get_bFileExists()
	{
		return $this->bFileExists;
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
	public static function getPropertyName_sFilename()
	{
        return 'sFilename';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sFilenameAbsolute()
	{
        return 'sFilenameAbsolute';
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
	public static function getPropertyName_iYear()
	{
        return 'iYear';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_iMonth()
	{
        return 'iMonth';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_iDay()
	{
        return 'iDay';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sName()
	{
        return 'sName';
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
	public static function getPropertyName_sCreateStamp()
	{
        return 'sCreateStamp';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sChangeStamp()
	{
        return 'sChangeStamp';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_bFileExists()
	{
        return 'bFileExists';
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
		return '{"name":"DTFileInfo","file":"DTFileInfo.php","extends":"","namespace":"Blogimus\\\\DataType","constant":[],"property":[{"key":"sFolder","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFilename","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFilenameAbsolute","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sDate","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"iYear","var":"int","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"iMonth","var":"int","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"iDay","var":"int","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sName","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sUrl","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sCreateStamp","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sChangeStamp","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"bFileExists","var":"bool","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true}],"createHelperMethods":true}';
	}

}
