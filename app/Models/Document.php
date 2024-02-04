<?php

namespace App\Models;

use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'type', 'arquive', 'expiration', 'serie', 'complements'];

    static function enumTypes()
    {
        return collect([
            'caepi' => ['name' => 'CA-EPI'],
            'nbr' => ['name' => 'NBR'],
            'report' => ['name' => 'Relatórios ou Laudo'],
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

    static function enumStatus()
    {
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

    public function stoks()
    {
        return $this->belongsToMany(Stoks::class, "stok_documents", "document_id", "stok_id")->orderBy("stok_documents.id", "desc");
    }

    public function parseComplementToJson()
    {
        $json = json_decode($this->complements);
        $array = [];
        foreach ($json as $key => $atribute) {
            if ($atribute->parameter == "historico_alteracoes") {
                $atribute->value = json_encode(explode("\n", $atribute->value));
                $array = array_merge($array, [$atribute->parameter => json_decode($atribute->value)]);
            } else {
                $array = array_merge($array, [$atribute->parameter => $atribute->value]);
            }
        }
        $json = json_encode($array);
        return json_decode($json);
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin'];
        foreach ($permissionRepository->getResources()['documents']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
