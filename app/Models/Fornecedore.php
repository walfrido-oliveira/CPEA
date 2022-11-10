<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedore extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_fornecedor','cnpj','nome','fantasia','endereco','tipo_logradouro','logradouro','numero','complemento','bairro','cep','municipio','uf','ddd_telefone','telefone','pagina_web','email','email_compras','email_vendas','nro_funcionarios','cnae','descricao','exporta','importa','produto_1','produto_2','produto_3','outros_produtos','ano_fundacao','facebook','twitter','instagram','youtube','linkedin','materias_primas','processo_produtivo','ddd_telefone2','telefone2','ddd_celular','celular','pais','matriz','filial','capital',

    ];
}
