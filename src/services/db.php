<?php
namespace services;

class Db{
    private $pdo;
    private static $instanse;

    public static function get_instanse(): self{
        if (self::$instanse === null){
            self::$instanse = new self();

        }
        return self::$instanse;
    }

    private function __construct(){
        $dbOptions=(require __DIR__.'/../settings.php')['db'];
        $this->pdo = new \PDO(
            'mysql:host='.$dbOptions['host'].';
            dbname='.$dbOptions['dbname'].';',
            $dbOptions['user'],
            $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, $params = [], string $className='stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result){
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }


    public function getLastInsertId(): int{



        return 1;
    }
}
?>