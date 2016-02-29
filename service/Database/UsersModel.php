<?php
namespace Service\Database;

use Service\Pattern\Factory;

class UsersModel
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    protected $db;

    public function __construct()
    {
        $config = require BASE_PATH . '/config/config.php';
        $db = $config['database'];
        $this->db = Factory::createDb($db['username'], $db['password'], $db['dbname'], $db['host'], 'pdo');
    }

    public function migrate()
    {

    }

    public static function findById($id)
    {
        $model = new self;
        $result = $model->db->query("select * from users where id = {$id} limit 1");
        $model->id          = $result[0]['id'];
        $model->name        = $result[0]['name'];
        $model->email       = $result[0]['email'];
        $model->password    = $result[0]['password'];
        $model->created_at  = $result[0]['created_at'];
        $model->updated_at  = $result[0]['updated_at'];
        return $model;
    }

    public function save()
    {
        $data = [
            'name'        => $this->name,
            'email'       => $this->email,
            'password'    => password_hash($this->password, PASSWORD_BCRYPT),
            'created_at'  => date('Y-m-d H:i:s', $this->created_at),
            'updated_at'  => date('Y-m-d H:i:s', $this->updated_at),
        ];

        return $this->db->table('users')->data($data)->save();
    }

}