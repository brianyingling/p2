<?php

require('helpers.php');
require('PigLatin.php');
require('Form.php');

use p2\PigLatin;
use DWA\Form;

$form = new Form($_POST);

$text       = isset($text) ?? '';
$suffix     = $form->get('suffix');
$short      = $form->has('short');
$translated = isset($translated) ?? '';

if ($form->isSubmitted()) {
    $errors = $form->validate([
        'text' => 'required'
    ]);

    if (!$form->hasErrors) {
        $text = $form->get('text');
        $pigLatin = new PigLatin($text, $suffix, $short);
        $translated = $pigLatin->translate();
    }
}

