<?php
$telefon = $_REQUEST['telefon'] == "NULL" ? NULL : $_REQUEST['telefon'];
$statement1 = "INSERT INTO vlc_users ( name, sname, nick, nickname, passwd, mail, platnost, etapa, aktivni, kuchar, admin, telefon ) VALUES ( '".$_REQUEST['name']."',  '".$_REQUEST['sname']."',  '".$_REQUEST['nick']."',  '".$_REQUEST['nickname']."', '".$_REQUEST['passwd']."', '".$_REQUEST['mail']."', ".$_REQUEST['platnost'].", ".$_REQUEST['etapa'].", ".$_REQUEST['aktivni'].", ".$_REQUEST['kuchar'].", ".$_REQUEST['admin'].", ".$telefon." );";
//$statement2 = "INSERT INTO vlc_last_log ( nick, mail ) VALUES ( '".$_REQUEST['nick']."', '".$_REQUEST['mail']."' );";


$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		if ( $spojeni->query( $statement1 ) )
		{
			$subject = 'Nový účet na 51. smečce Vlčat';
			$message = 'Byl Vám vytvořen nový účet na http://vlcata.pohrebnisluzbazlin.cz.

Přihlašovací jméno: '.$_REQUEST['nick'].'
Heslo: '.$_REQUEST['passwd'].'

S případnými dotazy se obraťte na správce webu ('.$spravce.')';
			$headers = 'From: Vlčata <'.$spravce.'>';
			mail( $_REQUEST['mail'], $subject, $message, $headers );
			echo '<p>Everything gone OK <br />'.$statement1.'<br />Mail sent to '.$_REQUEST['mail'].'</p>';
		}
		else echo '<p>Statement contain mistake<br /><br />'.$statement1.'</p>';
		//if ( $spojeni->query( $statement2 ) ) echo $statement2;
		//else echo '<p>Statement contain mistake<br /><br />'.$statement2.'</p>';
		
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>