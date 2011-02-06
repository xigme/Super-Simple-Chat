<?php

$smileys = Array(
	':)'=>'smile',
	':-)'=>'smile',
	'(:'=>'smile',
	'(-:'=>'smile',
	'>:('=>'grumpy',
	'>:-('=>'grumpy',
	'):<'=>'grumpy',
	')-:<'=>'grumpy',
	':('=>'frown',
	':-('=>'frown',
	'):'=>'frown',
	')-:'=>'frown',
	'>:o'=>'upset',
	'>:O'=>'upset',
	'>:-o'=>'upset',
	'>:-O'=>'upset',
	'o:<'=>'upset',
	'O:<'=>'upset',
	'o-:<'=>'upset',
	'O-:<'=>'upset',
	':o'=>'gasp',
	':O'=>'gasp',
	':-o'=>'gasp',
	':-O'=>'gasp',
	'o:'=>'gasp',
	'O:'=>'gasp',
	'o-:'=>'gasp',
	'O-:'=>'gasp',
	':D'=>'grin',
	':-D'=>'grin',
	'=D'=>'grin',
	':P'=>'tongue',
	':p'=>'tongue',
	':-P'=>'tongue',
	':-p'=>'tongue',
	';)'=>'wink',
	';-)'=>'wink',
	'(;'=>'wink',
	'(-;'=>'wink',
	':3'=>'curlylips',
	':-3'=>'curlylips',
	':*'=>'kiss',
	':-*'=>'kiss',
	'*:'=>'kiss',
	'*-:'=>'kiss',
	'8)'=>'glasses',
	'8-)'=>'glasses',
	'(8'=>'glasses',
	'(-8'=>'glasses',
	'B)'=>'sunglasses',
	'B-)'=>'sunglasses',
	'O.o'=>'confused',
	'o.O'=>'confused',
	'O_o'=>'confused',
	'o_O'=>'confused',
	'-_-'=>'squint',
	':/'=>'unsure',
	':-/'=>'unsure',
	':\\'=>'unsure',
	':-\\'=>'unsure',
	'/:'=>'unsure',
	'/-:'=>'unsure',
	'\\:'=>'unsure',
	'\\-:'=>'unsure',
	'^_^'=>'kiki',
	'^-^'=>'kiki'
);

if (get_magic_quotes_gpc()):
	foreach ($_POST as $key=>$val):
		$_POST[$key] = stripslashes($val);
	endforeach;
endif;

if ($_POST['action'] == 'send'):
	foreach ($smileys as $smiley=>$image):
		$_POST['text'] = str_replace($smiley, '<img src="emoticons/'.$image.'.png" class="sschat_emoticon">', $_POST['text']);
	endforeach;
	$fp = fopen('history.txt', 'a');
	fwrite($fp, $_POST['text']."\n");
	fclose($fp);
elseif ($_POST['action'] == 'listen'):
	$stat = stat('history.txt');
	$lastsize = intval($stat['size']);
	while (1):
		usleep(100000);
		clearstatcache();
		$stat = stat('history.txt');
		if (intval($stat['size']) > $lastsize):
			$lines = file('history.txt');
			echo '<li>'.$lines[sizeof($lines)-1].'</li>';
			die();
		endif;
		$counter++;
	endwhile;
endif;
?>
