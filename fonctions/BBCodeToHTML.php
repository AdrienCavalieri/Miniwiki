<?php
   // Conversion d'un message en HTML.
   /*
      Origine du code source : https://blog.niap3d.com/fr/4,10,news-65-Editeur-BBCode-PHP-Leger-et-Gratuit.html
   */
   function BBCodeToHTML($texte)
   {
   	// Remplace les retours à la ligne par des balises <br/>.
   	$texte = nl2br($texte);

   	// Liste de balises BBCode.
   	$balisesBBCode = array
      (
         '/\[p\](.*?)\[\/p\]/is',
   		'/\[b\](.*?)\[\/b\]/is',
   		'/\[i\](.*?)\[\/i\]/is',
   		'/\[u\](.*?)\[\/u\]/is',
   		'/\[sup\](.*?)\[\/sup\]/is',
   		'/\[sub\](.*?)\[\/sub\]/is',
   		'/\[code\](.*?)\[\/code\]/is',
   		'/\[quote\](.*?)\[\/quote\]/is',
   		'/\[quote\=(.*?)\](.*?)\[\/quote\]/is',
   		'/\[list\](.*?)\[\/list\]/is',
   		'/\[list=1\](.*?)\[\/list\]/is',
   		'/\[\*\](.*?)(\n|\r\n?)/is',
   		'/\[img\](.*?)\[\/img\]/is',
   		'/\[url\](.*?)\[\/url\]/is',
   		'/\[url\=(.*?)\](.*?)\[\/url\]/is',
   	);

   	// Correspondance HTML.
   	$balisesHTML = array
      (
         '<p>$1</p>',
   		'<strong>$1</strong>',
   		'<em>$1</em>',
   		'<u>$1</u>',
   		'<sup>$1</sup>',
   		'<sub>$1</sub>',
   		'<code><pre>$1</pre></code>',
   		'<blockquote>$1</blockquote>',
   		'<blockquote><cite>$1 : </cite>$2</blockquote>',
   		'<ul>$1</ul>',
   		'<ol>$1</ol>',
   		'<li>$1</li>',
   		'<img src="$1" />',
   		'<a href="$1">$1</a>',
   		'<a href="$1">$2</a>'
   	);

   	// Remplace les balises BBCode par des balises HTML dans le texte.
   	$i = 1;
   	while($i > 0)
   		$texte = preg_replace($balisesBBCode, $balisesHTML, $texte, -1, $i);

   	// Supprime les autres balises
   	return preg_replace(array('/\[(.*?)\]/is', '/\[\/(.*?)\]/is'), '', $texte);
   }
?>
