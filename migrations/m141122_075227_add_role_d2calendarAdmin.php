<?php

class m141122_075227_add_role_d2calendarAdmin extends EDbMigration
{
	public function up()
	{
        
        $this->execute("        
            REPLACE	 `AuthItem` 
            (`name`, `type`, `description`) 
            VALUES 
            ('d2calendarAdmin', '2', 'd2calendarAdmin'); 
        ");        
	}

	public function down()
	{
        $this->execute("        
            DELETE FROM  `AuthItem` 
            WHERE
             `name` ='d2calendarAdmin';
        ");        
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}