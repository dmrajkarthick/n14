<?php
define('NAMESPACE111222333','##$$');
$PATH='../';
require_once __DIR__.'/security.php';
try{
    $stmt=$c['db']->query("SELECT value FROM config WHERE name='admin_login'",array(':name' => 'admin_login'));
    $res=$stmt->fetch();
    if(!$res)
        throw new Exception('aksjlaksjdfklsjf;');
        	$res=explode(';',$res[0]);
	$user=$res[0];
	$pw=$res[1];
}catch(Exception $e){
	$_SESSION['error']=$e->getMessage();
	header('Location: ../index.php');
}

if(isset($_POST['editSubmit']))
try{
	$pwnew=$_POST['password'];
	if($pwnew!=$_POST['repassword'])
		throw new Exception('The two passwords entered do not match!');
	$usernew=$_POST['name'];
	if(strlen($usernew)<4)
		throw new Exception('Too short username. Minimum 4 characters required');
	if($pwnew){
		if(strlen($pwnew)<6)
			throw new Exception('Too short password. Minimum 6 characters required');
		$pwnew=sha1($pwnew.md5($KEY2));
	}else
		$pwnew=$pw;
	$c['db']->query_simple("UPDATE config SET value='$usernew;$pwnew' WHERE name='admin_login'");
	$user=$usernew;
	$T_INFO='Profile Updated!';
}catch(Exception $e){
	$T_ERROR=$e->getMessage();
}


$T_TITLE='NITTFEST Admin';
$T_HEADER='Login Details';
$T_CONTENT=<<<BODY
	<form action="./edit_login.php" method="post">
	 <table>
	<td>Admin Username</td>
	 <td><input type="text" name="name" value="$user"/></td>
	 </tr>
	 <tr>
	 <td>New Password<br /><span class="tip">(for changing)</span></td>
	 <td><input type="password" name="password" /></td>
	 </tr>
	 <tr>
	 <td>Retype Password</td>
	 <td><input type="password" name="repassword" /></td>
	 </tr>
	 <tr>
	 <td>&nbsp;</td>
	 <td><input type="submit" value="Update" name="editSubmit"/></td>
	 </tr>
	 </table>
    </form>
BODY;

require_once __DIR__.'/../../../admin/template/index.php';
