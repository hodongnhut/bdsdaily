<?php

use yii\db\Migration;

class m251212_100000_create_mailer_config_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%mailer_config}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(128)->notNull(),
            'driver'     => $this->string(50)->notNull(), // 'dsn' hoặc 'array'
            'dsn'        => $this->text(),                // dùng khi driver = dsn
            'host'       => $this->string(255),
            'username'   => $this->string(255),
            'password'   => $this->string(255),
            'port'       => $this->integer(),
            'encryption' => $this->string(20), // tls, ssl, null
            'is_active'  => $this->boolean()->defaultValue(1),
            'priority'   => $this->integer()->defaultValue(0), // càng cao càng ưu tiên
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // Insert 2 config mặc định
        $this->batchInsert('{{%mailer_config}}', [
            'name','driver','dsn','host','username','password','port','encryption','is_active','priority','created_at','updated_at'
        ], [
            [
                'Resend Primary',
                'dsn',
                'smtp://resend:re_GGisktD6_BHH4MRFno1mNtafvcnkscKtx@smtp.resend.com:465',
                null,null,null,null,null,1,100,time(),time()
            ],
            [
                'SMTP2GO Backup',
                'array',
                null,
                'mail.smtp2go.com','nhuthd','qdzpzjtaCgUL4VTW',465,'ssl',1,50,time(),time()
            ],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%mailer_config}}');
    }
}