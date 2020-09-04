<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//BUSCA JSON DE INSTITUIÇÕES
Route::get('/instituicoes', 'EmprestaController@getInstituicoes');

//BUSCA JSON DE CONVÊNIOS
Route::get('/convenios', 'EmprestaController@getConvenios');

//REALIZA SIMULAÇÃO DE CRÉDITO
Route::post('/simulacao', 'EmprestaController@simulacaoCredito');
