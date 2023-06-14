 <?php
 
 //массив данных для подключения к бд
        $config=array (
            'driver' => 'mysql',//или другая субд
            'host' => 'localhost',
            'port' => '3306',
            'schema' => 'db',
            'username' => 'username',
            'password' => 'password',
        );
        $db=new DbConnectBuilder($config);//объект бд

        //примеры запросов
        $db->select('name, id')->from('users')->where('id','>=', '4')->orderBy('created_at',0)->limit(3);//запрос выдает имена и айди 3х пользовталей, чей айди>=40 и сортирует по дате регистрации
        $db->insert('cities','name=\'Samara\'');//запрос для добавления нового города в таблицу cities
        $db->update('cities','name=\'Orenburg\'')->where('name','=','Samara');//запрос для обновления города в таблице cities
        $db->delete('cities')->where('name','=','Samara');//запрос для удаления города в таблице cities

        $res=$db->execute();//выполнение запроса
		echo($res);
		
>