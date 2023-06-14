<?

use ErrorException;
use Exception;
use PDO;

class DbConnectBuilder  extends PDO
{
    private $connection; //соединение с бд
    private $query;//запрос
    private $operators=['=','>=', '<=', '<', '>', '<>'];//операторы

    public function __construct($config)
    {
        $setdb = $config['driver'] .
            ':host=' . $config['host'] .
            ((!empty($config['port'])) ? (';port=' . $config['port']) : '') .
            ';dbname=' . $config['schema'];
        try {
            $this->connection = new PDO($setdb, $config['username'],$config['password']);
        }
        catch (Exception $e){
            throw new Exception("Connection error! Get more: ", $e->getMessage());
        }
    }

    public function select($request) {
        $this->query='select';
        if ($request==null)  $this->query='select *';
        $this->query = 'select '.$request;
        return $this;
    }

    public function from($request){
        $this->query .= ' from ' . $request;

        return $this;
    }

    public function where($first, $operator, $second){
        if(!in_array($operator, $this->operators)){
            throw new errorException('unexpected operator');
        }
        $this->query .= ' where ' . $first.$operator.$second;

        return $this;
    }

    public function insert($table, $values){
        $this->query = ' insert into ' . $table . ' set ' . $values;

        return $this;
    }

    public function update($table, $values){
        $this->query = ' update '.$table . ' set '. $values . '';
        return $this;
    }

    public function delete($table){
        $this->query = 'delete from ' . $table;
        return $this;
    }

    public function orderBy($column, $type){
        $type?$this->query .= ' order by ' . $column . ' ' . $type : $this->query .= ' order by ' . $column;
        return $this;
    }

    public function limit($num){
       $this->query .= ' limit ' . $num;
        return $this;
    }

    public function execute()
    {
        //dd($this->query);
        try {
            $result = $this->connection->query($this->query . ';');
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
        return $result->fetchAll();
    }
}
