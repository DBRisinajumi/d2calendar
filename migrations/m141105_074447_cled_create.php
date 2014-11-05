<?php

class m141105_074447_cled_create extends EDbMigration {

    public function up() {
        $this->execute("        
            CREATE TABLE `cled_calendar_exception_dates` (
                `cled_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
                `cled_date` date NOT NULL,
                `cled_type` enum('Working Day','Holliday','Public Holliday') NOT NULL,
                `cled_notes` tinytext,
                PRIMARY KEY (`cled_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }

    public function down() {
        $this->execute("        
            DROP TABLE `cled_calendar_exception_dates`;
        ");
        return false;
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
