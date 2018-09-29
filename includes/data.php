<?php
/*
Name: DATA
Description: Definition file for Holograph Emulator
Type: Server Definition
Author: Yifan Lu
Version: 1.0
Compatibility: 4.0.5
*/

//You may delete the installer_sql(); class after installing
/*
class installer_sql {
	function alter1(){
		@$GLOBALS['serverdb']->query("ALTER TABLE `groups_details` CHANGE COLUMN `description` `description` text CHARACTER SET utf8 NOT NULL, CHANGE COLUMN `type` `type` tinyint(1) NOT NULL DEFAULT '0', ADD COLUMN `forumtype` tinyint(1) NOT NULL, ADD COLUMN `forumpremission` tinyint(1) NOT NULL, CHANGE COLUMN `views` `views` int(15) NOT NULL, ADD COLUMN `alias` varchar(30) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `alias`);");
		@$GLOBALS['serverdb']->query("ALTER TABLE `users` AUTO_INCREMENT=100");
		@$GLOBALS['serverdb']->query("ALTER TABLE `groups_details` AUTO_INCREMENT=100");
		@$GLOBALS['serverdb']->query("ALTER TABLE `users` ADD COLUMN `hc_before` tinyint(1) NULL DEFAULT '0'");
	}
	function delete1(){
		@$GLOBALS['serverdb']->query("TRUNCATE TABLE users");
	}
	function insert1($username,$password){
		$GLOBALS['serverdb']->query("INSERT INTO users (name,password,rank,email,birth,hbirth,figure,sex,mission,credits) VALUES ('".$username."','".$password."','7','".$email."','1-1-1900','".date('d-m-Y')."','hd-180-1.ch-210-66.lg-270-82.sh-290-80.hr-105-42','M','Hotel Administrator','1000')");
	}
	function insert2($id,$username,$email){
		$GLOBALS['serverdb']->query("INSERT INTO ".PREFIX."users (id,name,ipaddress_last,lastvisit,online,newsletter,email_verified,show_home,email_friendrequest,email_minimail,show_online,email) VALUES ('".$id."','".$username."','".$_SERVER['REMOTE_ADDR']."','".time()."','".time()."','1','1','1','1','1','1','".$email."')");
	}
	function select1(){
		$sql = $GLOBALS['serverdb']->query("SELECT 'passed' AS `test` FROM system LIMIT 1 #Test query to see if a valid Holograph database exists. If you are seeing this, read the red text below.");
		return $sql;
	}
}
*/
class core_sql {
	function select1($id){
		if(is_numeric($id)){ $sql = $GLOBALS['serverdb']->query("SELECT password,username FROM users WHERE id = '".$id."' LIMIT 1"); }else{ $sql = $GLOBALS['serverdb']->query("SELECT password,id FROM users WHERE username = '".$id."' LIMIT 1"); }
		return $sql;
	}
	function select2($id){
		$sql = $GLOBALS['serverdb']->query("SELECT ban_reason,ban_expire FROM bans WHERE user_id = '".$id."' OR ip = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1");
		return $sql;
	}
	function delete1($id){
		$GLOBALS['serverdb']->query("DELETE FROM bans WHERE user_id = '".$id."' OR ip = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1");
	}
	function select3($id) {
		$sql = $GLOBALS['serverdb']->query("SELECT id,username,password,rank,'null' AS mail,account_day_of_birth,look,gender,motto,credits,points,auth_ticket,0 AS pixels,account_day_of_birth FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function select4($strName){
		if(is_numeric($strName)){
			$sql = $GLOBALS['serverdb']->query("SELECT id FROM users WHERE id = '".$strName."' AND badge_status = '1' LIMIT 1");
		} else {
			$sql = $GLOBALS['serverdb']->query("SELECT id FROM users WHERE username = '".$strName."' AND badge_status = '1' LIMIT 1");
		}
		return $sql;
	}
	function select5($id){
		$sql = $GLOBALS['serverdb']->query("SELECT badge_code,slot_id FROM users_badges WHERE user_id = '".$id."' AND slot_id = '1' LIMIT 1");
		return $sql;
	}
	function select6($id){
		$sql = $GLOBALS['serverdb']->query("SELECT guild_id FROM guilds_members WHERE user_id = '".$id."' AND level_id < '3' LIMIT 1");
		return $sql;
	}
	function select7($id){
		$sql = $GLOBALS['serverdb']->query("SELECT badge FROM guilds WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	/* function select8($id){
		$sql = $GLOBALS['serverdb']->query("SELECT months_left,date_monthstarted FROM users_club WHERE userid = '".$id."' LIMIT 1");
		return $sql;
	}
	function select9($id){
	    $sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM users_club WHERE userid = '".$id."' LIMIT 1");
		return $sql;
	}
	function update2($id){
		$GLOBALS['serverdb']->query("UPDATE users SET badge_status = '0', hc_before = '1' WHERE id = '".$id."' LIMIT 1");
		$GLOBALS['serverdb']->query("UPDATE users SET rank = '1' WHERE id = '".$id."' AND rank = '2' LIMIT 1");
		$GLOBALS['serverdb']->query("DELETE FROM users_badges WHERE badgeid = 'HC1' OR badgeid = 'HC2' AND userid = '".$id."'");
		$GLOBALS['serverdb']->query("DELETE FROM users_club WHERE userid = '".$id."'");
	}
	function update3($id, $months){
		$GLOBALS['serverdb']->query("UPDATE users SET rank = '2' WHERE rank = '1' AND id = '".$id."' LIMIT 1");
		$GLOBALS['serverdb']->query("UPDATE users_club SET months_left = months_left + ".$months." WHERE userid = '".$id."' LIMIT 1");
	}
	function select11($id){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM users_badges WHERE (badgeid = 'HC1' OR badgeid = 'HC2') AND userid = '".$id."' LIMIT 1");
		return $sql;
	}
	function update4($id){
		$GLOBALS['serverdb']->query("UPDATE users SET badge_status = '0' WHERE id = '".$id."' LIMIT 1");
		$GLOBALS['serverdb']->query("UPDATE users_badges SET iscurrent = '0' WHERE userid = '".$id."'");
		$GLOBALS['serverdb']->query("INSERT INTO users_badges (userid,badgeid,iscurrent) VALUES ('".$id."','HC1','1')");
	}
	function insert1($id, $date){
		$GLOBALS['serverdb']->query("INSERT INTO users_club (userid,date_monthstarted,months_expired,months_left) VALUES ('".$id."','".$date."','0','0')");
	}
	*/
	function update5($ticket, $id){
		$GLOBALS['serverdb']->query("UPDATE users SET auth_ticket = '".$ticket."' WHERE id = '".$id."' LIMIT 1");
	}
	function select14(){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM users WHERE online = '1'");
		return $sql;
	}
	function update6($id,$time){
		$GLOBALS['serverdb']->query("UPDATE users SET last_login = '".$time."', ip_current = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$id."' LIMIT 1");
	}
}
class index_sql {
	function select1($username, $password){
		$sql = $GLOBALS['serverdb']->query("SELECT users.id FROM users,".PREFIX."users WHERE ".PREFIX."users.id = users.id AND users.username = '".$username."' AND users.password = '".$password."' LIMIT 1");
		return $sql;
	}
	function select2($id){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM ".PREFIX."users WHERE id = '".$id."' AND email_verified = '1'");
		return $sql;
	}
	function select3($id){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM bans WHERE user_id = '".$id."'");
		return $sql;
	}
}
class forgot_sql {
	function update1($id, $password){
		$GLOBALS['serverdb']->query("UPDATE users SET password = '".$password."' WHERE id = '".$id."'");
	}
}
class register_sql {
	function select1($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,username,look FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function select2($name){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM users WHERE username = '".$name."'");
		return $sql;
	}
	function insert1($name,$password,$dob,$figure,$scredits){
		$date = HoloDate();
		$GLOBALS['serverdb']->query("INSERT INTO users (username,password,account_day_of_birth,look,account_created,credits) VALUES ('".$name."','".$password."','".$dob."','".$figure."','".$date['date_normal']."','".$scredits."')");
	}
	function update1($id,$credits){
		$GLOBALS['serverdb']->query("UPDATE users SET credits = credits + ".$credits." WHERE id = '".$id."'");
	}
	function insert2($userid,$friendid){
		$GLOBALS['serverdb']->query("INSERT INTO messenger_friendships (user_one_id,user_two_id) VALUES ('".$userid."','".$friendid."')");
	}
	function select3($name){
		$sql = $GLOBALS['serverdb']->query("SELECT id,username FROM users WHERE username = '".$name."' LIMIT 1");
		return $sql;
	}
}
class welcome_sql {
	function select1($id){
		$sql = $GLOBALS['serverdb']->query("SELECT username,look FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
}
class me_sql {
	/*
	function select1($id){
		$sql = $GLOBALS['serverdb']->query("SELECT hc_before FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	*/
	function select3($id){
		$sql = $GLOBALS['serverdb']->query("SELECT user_from_id FROM messenger_friendrequests WHERE user_to_id = '".$id."'");
		return $sql;
	}
	function select4($cutoff, $id){
		$sql = $GLOBALS['serverdb']->query("SELECT DISTINCT ".PREFIX."users.name FROM ".PREFIX."users,messenger_friendships WHERE ".PREFIX."users.online > '".$cutoff."' AND (messenger_friendships.user_one_id = '".$id."' OR messenger_friendships.user_two_id = '".$id."') AND messenger_friendships.user_one_id = ".PREFIX."users.id AND ".PREFIX."users.id != '".$id."'");
		return $sql;
	}
	function select8($name){
		$sql = $GLOBALS['serverdb']->query("SELECT users.username,users.look,users.id,".PREFIX."users.lastvisit FROM users,".PREFIX."users WHERE users.username LIKE '%".$name."%' AND users.id = ".PREFIX."users.id ORDER BY name ASC");
		return $sql;
	}
	function select9($name, $limit, $offset){
		$sql = $GLOBALS['serverdb']->query("SELECT users.username,users.look,users.id,".PREFIX."users.lastvisit FROM users,".PREFIX."users WHERE users.username LIKE '%".$name."%' AND users.id = ".PREFIX."users.id ORDER BY name ASC LIMIT ".$limit." OFFSET ".$offset);
		return $sql;
	}
	function select10($id, $id2){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM messenger_friendships WHERE (user_one_id = '".$id."' AND user_one_id = '".$id2."') OR (user_one_id = '".$id2."' AND user_two_id = '".$id."')");
		return $sql;
	}
	function select11($id, $id2){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM messenger_friendrequests WHERE (user_to_id = '".$id."' AND user_from_id = '".$id2."') OR (user_to_id = '".$id2."' AND user_from_id = '".$id."')");
		return $sql;
	}
	function select12($id){
		$sql = $GLOBALS['serverdb']->query("SELECT MAX(id) FROM messenger_friendrequests WHERE user_to_id = '".$id."'");
		return $sql;
	}
	function insert1($id, $id2, $requestid){
		$GLOBALS['serverdb']->query("INSERT INTO messenger_friendrequests (user_from_id,user_to_id,id) VALUES ('".$id."','".$id2."','".$requestid."')");
	}
	/*
	function select13($roomid){
		$sql = $GLOBALS['serverdb']->query("SELECT rooms.visitors_now,rooms.visitors_max,users.name FROM rooms,users WHERE rooms.id = '".$roomid."' AND rooms.owner = users.name LIMIT 1");
		return $sql;
	}
	*/
	function select14($id){
		$sql = $GLOBALS['serverdb']->query("SELECT guilds_members.guild_id,guilds.name FROM guilds_members,guilds WHERE guilds_members.user_id = '".$id."' AND guilds_members.level_id < '3' AND guilds_members.guild_id = guilds.id");
		return $sql;
	}
	function select16(){
		$sql = $GLOBALS['serverdb']->query("SELECT rooms.id,rooms.name,rooms.description,rooms.owner_id,rooms.users,rooms.users_max,rooms.description FROM ".PREFIX."recommended,rooms WHERE ".PREFIX."recommended.type = 'room' AND ".PREFIX."recommended.rec_id = rooms.id ORDER BY ".PREFIX."recommended.id ASC");
		return $sql;
	}
	function select17($limit = 0,$offset = 0){
		$sql = "SELECT guilds.id,guilds.name,guilds.badge,COUNT(*) AS count FROM guilds,guilds_members WHERE guilds.id = guilds_members.guild_id AND level_id < '3' GROUP BY guilds_members.guild_id ORDER BY count DESC";
		if($limit > 0){ $sql = $sql." LIMIT ".$limit; }
		if($offset > 0){ $sql = $sql." OFFSET ".$offset; }
		$sql = $GLOBALS['serverdb']->query($sql);
		return $sql;
	}
	function select18($id){
		$sql = $GLOBALS['serverdb']->query("SELECT guilds.id,guilds.name,guilds.badge FROM guilds,guilds_members WHERE guilds.id = guilds_members.guild_id AND guilds_members.level_id < '3' AND guilds_members.user_id = '".$id."' ORDER BY guilds.id ASC");
		return $sql;
	}
	function update1($id, $motto){
		$GLOBALS['serverdb']->query("UPDATE users SET motto = '".$motto."' WHERE id = '".$id."' LIMIT 1");
	}
	function select5($id){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM messenger_friendships WHERE user_one_id = '".$id."' OR user_two_id = '".$id."'");
		return $sql;
	}
	function select6($id){
		$sql = $GLOBALS['serverdb']->query("SELECT username,id,look FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function select7($id){
		$sql = $GLOBALS['serverdb']->query("SELECT user_one_id,user_two_id FROM messenger_friendships WHERE user_one_id = '".$id."' OR user_two_id = '".$id."'");
		return $sql;
	}
	function select15($sponsered){
		$sql = $GLOBALS['serverdb']->query("SELECT guilds.id,guilds.name,guilds.badge,guilds.room_id FROM ".PREFIX."recommended,guilds WHERE ".PREFIX."recommended.type = 'group' AND ".PREFIX."recommended.rec_id = guilds.id AND ".PREFIX."recommended.sponsered = '".$sponsered."' ORDER BY ".PREFIX."recommended.id ASC");
		return $sql;
	}
	function delete1($id, $id2){
		$GLOBALS['serverdb']->query("DELETE FROM messenger_friendships WHERE user_one_id = '".$id."' AND user_two_id = '".$id2."' LIMIT 1");
	}
	// To enable events, follow the instructions provided and delete the function below and replace it with the commented function select19
	function select19($category){
		$sql = $GLOBALS['serverdb']->query("SELECT id FROM rooms WHERE id = '0'");
		return $sql;
	}
	/*
	function select19($category){
		$sql = $GLOBALS['serverdb']->query("SELECT id,name,description,userid,roomid,category,date FROM events WHERE category = '".$category."'");
		return $sql;
	}
	*/
}
class header_footer_sql {
	function select1($mode, $id, $name, $timeout = 0){
		switch($mode){
			case 1:
				if($timeout != null){
					if($timeout > 0){
						$online = " AND ((".PREFIX."users.online + ".$timeout.") >= ".time().")";
					}else{
						$timeout = (int) str_replace("-","",$timeout);
						$online = " AND ((".PREFIX."users.online + ".$timeout.") <= ".time().")";
					}
				}
				$sql = $GLOBALS['serverdb']->query("SELECT users.id,users.username FROM messenger_friendships,users,".PREFIX."users WHERE (messenger_friendships.user_one_id = '".$id."' AND users.id = messenger_friendships.user_two_id AND users.id = ".PREFIX."users.id) OR (messenger_friendships.user_two_id = '".$id."' AND users.id = messenger_friendships.user_one_id AND users.id = ".PREFIX."users.id)".$online." ORDER BY users.id ASC");
				break;
			case 2:
				$sql = $GLOBALS['serverdb']->query("SELECT guilds.id,guilds.name,guilds_members.level_id,guilds.user_id,guilds.room_id,guilds_members.favourite FROM guilds_members,guilds WHERE guilds_members.user_id = '".$id."' AND guilds_members.level_id < '3' AND guilds_members.guild_id = guilds.id ORDER BY guilds.rights ASC");
				break;
			case 3:
				$sql = $GLOBALS['serverdb']->query("SELECT id,name FROM rooms WHERE owner_name  = '".$name."' ORDER BY name ASC");
				break;
			case 4:
				$sql = $GLOBALS['serverdb']->query("SELECT users.id,users.username FROM messenger_friendships,users,".PREFIX."users WHERE (messenger_friendships.user_one_id = '".$id."' AND users.id = messenger_friendships.user_two_id = ".PREFIX."users.id) OR (messenger_friendships.user_two_id = '".$id."' AND users.id = messenger_friendships.user_one_id = ".PREFIX."users.id) AND ((".PREFIX."users.online + ".$timeout.") < ".time().") ORDER BY users.id ASC");
				break;
		}
		return $sql;
	}
}
/*
class group_purchase_sql {
	function select1($name){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM groups_details WHERE name = '".$name."' LIMIT 1");
		return $sql;
	}
	function insert1($name, $desc, $id, $date){
		$GLOBALS['serverdb']->query("INSERT INTO groups_details (name,description,ownerid,created,badge,type,forumtype,forumpremission,alias) VALUES ('".$name."','".$desc."','".$id."','".$date."','b0503Xs09114s05013s05015','0','0','0','')");
	}
	function select2($ownerid,$name){
		$sql = $GLOBALS['serverdb']->query("SELECT id FROM groups_details WHERE ownerid = '".$ownerid."' AND name = '".$name."' ORDER BY id DESC LIMIT 1");
		return $sql;
	}
	function insert2($userid, $groupid){
		$GLOBALS['serverdb']->query("INSERT INTO groups_memberships (userid,groupid,member_rank,is_current) VALUES ('".$userid."','".$groupid."','3','0')");
		$GLOBALS['serverdb']->query("UPDATE users SET credits = credits - 10 WHERE id = '".$userid."' LIMIT 1");
	}
}
*/
class xml_sql {
	function select1(){
		$sql = $GLOBALS['serverdb']->query("SELECT users.id,users.username,users.motto,users.look,users.gender FROM users,".PREFIX."users WHERE users.id = ".PREFIX."users.id ORDER BY ".PREFIX."users.online DESC LIMIT 10");
		return $sql;
	}
}
class profile_sql {
	function update1($figure,$gender,$id){
		$GLOBALS['serverdb']->query("UPDATE users SET look = '".$figure."', gender = '".$gender."' WHERE id = '".$id."' LIMIT 1");
	}
	function update2($motto,$id){
		$GLOBALS['serverdb']->query("UPDATE users SET motto = '".$motto."' WHERE id = '".$id."' LIMIT 1");
	}
	function update4($password,$id){
		$GLOBALS['serverdb']->query("UPDATE users SET password = '".$password."' WHERE id = '".$id."'");
	}
	function select1($id,$search = "",$limit = "",$offset = "0"){
		if($search == ""){
			$sql = "SELECT messenger_friendships.user_one_id,messenger_friendships.user_two_id,users.id,users.username,".PREFIX."users.lastvisit FROM messenger_friendships,users,".PREFIX."users WHERE (messenger_friendships.user_two_id = '".$id."' AND (messenger_friendships.user_one_id = users.id AND users.id = ".PREFIX."users.id))";
		}else{
			$sql = "SELECT messenger_friendships.user_one_id,messenger_friendships.user_two_id,users.id,users.username,".PREFIX."users.lastvisit FROM messenger_friendships,users,".PREFIX."users WHERE ((messenger_friendships.user_one_id = '".$id."' AND (messenger_friendships.user_two_id = users.id AND users.id = ".PREFIX."users.id)) OR (messenger_friendships.user_two_id = '".$id."' AND (messenger_friendships.user_one_id = users.id AND users.id = ".PREFIX."users.id))) AND users.username LIKE '%".$search."%'";
		}
		if($limit != ""){ $sql = $sql." LIMIT ".$limit." OFFSET ".$offset.""; }
		$sql = $GLOBALS['serverdb']->query($sql);
		return $sql;
	}
	function delete1($id,$myid){
		$sql = $GLOBALS['serverdb']->query("DELETE FROM messenger_friendships WHERE (user_one_id = '".$myid."' AND user_two_id = '".$id."') OR (user_two_id = '".$myid."' AND user_one_id = '".$id."') LIMIT 1");
	}
}
class community_sql {
	function select1($limit,$offset){
		  $sql = $GLOBALS['serverdb']->query("SELECT id,name,description,owner_id,owner_name,users,users_max FROM rooms WHERE owner_id IS NOT NULL ORDER BY users DESC LIMIT ".$limit." OFFSET ".$offset);
		return $sql;
	}
	function select2($limit,$offset){
		$sql = $GLOBALS['serverdb']->query("SELECT rooms.id,rooms.name,rooms.description,rooms.owner_name,rooms.users,rooms.users_max,rooms.name,COUNT(room_votes.room_id) AS room_id FROM rooms,room_votes WHERE rooms.owner_name IS NOT NULL AND room_votes.room_id = rooms.id GROUP BY rooms.id ORDER BY room_id DESC LIMIT ".$limit." OFFSET ".$offset);
		return $sql;
	}
	function select3(){
		$sql = $GLOBALS['serverdb']->query("SELECT id,username,account_created,motto,look FROM users ORDER BY RAND() LIMIT 18");
		return $sql;
	}
	function select4($name){
		$sql = $GLOBALS['serverdb']->query("SELECT id FROM users WHERE username = '".$name."' LIMIT 1");
		return $sql;
	}
	function select5($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,username,motto,look FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function select6($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,name,description,badge FROM guilds WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
}
/* class credits_sql {
	function update1($id,$credits){
		$GLOBALS['serverdb']->query("UPDATE users SET credits = '".$credits."' WHERE id = '".$id."' LIMIT 1");
	}
	function insert1($id,$furni){
		$GLOBALS['serverdb']->query("INSERT INTO furniture (tid,ownerid,roomid,x,y,z,h) VALUES ('".$furni."','".$id."','0','0','0','0','0')");
	}
	function select1($month){
		$sql = $GLOBALS['serverdb']->query("SELECT catalogue_items.catalogue_name,".PREFIX."gifts.image FROM catalogue_items,".PREFIX."gifts WHERE ".PREFIX."gifts.furni_id = catalogue_items.tid AND ".PREFIX."gifts.type = 'club' AND ".PREFIX."gifts.month = '".$month."' LIMIT 1");
		return $sql;
	}
	function select2($id){
		$sql = $GLOBALS['serverdb']->query("SELECT months_left FROM users_club WHERE userid = '".$id."' LIMIT 1");
		return $sql;
	}
	function update2($figure,$gender,$id){
		$GLOBALS['serverdb']->query("UPDATE users SET figure = '".$figure."', sex = '".$gender."' WHERE id = '".$id."' LIMIT 1");
	}
	function select3($date){
		$sql = $GLOBALS['serverdb']->query("SELECT catalogue_items.catalogue_name,catalogue_items.catalogue_description,".PREFIX."collectables.image_large,catalogue_items.tid FROM catalogue_items,".PREFIX."collectables WHERE ".PREFIX."collectables.furni_id = catalogue_items.tid AND ".PREFIX."collectables.date = '".$date."' LIMIT 1");
		return $sql;
	}
	function select4($date){
		$sql = $GLOBALS['serverdb']->query("SELECT catalogue_items.catalogue_name,catalogue_items.catalogue_description,".PREFIX."collectables.image_small,".PREFIX."collectables.date FROM catalogue_items,".PREFIX."collectables WHERE ".PREFIX."collectables.furni_id = catalogue_items.tid AND ".PREFIX."collectables.date < '".$date."' ORDER BY ".PREFIX."collectables.date DESC");
		return $sql;
	}
	function select5($voucher){
		$sql = $GLOBALS['serverdb']->query("SELECT type,credits FROM vouchers WHERE voucher = '".$voucher."' LIMIT 1");
		return $sql;
	}
	function delete1($voucher){
		$GLOBALS['serverdb']->query("DELETE FROM vouchers WHERE voucher = '".$voucher."' LIMIT 1");
	}
}
*/

class home_sql {
	function select1($name){
		$sql = $GLOBALS['serverdb']->query("SELECT id FROM users WHERE username = '".$name."' LIMIT 1");
		return $sql;
	}
	function select2($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,username,rank,account_day_of_birth,look,motto,badge_status FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function update1($id,$credits){
		$GLOBALS['serverdb']->query("UPDATE users SET credits = '".$credits."' WHERE id = '".$id."' LIMIT 1");
	}
	function select3($query,$scope){
		switch($scope){
			case 1: $sql = $GLOBALS['serverdb']->query("SELECT id,username FROM users WHERE username LIKE '%".$query."%' LIMIT 5"); break;
			case 2: $sql = $GLOBALS['serverdb']->query("SELECT id,name FROM rooms WHERE name LIKE '%".$query."%' LIMIT 5"); break;
			case 3: $sql = $GLOBALS['serverdb']->query("SELECT id,name FROM guilds WHERE name LIKE '%".$query."%' OR user_id LIKE '%".$query."%' LIMIT 5"); break;
		}
		return $sql;
	}
	function select4($myid,$friendid){
		$sql = $GLOBALS['serverdb']->query("SELECT user_one_id,user_two_id FROM messenger_friendships WHERE (user_one_id = '".$myid."' AND user_two_id = '".$friendid."') OR (user_one_id = '".$friendid."' AND user_two_id = '".$myid."')");
		return $sql;
	}
	function select5($myid,$friendid){
		$sql = $GLOBALS['serverdb']->query("SELECT userid_from,userid_to FROM messenger_friendrequests WHERE (userid_from = '".$myid."' AND userid_to = '".$friendid."') OR (userid_from = '".$friendid."' AND userid_to = '".$myid."')");
		return $sql;
	}
	function insert1($myid,$friendid){
		$GLOBALS['serverdb']->query("INSERT INTO messenger_friendrequests (userid_from,userid_to) VALUES ('".$myid."','".$friendid."')");
	}
	function select6($id){
		$sql = $GLOBALS['serverdb']->query("SELECT bb_totalpoints,bb_playedgames FROM users WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function select7($id){
		$sql = $GLOBALS['serverdb']->query("SELECT badge_code FROM users_badges WHERE user_id = '".$id."'");
		return $sql;
	}
	function select8($id,$search="",$limit=0,$offset=0){
		$sql = "SELECT users.id,users.username,users.look,users.account_day_of_birth FROM users,messenger_friendships WHERE (user_one_id = '".$id."' AND messenger_friendships.user_two_id = users.id)";
		if($search != ""){ $sql = $sql." AND users.username LIKE '%".$search."%'"; }
		if($limit > 0){ $sql = $sql." LIMIT ".$limit; }
		if($offset > 0){ $sql = $sql." OFFSET ".$offset; }
		$sql = $GLOBALS['serverdb']->query($sql);
		return $sql;
	}
	function select9($id){
		$sql = $GLOBALS['serverdb']->query("SELECT badge_code FROM users_badges WHERE user_id = '".$id."' AND slot_id = '1' LIMIT 1");
		return $sql;
	}
	function select10($id){
		$sql = $GLOBALS['serverdb']->query("SELECT guilds.id,guilds.badge,guilds.name,guilds.description,guilds.date_created,guilds.state,guilds_members.level_id,guilds.user_id FROM guilds,guilds_members WHERE guilds_members.guild_id = guilds.id AND guilds_members.user_id = '".$id."' AND guilds_members.level_id < '3' LIMIT 1");
		return $sql;
	}
	function select11($id){
		$sql = $GLOBALS['serverdb']->query("SELECT rooms.id,rooms.name,rooms.description,rooms.state FROM rooms,users WHERE users.username = rooms.owner_name AND users.id = '".$id."'");
		return $sql;
	}
	function select12($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,title FROM soundmachine_songs WHERE userid = '".$id."'");
		return $sql;
	}
	function select13($id){
		$sql = $GLOBALS['serverdb']->query("SELECT data,title,userid FROM soundmachine_songs WHERE id = '".$id."'");
		return $sql;
	}
	function select14($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,badge,name,description,date_created,user_id,room_id,state FROM guilds WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function select15($userid,$groupid){
		$sql = $GLOBALS['serverdb']->query("SELECT user_id,guild_id,level_id,favourite FROM guilds_members WHERE user_id = '".$userid."' AND guild_id = '".$groupid."' LIMIT 1");
		return $sql;
	}
	function update2($userid,$groupid,$favorite){
		$GLOBALS['serverdb']->query("UPDATE guilds_members SET favourite = '0' WHERE user_id = '".$userid."' LIMIT 1");
		$GLOBALS['serverdb']->query("UPDATE guilds_members SET favourite = '".$favorite."' WHERE guild_id = '".$groupid."' AND user_id = '".$userid."' AND favourite = '0' LIMIT 1");
	}
	function insert2($userid,$groupid,$pending,$rank){
		$GLOBALS['serverdb']->query("INSERT INTO groups_memberships (userid,groupid,member_rank,is_current,is_pending) VALUES ('".$userid."','".$groupid."','".$rank."','0','".$pending."')");
	}
	function delete1($userid,$groupid){
		$GLOBALS['serverdb']->query("DELETE FROM groups_memberships WHERE userid = '".$userid."' AND groupid = '".$groupid."' LIMIT 1");
	}
	function select16($id,$search="",$limit=0,$offset=0,$pending=0){
		$sql = "SELECT guilds_members.user_id,guilds_members.level_id,users.username,users.look,users.account_day_of_birth FROM guilds_members,users WHERE users.id = guilds_members.user_id AND guilds_members.guild_id = '".$id."' AND guilds_members.level_id = '".$pending."'";
		if($search != ""){ $sql .= " AND users.username LIKE '%".$search."%'"; }
		$sql .= " ORDER BY guilds_members.level_id ASC";
		if($limit > 0){ $sql .= " LIMIT ".$limit; }
		if($offset > 0){ $sql .= " OFFSET ".$offset; }
		$sql = $GLOBALS['serverdb']->query($sql);
		return $sql;
	}
	function select17($id){
		$sql = $GLOBALS['serverdb']->query("SELECT id,name,description FROM rooms WHERE id = '".$id."' LIMIT 1");
		return $sql;
	}
	function update3($id,$name,$description,$type,$url,$forumtype,$forumpremissions,$roomid){
		$GLOBALS['serverdb']->query("UPDATE groups_details SET name = '".$name."', description = '".$description."', type = '".$type."', alias = '".$url."', forumtype = '".$forumtype."', forumpremission = '".$forumpremissions."', roomid = '".$roomid."' WHERE id = '".$id."' LIMIT 1");
	}
	function select18($alias){
		$sql = $GLOBALS['serverdb']->query("SELECT id FROM guilds WHERE user_id = '".$alias."' LIMIT 1");
		return $sql;
	}
	function update4($userid,$groupid,$rank,$pending){
		$GLOBALS['serverdb']->query("UPDATE groups_memberships SET member_rank = '".$rank."', is_pending = '".$pending."' WHERE userid = '".$userid."' AND groupid = '".$groupid."' LIMIT 1");
	}
	function update5($id,$badge){
		$GLOBALS['serverdb']->query("UPDATE guilds SET badge = '".$badge."' WHERE id = '".$id."' LIMIT 1");
	}
	function delete2($groupid){
		$GLOBALS['serverdb']->query("DELETE FROM groups_details WHERE id = '".$groupid."' LIMIT 1");
		$GLOBALS['serverdb']->query("DELETE FROM groups_memberships WHERE groupid = '".$groupid."'");
	}
}
class housekeeping_sql {
	function select1(){
		$sql = $GLOBALS['serverdb']->query("SELECT COUNT(*) FROM furniture UNION SELECT COUNT(*) FROM groups_details UNION SELECT COUNT(*) FROM rooms UNION SELECT COUNT(*) FROM users UNION SELECT COUNT(*) FROM users_bans");
		return $sql;
	}
	function select2(){
		$sql = $GLOBALS['serverdb']->query("SELECT onlinecount FROM system UNION SELECT activerooms FROM system");
		return $sql;
	}
	function select3($rank){
		$sql = $GLOBALS['serverdb']->query("SELECT id,name,rank FROM users WHERE rank >= '".$rank."' ORDER BY rank DESC, name ASC");
		return $sql;
	}
	function select4($limit,$offset,$roomid=null){
		if(!empty($roomid)){ $where = " WHERE roomid = '".$roomid."'"; }
		$sql = $GLOBALS['serverdb']->query("SELECT username,roomid,mtime,message FROM system_chatlog".$where." ORDER BY mtime DESC LIMIT ".$limit." OFFSET ".$offset);
		return $sql;
	}
	function select5(){
		$sql = $GLOBALS['serverdb']->query("SELECT ".PREFIX."collectables.id,".PREFIX."collectables.image_small,".PREFIX."collectables.image_large,".PREFIX."collectables.date,catalogue_items.catalogue_name,".PREFIX."collectables.furni_id FROM ".PREFIX."collectables,catalogue_items WHERE ".PREFIX."collectables.furni_id = catalogue_items.tid ORDER BY ".PREFIX."collectables.date DESC");
		return $sql;
	}
	function select6($query){
		$sql = $GLOBALS['serverdb']->query("SELECT tid,catalogue_name FROM catalogue_items WHERE catalogue_name LIKE '%".$query."%' OR catalogue_description LIKE '%".$query."%' OR name_cct LIKE '%".$query."%' LIMIT 50");
		return $sql;
	}
	function select7($query){
		$sql = $GLOBALS['serverdb']->query("SELECT id,name FROM rooms WHERE name LIKE '%".$query."%' OR description LIKE '%".$query."%' OR owner LIKE '%".$query."%' LIMIT 50");
		return $sql;
	}
	function select8($alias){
		$sql = $GLOBALS['serverdb']->query("SELECT id FROM groups_details WHERE alias = '".$alias."' LIMIT 1");
		return $sql;
	}
	function select9(){
		$sql = $GLOBALS['serverdb']->query("SELECT voucher,type,credits FROM vouchers");
		return $sql;
	}
	function select10($voucher){
		$sql = $GLOBALS['serverdb']->query("SELECT voucher,type,credits FROM vouchers WHERE voucher = '".$voucher."' LIMIT 1");
		return $sql;
	}
	function update1($id,$voucher,$type,$value){
		$sql = $GLOBALS['serverdb']->query("UPDATE vouchers SET voucher = '".$voucher."', type = '".$type."', credits = '".$value."' WHERE voucher = '".$id."' LIMIT 1");
	}
	function insert1($voucher,$type,$value){
		$sql = $GLOBALS['serverdb']->query("INSERT INTO vouchers (voucher,type,credits) VALUES ('".$voucher."','".$type."','".$value."')");
	}
	function delete1($id){
		$sql = $GLOBALS['serverdb']->query("DELETE FROM vouchers WHERE voucher = '".$id."' LIMIT 1");
	}
	function select11($id){
		$sql = $GLOBALS['serverdb']->query("SELECT user_id,badge_code,slot_id FROM users_badges WHERE user_id = '".$id."' and slot_id = '1' ");
		return $sql;
	}
	function select12($id){
		$sql = $GLOBALS['serverdb']->query("SELECT userid,ipaddress,date_expire,descr FROM users_bans WHERE userid = '".$id."' LIMIT 1");
		return $sql;
	}
	function update2($id,$rank,$motto,$credits,$birth,$email){
		$GLOBALS['serverdb']->query("UPDATE users SET rank = '".$rank."', motto = '".$motto."', credits = '".$credits."', account_day_of_birth = '".$birth."' WHERE id = '".$id."' LIMIT 1");
		$GLOBALS['serverdb']->query("UPDATE ".PREFIX."users SET email = '".$email."' WHERE id = '".$id."' LIMIT 1");
	}
	function insert2($id,$badge){
		$GLOBALS['serverdb']->query("UPDATE users_badges SET iscurrent = '0' WHERE userid = '".$id."'");
		$GLOBALS['serverdb']->query("INSERT INTO users_badges (userid,badgeid,iscurrent) VALUES ('".$id."','".$badge."','1')");
	}
	function delete2($id,$badge){
		$GLOBALS['serverdb']->query("DELETE FROM users_badges WHERE userid = '".$id."' AND badgeid = '".$badge."' LIMIT 1");
	}
	function update3($id,$badge){
		$GLOBALS['serverdb']->query("UPDATE users_badges SET iscurrent = '0' WHERE userid = '".$id."'");
		$GLOBALS['serverdb']->query("UPDATE users_badges SET iscurrent = '1' WHERE userid = '".$id."' AND badgeid = '".$badge."' LIMIT 1");
	}
	function update4($id,$ip,$ban_date,$reason){
		$GLOBALS['serverdb']->query("INSERT INTO users_bans (userid,ipaddress,date_expire,descr) VALUES ('".$id."','".$ip."','".$ban_date."','".$reason."')");
		$GLOBALS['serverdb']->query("UPDATE users SET ticket_sso = '' WHERE id = '".$id."' LIMIT 1");
	}
	function update5($id){
		$GLOBALS['serverdb']->query("UPDATE users SET figure = 'hd-180-1.ch-210-66.lg-270-82.sh-290-80.hr-105-42', sex = 'M' WHERE id = '".$id."' LIMIT 1");
	}
	function update6($id){
		$GLOBALS['serverdb']->query("UPDATE users SET badge_status = '0', hc_before = '1' WHERE id = '".$id."' LIMIT 1");
		$GLOBALS['serverdb']->query("UPDATE users SET rank = '1' WHERE id = '".$id."' AND rank = '2' LIMIT 1");
		$GLOBALS['serverdb']->query("DELETE FROM users_badges WHERE badgeid = 'HC1' OR badgeid = 'HC2' AND userid = '".$id."'");
		$GLOBALS['serverdb']->query("DELETE FROM users_club WHERE userid = '".$id."'");
	}
	function delete3($id,$ip){
		$GLOBALS['serverdb']->query("DELETE FROM users_bans WHERE userid = '".$id."' OR ipaddress = '".$ip."' LIMIT 1");
	}
	function select13(){
		$sql = $GLOBALS['serverdb']->query("SELECT user_id,ip,ban_expire,ban_reason FROM users_bans");
		return $sql;
		
	}
}
?>