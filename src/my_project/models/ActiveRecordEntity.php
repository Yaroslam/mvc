<?php
namespace my_project\models;
use services\Db;

abstract class ActiveRecordEntity{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }
    public function __set($name, $value){
            $camelCase=$this->underscoreToCamelCase($name);
            $this->$camelCase=$value;
        }

        public function underscoreToCamelCase(string $source): string{
            return lcfirst(str_replace('_', '', ucwords($source, '_')));
        }

        public static function findAll() :array
        {
            $db=Db::get_instanse();
            return $db->query('SELECT * FROM `'.static::getTableName().'`;', [], static::class);
        }

        public static function getById(int $id) :? self
        {
            $db=Db::get_instanse();
            $entities=$db->query
            ('SELECT * FROM `'.static::getTableName().'` WHERE id=:id',
             [':id'=>$id], static::class);
             return $entities ? $entities[0] : null;
        }

        private function camel_case_to_underscore(string $Camel_case): string{
            $pregraples = preg_replace('/(?<!^)[A-Z]/', '_$0', $Camel_case);
            return strtolower($pregraples);
        }

        public function insert(array $map_properties): void{
            $filtredproperties = array_filter($map_properties);

            $columns = [];
            $param_names = [];
            $param_to_values = [];

            foreach ($filtredproperties as $colmn_name => $value){
                $columns[] = '`'.$colmn_name.'`';
                $param_name = ':'.$colmn_name;
                $param_names[] = $param_name;
                $param_to_values[$param_name] = $value;
            }

            $colunm_via_semicolumn = implode(', ', $columns);
            $param_names_via_semicolumn = implode(', ', $param_names);

            $sql = 'INSERT INTO '.static::getTableName().' ('.$colunm_via_semicolumn.') VALUES ('.$param_names_via_semicolumn;

            $db = Db::get_instanse();
            $db->query($sql, $param_to_values, static::class);
            $this->id = $db->getLastInsertId();
            $this->createdAt->getById($this->id)->getCreatedAt();

        }

        public function update(array $map_properties): void
        {
            $columns_to_params = [];
            $params_to_values = [];
            $index = 1;

            foreach ($map_properties as $column => $value) {
                $param = ':param' . $index;
                $columns_to_params[] = $column . '=' . $param;
                $params_to_values[$param] = $value;
                $index++;
            }
            $sql = 'UPDATE ' . static::getTableName() . ' SET' . implode(', ', $columns_to_params).
                ' WHERE id '.$this->id;
            $db = Db::get_instanse();
            $db->query($sql, $params_to_values, static::class);
        }

        public function delete(): void {
            $sql = 'DELETE FROM '. static::getTableName().' WHERE id = '.$this->id;;
            $db = Db::get_instanse();;
            $db->query($sql);
        }

        public function save(): void{
            $map_properties = $this->map_propirties_to_db_format();
            if($this->id === null){
                $this->update($map_properties);
            } else{
                $this->insert($map_properties);
            }
        }


        private function map_propirties_to_db_format() :array{
            $mapped_properties = [];
            $reflector = new \ReflectionObject($this);
            $properties = $reflector->getProperties();
            foreach ($properties as $properti){
                $properti_name = $properti->getName();
                $propetri_name_underscore = $this->camel_case_to_underscore($properti_name);
                $mapped_properties[$propetri_name_underscore] = $this->$properti_name;
            }
            return $mapped_properties;
        }

        abstract protected static function getTableName() :string;
        

    }
    
?>