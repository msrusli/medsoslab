<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        $procedure = "DROP PROCEDURE IF EXISTS `splistuser` ;
        CREATE PROCEDURE `splistuser`()
        begin
            select        
            b.id,
            b.username,
            b.firstname,
            b.lastname,
            b.dateofbirth,
            b.phonenumber,
            b.image,
            b.email,
            b.email_verified_at,
            b.remember_token,
            b.created_at,
            b.updated_at,
            count(a.follower_id) as follower  
            from followers as a 
            RIGHT OUTER JOIN users AS b
            ON a.user_id = b.id
            group by             
            b.id,
            b.username,
            b.firstname,
            b.lastname,
            b.dateofbirth,
            b.phonenumber,
            b.image,
            b.email,
            b.email_verified_at,
            b.remember_token,
            b.created_at,
            b.updated_at;
        END";

        DB::unprepared($procedure);


        $procedurebyid = "DROP PROCEDURE IF EXISTS `splistuserbyid` ;
        CREATE PROCEDURE `splistuserbyid`(IN userid VARCHAR(255))
        begin
            select        
            b.id,
            b.username,
            b.firstname,
            b.lastname,
            b.dateofbirth,
            b.phonenumber,
            b.image,
            b.email,
            b.email_verified_at,
            b.remember_token,
            b.created_at,
            b.updated_at,
            count(a.follower_id) as follower  
            from followers as a 
            RIGHT OUTER JOIN users AS b
            ON a.user_id = b.id
            where b.id = userid
            group by             
            b.id,
            b.username,
            b.firstname,
            b.lastname,
            b.dateofbirth,
            b.phonenumber,
            b.image,
            b.email,
            b.email_verified_at,
            b.remember_token,
            b.created_at,
            b.updated_at;
        END";

        DB::unprepared($procedurebyid);        

        $posting = "DROP PROCEDURE IF EXISTS `splistposts` ;
        CREATE PROCEDURE `splistposts`()
        begin
            select        
            b.id,
            b.image,
            b.title,
            b.description,            
            b.created_at,
            b.updated_at,
            count(a.post_id) as comments  
            from comments as a 
            RIGHT OUTER JOIN posts AS b
            ON a.post_id = b.id
            group by             
            b.id,
            b.image,
            b.title,
            b.description,            
            b.created_at,
            b.updated_at; 
        END";

        DB::unprepared($posting);


        $postingbyid = "DROP PROCEDURE IF EXISTS `splistpostsbyid` ;
        CREATE PROCEDURE `splistpostsbyid`(IN postid VARCHAR(255))
        begin
            select        
            b.id,
            b.image,
            b.title,
            b.description,            
            b.created_at,
            b.updated_at,
            count(a.post_id) as comments  
            from comments as a 
            RIGHT OUTER JOIN posts AS b
            ON a.post_id = b.id
            where b.id = postid
            group by             
            b.id,
            b.image,
            b.title,
            b.description,            
            b.created_at,
            b.updated_at;
        END";

        DB::unprepared($postingbyid);   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_post_user_procedure');
    }
};
