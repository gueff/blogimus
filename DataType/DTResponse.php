<?php

/**
 * @name $BlogimusDataType
 */
namespace Blogimus\DataType;

class DTResponse
{
	const DTHASH = 'd77f752a4892c221db9e9e40a0b9c8bb';

	/**
	 * @var bool
	 */
	protected $bSuccess;

	/**
	 * @var array
	 */
	protected $aInfo;

	/**
	 * @var string
	 */
	protected $sType;

	/**
	 * @var string
	 */
	protected $sFilePath;

	/**
	 * @var string
	 */
	protected $sFilename;

	/**
	 * @var string
	 */
	protected $sMessage;

	/**
	 * DTResponse constructor.
	 * @param array $aData
	 */
	public function __construct(array $aData = array())
	{
		$this->bSuccess = false;
		$this->aInfo = array();
		$this->sType = '';
		$this->sFilePath = '';
		$this->sFilename = '';
		$this->sMessage = '';

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
     * @return DTResponse
     */
    public static function create(array $aData = array())
    {
        $oObject = new self($aData);

        return $oObject;
    }

	/**
	 * @param bool $mValue 
	 * @return $this
	 */
	public function set_bSuccess($mValue)
	{
		$this->bSuccess = $mValue;

		return $this;
	}

	/**
	 * @param array $mValue 
	 * @return $this
	 */
	public function set_aInfo($mValue)
	{
		$this->aInfo = $mValue;

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
	public function set_sFilePath($mValue)
	{
		$this->sFilePath = $mValue;

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
	public function set_sMessage($mValue)
	{
		$this->sMessage = $mValue;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function get_bSuccess()
	{
		return $this->bSuccess;
	}

	/**
	 * @return array
	 */
	public function get_aInfo()
	{
		return $this->aInfo;
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
	public function get_sFilePath()
	{
		return $this->sFilePath;
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
	public function get_sMessage()
	{
		return $this->sMessage;
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_bSuccess()
	{
        return 'bSuccess';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_aInfo()
	{
        return 'aInfo';
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
	public static function getPropertyName_sFilePath()
	{
        return 'sFilePath';
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
	public static function getPropertyName_sMessage()
	{
        return 'sMessage';
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
		return '{"name":"DTResponse","file":"DTResponse.php","extends":"","namespace":"Blogimus\\\\DataType","constant":[],"property":[{"key":"bSuccess","var":"bool","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"aInfo","var":"array","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sType","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFilePath","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFilename","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sMessage","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true}],"createHelperMethods":true}';
	}

}
