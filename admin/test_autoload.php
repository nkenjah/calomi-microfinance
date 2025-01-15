<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;

$phpWord = new PhpWord();
$section = $phpWord->addSection();
$section->addText('Hello World! This is a test document.');

$filename = 'hello_world.docx';
$phpWord->save($filename, 'Word2007');

echo "Document created: $filename";
