<?php
include __DIR__ . "/vendor/autoload.php";

use GuiSaldanha\FormBuilder\Form;


$form = new Form('POST', 'enviar.php', "Enviar Mensagem");

// $form->setHidePlaceholder(true);
// $form->setHideLabel(true);

$form->addField('nome*', 'Nome', 'text');
$form->addField('email*', 'Email', 'email');
$form->addField('telefone*', 'Telefone', 'tel');
$form->addField('comoConheceu', 'Onde nos conheceu?', 'select', ['Google', 'Facebook', 'Instagram', 'Youtube', 'Outros']);
$form->addField('mensagem*', 'Diga alguma coisa', 'textarea');
$form->addField('newsletter*', 'Quero receber novidades e promoções sobre o site', 'checkbox');

?>
<link rel="stylesheet" href="style.css">
<div class="container">
	<h1>Contato</h1>
	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
	<?= $form->create() ?>
</div>