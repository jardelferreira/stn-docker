<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','status','type','arquive','expiration','serie','complements'];

    static function enumTypes(){
        return collect([
            'caepi' => ['name' => 'CA-EPI'],
            'nbr' => ['name' => 'NBR'],
            'report' => ['name' => 'Laudo'],
            'art' => ['name' => 'ART'],
            'cconform' => ['name' => 'Certificado de Conformidade'],
            'corigin' => ['name' => 'Certificado de Origem'],
            'cquality' => ['name' => 'Certificado de Qualidade'],
            'ctest' => ['name' => 'Certificado de Teste'],
            'canalysis' => ['name' => 'Certificado de Análise'],
            'ccalibration' => ['name' => 'Certificado de Calibração'],
            'ctraceability' => ['name' => 'Certificado de Rastreabilidade'],
            'cmi' => ['name' => 'Certificado de Manipulação ou Instalação'],
            'ctreinament' => ['name' => 'Certificado de Treinamento'],
            'cgarant' => ['name' => 'Certificado de Garantia'],
            'other' => ['name' => "Outros"],
        ]);
    }

    static function enumStatus() {
        return collect([
            'active' => ['name' => 'Ativo'],
            'inactive' => ['name' => 'Inativo'],
            'valid' => ['name' => 'Válido'],
            'invalid' => ['name' => 'Inválido'],
            'suspended' => ['name' => 'Suspenso'],
            'vanquished' => ['name' => 'Vencido'],
            'analysis' => ['name' => 'Em Análise'],
            'temporary' => ['name' => 'Temporário'],
            'definitive' => ['name' => 'Definitivo'],
            'approved' => ['name' => 'Aprovado'],
            'disapproved' => ['name' => 'Reprovado'],
            'other' => ['name' => "Outros"],
        ]);
    }
}
