<?php
namespace Source\Migrations\Core;

use InvalidArgumentException;
use ReflectionClass;
use Source\Core\Connect;

/**
 * DDL Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class DDL
{
    /** @var ReflectionClass Objeto de reflexão que permite espelhar outras classes */
    private ReflectionClass $reflectionClass;

    /** @var array Propiedades da classe */
    private array $classProperties;

    /** @var string String sql */
    private string $sql;

    private string $className;

    /**
     * DDL constructor
     */
    public function __construct(string $class)
    {
        $this->reflectionClass = new ReflectionClass($class);
    }

    public function setClassProperties()
    {
        if (!$this->reflectionClass instanceof ReflectionClass) {
            throw new \Exception("A instancia precisa ser do tipo ReflectionClass.");
        }

        $this->classProperties = $this->reflectionClass->getProperties();
        
        $getName = function ($property) {
            return $property->name;
        };

        
        $this->classProperties = array_map($getName, $this->classProperties);
        $this->classProperties = transformCamelCaseToSnakeCase($this->classProperties);

        if (!in_array('id', $this->classProperties)) {
            array_unshift($this->classProperties, 'id');
        }
    }

    public function getProperties()
    {
        return $this->classProperties;
    }

    public function getClassName()
    {
        if (!$this->reflectionClass instanceof ReflectionClass) {
            throw new \Exception("A instancia precisa ser do tipo ReflectionClass.");
        }

        $transformedString = preg_replace('/([a-z])([A-Z])/', '$1_$2', basename($this->reflectionClass->getName()));
        $this->className = strtolower($transformedString);

        return $this->className;
    }

    public function setKeysToProperties(array $dataType)
    {
        if (!$this->reflectionClass instanceof ReflectionClass) {
            throw new \Exception("A instancia precisa ser do tipo ReflectionClass.");
        }

        if (count($this->getProperties()) !== count($dataType)) {
            throw new InvalidArgumentException("Os arrays devem ter o mesmo número de elementos.");
        }

        foreach($this->classProperties as $key => &$value) {
            $value = $value . " " . $dataType[$key];
        }
    }

    public function getQuery()
    {
        return $this->sql;
    }

    public function executeQuery()
    {
        if (!$this->reflectionClass instanceof ReflectionClass) {
            throw new \Exception("A instancia precisa ser do tipo ReflectionClass.");
        }

        try{
            return Connect::getInstance()->exec($this->sql);
        }catch(\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createTableQuery()
    {
        if (!$this->reflectionClass instanceof ReflectionClass) {
            throw new \Exception("A instancia precisa ser do tipo ReflectionClass.");
        }

        $params = "(" . implode(", ", $this->classProperties) . ")";
        $this->sql = "CREATE TABLE IF NOT EXISTS " . strtolower($this->getClassName()) . " " . $params ."";
        return $this;
    }

    public function setProperty(string $propName)
    {
        array_push($this->classProperties, $propName);
    }

    public function removeProperty(string $removeValue)
    {
        $key = array_search($removeValue, $this->classProperties);
        if ($key !== false) {
            unset($this->classProperties[$key]);
            $this->classProperties = array_values($this->classProperties);
        }
    }

    public function changeValueOfProperties($key, $value)
    {
        if (array_key_exists($key, $this->classProperties)) {
            $this->classProperties[$key] = $value;
        } else {
            throw new \Exception('Chave do array inexistente.');
        }
    }
}