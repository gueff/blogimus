<?php

/**
 * @name $BlogimusDataType
 */
namespace Blogimus\DataType;

class DTCachefile
{
	const DTHASH = '07d7e0e5ffa1ca8d7ede840797c85c4b';

	/**
	 * @var string
	 */
	protected $sFolder;

	/**
	 * @var string
	 */
	protected $sType;

	/**
	 * @var string
	 */
	protected $sFilename;

	/**
	 * @var string
	 */
	protected $sFilenameAbsolute;

	/**
	 * @var bool
	 */
	protected $bFileExists;

	/**
	 * DTCachefile constructor.
	 * @param array $aData
	 */
	public function __construct(array $aData = array())
	{
		$this->sFolder = '';
		$this->sType = '';
		$this->sFilename = '';
		$this->sFilenameAbsolute = '';
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
     * @return DTCachefile
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
	public function set_sType($mValue)
	{
		$this->sType = $mValue;

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
	public function get_sType()
	{
		return $this->sType;
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
	public static function getPropertyName_sType()
	{
        return 'sType';
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
		return '{"name":"DTCachefile","file":"DTCachefile.php","extends":"","namespace":"Blogimus\\\\DataType","constant":[],"property":[{"key":"sFolder","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sType","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFilename","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"sFilenameAbsolute","var":"string","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true},{"key":"bFileExists","var":"bool","value":null,"visibility":"protected","static":false,"setter":true,"getter":true,"explicitMethodForValue":false,"listProperty":true,"createStaticPropertyGetter":true,"setValueInConstructor":true}],"createHelperMethods":true}';
	}

}
