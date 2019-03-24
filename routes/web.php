<?php

use GuzzleHttp\Client;
use Storage;

Route::get('/', function () {
	return 'welcome';
});

Route::get('descargar', function () {
	$client = new Client([
	    'base_uri' => 'http://www.sunat.gob.pe/descarga/'
	]);
	
	Storage::makeDirectory('sunat');
	$path = 'storage/sunat/buenosContribuyentes.zip';

	$response = $client->request('GET', 'BueCont/BueCont_TXT.zip', ['sink' => $path]);

	return 'descargado';
});

Route::get('descomprimir', function () {
	Storage::makeDirectory('sunat/extract');

	$zip = new ZipArchive();

	$path = 'storage/sunat/buenosContribuyentes.zip';
	$pathToExtract = 'storage/sunat/extract';

	if ($zip->open($path) === TRUE) {
	    $zip->extractTo($pathToExtract);
	    $zip->close();
	    return 'ok';
	} else {
	    return 'failed';
	}
});

Route::get('leer', function () {	
	//$contents = file_get_contents('storage/sunat/extract/BueCont_TXT.txt');
	$contents = file_get_contents('storage/sunat/extract/padron_reducido_ruc.txt');
	$data = preg_split("/[\r\n]+/", $contents);

	/*
	$dataSunat = [];
	for ($i = 1; $i < count($data); $i++) {
		$enterprise = trim($data[$i]);
		if (strlen($enterprise) > 0) {
			$fields = explode('|', $enterprise);
			$item = [
				'ruc' => trim($fields[0]),
				'razon_social' => trim($fields[1]),
				'fecha' => trim($fields[2]),
				'resolucion' => trim($fields[3])
			];
			array_push($dataSunat, $item);
		}
	}
	*/

	dd(count($data));

});

Route::get('eliminar', function () {

});
