<?php
	//restaip for client
	$host				= 'localhost';	// IP ของฐานข้อมูล MYSQL	
	
	$username			= 'root';	// Username ของฐานข้อมูล
	$password			= 'dinfucker';	// Password ของฐานข้อมูล
	$account_db_name	= 'LTE';	// ชื่อ Database ที่เก็บข้อมูล ID/Username
	
	$account_table		= 'users';	// ชื่อ Table ที่เก็บข้อมูล Username/Email
	$account_field		= 'username';	// ชื่อ Field ของ Username/Email
	
	$point_table		= 'users';	// ชื่อ Table ที่เก็บข้อมูล point/cash
	$point_field		= 'saldo';	// ชื่อ Field ของ Point/Cash
	
	$accountid_field	= 'id';	// ชื่อ Field ที่ใช้อ้างอิงถึง Username/Email
	
	$access_ip 			= '103.233.192.204';	// IP ของ wallet.let-play.com ที่อนุญาติให้รับส่งข้อมูล (ไม่ควรแก้ไข)
	$passkey 			= '931ce1963575399f828142896cec1517';	//passkey จาก e-wallet.let-play.com ในระบบตั้งค่า(กำหนดใหม่ได้)

	$link = @mysql_connect($host, $username, $password) or die ('NOTCONNECT');	//Do not change
	@mysql_select_db($account_db_name);
	
	if(isset($_POST['passkey']) && $_POST['passkey']!=$passkey){		
		echo 'KEYSERROR';
	}
	else
	{	
		if(empty($_SERVER['REMOTE_ADDR']) || strcmp($_SERVER['REMOTE_ADDR'],$access_ip) != 0){
			echo 'ACCESSIPERROR';
		}else if(isset($_POST['cmd']) && $_POST['cmd']=='login'){
			$count = @mysql_num_rows(mysql_query("select $accountid_field from $account_table where $account_field='".$_POST['struser']."'"));
			if($count>=1){
				echo 'GETUSER';
			}else{
				echo 'NOTUSER';
			}	
		}
		else if(isset($_POST['cmd']) && $_POST['cmd']=='getreward')
		{	
			$query = @mysql_query("select $accountid_field from $account_table where $account_field='".$_POST['struser']."'");
			if(@mysql_num_rows($query)>=1){		
				$fetch = @mysql_fetch_array($query);
				$result = @mysql_query("update $point_table set $point_field=$point_field+'".$_POST['point']."' where $accountid_field='".$fetch[$accountid_field]."'");
				if($result){
					echo 'SUCCESS';
				}else{
					echo 'POSTERROR';
				}				
			}else{
				echo 'NOTUSER';
			}	
		}
		@mysql_close($link);	
	}
	
	$fbd_chr = array('\'','"',';','*','=','(',':',',','/','\\','(',')');
	foreach($_GET as $key=>$val)
	{
		$_GET[$key] = str_replace($fbd_chr,'',$val);
		if(isset($$key) == true)
		{
			unset($$key);
		}
	}
	foreach($_POST as $key=>$val)
	{
		$_POST[$key] = str_replace($fbd_chr,'',$val);
		if(isset($$key) == true)
		{
			unset($$key);
		}
	}
	foreach($_COOKIE as $key=>$val)
	{
		$_COOKIE[$key] = str_replace($fbd_chr,'',$val);
		if(isset($$key) == true)
		{
			unset($$key);
		}
	}
	foreach($_REQUEST as $key=>$val)
	{
		$_REQUEST[$key] = str_replace($fbd_chr,'',$val);
		if(isset($$key) == true)
		{
			unset($$key);
		}
	}	
?>

