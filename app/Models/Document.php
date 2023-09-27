<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /*
    A Opção abaixo comentata é utilizada caso a tabela não estreja no padrão LARAVEL
    Ou seja, o nome da Model no singular irá se relacionar no com 
    banco de dados com a tabela que possua o mesmo nome da Model no pural.    
    */
    //protected $table = 'table'; 

}
