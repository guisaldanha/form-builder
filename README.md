# Gerador de formulários HTML 5 em PHP

Como o próprio título sugere, essa é uma classe responsável por criar formulários HTML.

## Instalação

Para instalar é bem simples, basta ter o composer instalado e rodar o comando abaixo

```shell
composer require guisaldanha/form-builder
```

## Utilização

Para usar essa biblioteca, basta usar o código abaixo

```php
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

<h1>Contato</h1>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
<?= $form->create() ?>
```

É possível, usando o método `setHidePlaceholder` esconder desabilitar o placeholder dos campos, e também não usar o label usando o método `setHideLabel`

## Requerimentos

Foi testado nas versões 7.4 e superiores do PHP. É possível que funcionem em versões anteriores, mas não testei.
