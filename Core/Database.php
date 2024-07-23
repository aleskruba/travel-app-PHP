<?php
    
    namespace Core;
    use PDO;

class Database 
{
    public $connection;
    public $statement;


    public function __construct($config,$username ='aleskruba',$password='Heslo12345')
    {

  

        $dsn  = ('mysql:'.http_build_query($config,'',';'));
       
      //  $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};password{$config['password']};charset={$config['charset']}";
     
        $this->connection = new PDO($dsn,$username,$password,[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]);
    }
    
    public function query($query,$params=[])
    
    {
        
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);


        return $this;

        }


        public function find() 
    {

        return $this->statement->fetch();
    }
    

        public function findAll() 
    {
   

        return $this->statement->fetchAll();
    }


         public function findOrFail(){
        
            $result = $this->find();

            if (!$result){
                abort();
            } 
            
            return $result;
    }
}