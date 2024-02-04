<?php

namespace App\Repositories;

use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{


    function getResources(): array
    {
        return [
            "public" => [
                "name" => "Público", "value" => "Publico", "permissions" => [
                    ["name" => "Gerenciar Público", "slug" => "gerenciar-publico", "resource" => "Publico", "System" => true],
                    ["name" => "Ver Público", "slug" => "ver-publico", "resource" => "Publico", "System" => true],
                    ["name" => "Criar Público", "slug" => "criar-publico", "resource" => "Publico", "System" => true],
                    ["name" => "Atualizar Público", "slug" => "atualizar-publico", "resource" => "Publico", "System" => true],
                    ["name" => "Deletar Público", "slug" => "deletar-publico", "resource" => "Publico", "System" => true],
                    ["name" => "Listar Público", "slug" => "listar-publico", "resource" => "Publico", "System" => true],
                    ]
                ],
                //end Publico permissions resource - 1
            "documents" => [
                "name" => "Documentos", "value" => "Documentos", "permissions" => [
                    ["name" => "Gerenciar Documentos", "slug" => "gerenciar-documentos", "resource" => "Documentos", "System" => true],
                    ["name" => "Ver Documentos", "slug" => "ver-documentos", "resource" => "Documentos", "System" => true],
                    ["name" => "Criar Documentos", "slug" => "criar-documentos", "resource" => "Documentos", "System" => true],
                    ["name" => "Atualizar Documentos", "slug" => "atualizar-documentos", "resource" => "Documentos", "System" => true],
                    ["name" => "Deletar Documentos", "slug" => "deletar-documentos", "resource" => "Documentos", "System" => true],
                    ["name" => "Listar Documentos", "slug" => "listar-documentos", "resource" => "Documentos", "System" => true],
                    ]
                ],
                //end Documentos permissions resource - 2
            "professions" => [
                "name" => "Profissões", "value" => "Profissoes", "permissions" => [
                    ["name" => "Gerenciar Profissões", "slug" => "gerenciar-profissoes", "resource" => "Profissoes", "System" => true],
                    ["name" => "Ver Profissões", "slug" => "ver-profissoes", "resource" => "Profissoes", "System" => true],
                    ["name" => "Criar Profissões", "slug" => "criar-profissoes", "resource" => "Profissoes", "System" => true],
                    ["name" => "Atualizar Profissões", "slug" => "atualizar-profissoes", "resource" => "Profissoes", "System" => true],
                    ["name" => "Deletar Profissões", "slug" => "deletar-profissoes", "resource" => "Profissoes", "System" => true],
                    ["name" => "Listar Profissões", "slug" => "listar-profissoes", "resource" => "Profissoes", "System" => true],
                    ]
                ],
                //end Profissoes permissions resource - 3
            "employees" => [
                "name" => "Colaboradores", "value" => "Colaboradores", "permissions" => [
                    ["name" => "Gerenciar Colaboradores", "slug" => "gerenciar-colaboradores", "resource" => "Colaboradores", "System" => true],
                    ["name" => "Ver Colaboradores", "slug" => "ver-colaboradores", "resource" => "Colaboradores", "System" => true],
                    ["name" => "Criar Colaboradores", "slug" => "criar-colaboradores", "resource" => "Colaboradores", "System" => true],
                    ["name" => "Atualizar Colaboradores", "slug" => "atualizar-colaboradores", "resource" => "Colaboradores", "System" => true],
                    ["name" => "Deletar Colaboradores", "slug" => "deletar-colaboradores", "resource" => "Colaboradores", "System" => true],
                    ["name" => "Listar Colaboradores", "slug" => "listar-colaboradores", "resource" => "Colaboradores", "System" => true],
                    ]
                ],
                //end Colaboradores permissions resource - 4
            "branchs" => [
                "name" => "Filiais", "value" => "Filiais", "permissions" => [
                    ["name" => "Gerenciar Filiais", "slug" => "gerenciar-filiais", "resource" => "Filiais", "System" => true],
                    ["name" => "Ver Filiais", "slug" => "ver-filiais", "resource" => "Filiais", "System" => true],
                    ["name" => "Criar Filiais", "slug" => "criar-filiais", "resource" => "Filiais", "System" => true],
                    ["name" => "Atualizar Filiais", "slug" => "atualizar-filiais", "resource" => "Filiais", "System" => true],
                    ["name" => "Deletar Filiais", "slug" => "deletar-filiais", "resource" => "Filiais", "System" => true],
                    ["name" => "Listar Filiais", "slug" => "listar-filiais", "resource" => "Filiais", "System" => true],
                    ]
                ],
                //end Filiais permissions resource - 5
            "supplyments-invoices" => [
                "name" => "Suprimentos-NFs ", "value" => "Suprimentos-NFs", "permissions" => [
                    ["name" => "Gerenciar Suprimentos-NFs ", "slug" => "gerenciar-suprimentos-nfs", "resource" => "Suprimentos-NFs", "System" => true],
                    ["name" => "Ver Suprimentos-NFs ", "slug" => "ver-suprimentos-nfs", "resource" => "Suprimentos-NFs", "System" => true],
                    ["name" => "Criar Suprimentos-NFs ", "slug" => "criar-suprimentos-nfs", "resource" => "Suprimentos-NFs", "System" => true],
                    ["name" => "Atualizar Suprimentos-NFs ", "slug" => "atualizar-suprimentos-nfs", "resource" => "Suprimentos-NFs", "System" => true],
                    ["name" => "Deletar Suprimentos-NFs ", "slug" => "deletar-suprimentos-nfs", "resource" => "Suprimentos-NFs", "System" => true],
                    ["name" => "Listar Suprimentos-NFs ", "slug" => "listar-suprimentos-nfs", "resource" => "Suprimentos-NFs", "System" => true],
                    ]
                ],
                //end Suprimentos-NFs permissions resource - 6
            "supplyments-providers" => [
                "name" => "Suprimentos-Fornecedores ", "value" => "Suprimentos-Fornecedores", "permissions" => [
                    ["name" => "Gerenciar Suprimentos-Fornecedores ", "slug" => "gerenciar-suprimentos-fornecedores", "resource" => "Suprimentos-Fornecedores", "System" => true],
                    ["name" => "Ver Suprimentos-Fornecedores ", "slug" => "ver-suprimentos-fornecedores", "resource" => "Suprimentos-Fornecedores", "System" => true],
                    ["name" => "Criar Suprimentos-Fornecedores ", "slug" => "criar-suprimentos-fornecedores", "resource" => "Suprimentos-Fornecedores", "System" => true],
                    ["name" => "Atualizar Suprimentos-Fornecedores ", "slug" => "atualizar-suprimentos-fornecedores", "resource" => "Suprimentos-Fornecedores", "System" => true],
                    ["name" => "Deletar Suprimentos-Fornecedores ", "slug" => "deletar-suprimentos-fornecedores", "resource" => "Suprimentos-Fornecedores", "System" => true],
                    ["name" => "Listar Suprimentos-Fornecedores ", "slug" => "listar-suprimentos-fornecedores", "resource" => "Suprimentos-Fornecedores", "System" => true],
                    ]
                ],
                //end Suprimentos-NFs permissions resource - 7
            "supplyments-categories" => [
                "name" => "Suprimentos-Categorias ", "value" => "Suprimentos-Categorias", "permissions" => [
                    ["name" => "Gerenciar Suprimentos-Categorias ", "slug" => "gerenciar-suprimentos-categorias", "resource" => "Suprimentos-Categorias", "System" => true],
                    ["name" => "Ver Suprimentos-Categorias ", "slug" => "ver-suprimentos-categorias", "resource" => "Suprimentos-Categorias", "System" => true],
                    ["name" => "Criar Suprimentos-Categorias ", "slug" => "criar-suprimentos-categorias", "resource" => "Suprimentos-Categorias", "System" => true],
                    ["name" => "Atualizar Suprimentos-Categorias ", "slug" => "atualizar-suprimentos-categorias", "resource" => "Suprimentos-Categorias", "System" => true],
                    ["name" => "Deletar Suprimentos-Categorias ", "slug" => "deletar-suprimentos-categorias", "resource" => "Suprimentos-Categorias", "System" => true],
                    ["name" => "Listar Suprimentos-Categorias ", "slug" => "listar-suprimentos-categorias", "resource" => "Suprimentos-Categorias", "System" => true],
                    ]
                ],
                //end Suprimentos-Categorias permissions resource - 8
            "supplyments-products" => [
                "name" => "Suprimentos-Produtps ", "value" => "Suprimentos-Produtps", "permissions" => [
                    ["name" => "Gerenciar Suprimentos-Produtps ", "slug" => "gerenciar-suprimentos-produtos", "resource" => "Suprimentos-Produtps", "System" => true],
                    ["name" => "Ver Suprimentos-Produtps ", "slug" => "ver-suprimentos-produtos", "resource" => "Suprimentos-Produtps", "System" => true],
                    ["name" => "Criar Suprimentos-Produtps ", "slug" => "criar-suprimentos-produtos", "resource" => "Suprimentos-Produtps", "System" => true],
                    ["name" => "Atualizar Suprimentos-Produtps ", "slug" => "atualizar-suprimentos-produtos", "resource" => "Suprimentos-Produtps", "System" => true],
                    ["name" => "Deletar Suprimentos-Produtps ", "slug" => "deletar-suprimentos-produtos", "resource" => "Suprimentos-Produtps", "System" => true],
                    ["name" => "Listar Suprimentos-Produtps ", "slug" => "listar-suprimentos-produtos", "resource" => "Suprimentos-Produtps", "System" => true],
                    ]
                ],
                //end Suprimentos-Produtos permissions resource - 9
            "supplyments" =>  [
                "name" => "Suprimentos-Custos ", "value" => "Suprimentos-Custos", "permissions" => [
                    ["name" => "Gerenciar Suprimentos-Custos ", "slug" => "gerenciar-suprimentos-custos", "resource" => "Suprimentos-Custos", "System" => true],
                    ["name" => "Ver Suprimentos-Custos ", "slug" => "ver-suprimentos-custos", "resource" => "Suprimentos-Custos", "System" => true],
                    ["name" => "Criar Suprimentos-Custos ", "slug" => "criar-suprimentos-custos", "resource" => "Suprimentos-Custos", "System" => true],
                    ["name" => "Atualizar Suprimentos-Custos ", "slug" => "atualizar-suprimentos-custos", "resource" => "Suprimentos-Custos", "System" => true],
                    ["name" => "Deletar Suprimentos-Custos ", "slug" => "deletar-suprimentos-custos", "resource" => "Suprimentos-Custos", "System" => true],
                    ["name" => "Listar Suprimentos-Custos ", "slug" => "listar-suprimentos-custos", "resource" => "Suprimentos-Custos", "System" => true],
                    ]
                ],
                //end Suprimentos-NFs permissions resource - 10
            "formlists" => [
                "name" => "Formulários", "value" => "Formularios", "permissions" => [
                    ["name" => "Gerenciar Formulários", "slug" => "gerenciar-formularios", "resource" => "Formularios", "System" => true],
                    ["name" => "Ver Formulários", "slug" => "ver-formularios", "resource" => "Formularios", "System" => true],
                    ["name" => "Criar Formulários", "slug" => "criar-formularios", "resource" => "Formularios", "System" => true],
                    ["name" => "Atualizar Formulários", "slug" => "atualizar-formularios", "resource" => "Formularios", "System" => true],
                    ["name" => "Deletar Formulários", "slug" => "deletar-formularios", "resource" => "Formularios", "System" => true],
                    ["name" => "Listar Formulários", "slug" => "listar-formularios", "resource" => "Formularios", "System" => true],
                    ]
                ],
                //end Formularios permissions resource - 11
            "acl-permissions" => [
                "name" => "Acl-Permissoes ", "value" => "Acl-Permissões", "permissions" => [
                    ["name" => "Gerenciar Acl-Permissões ", "slug" => "gerenciar-acl-permissoes", "resource" => "Acl-Permissoes", "System" => true],
                    ["name" => "Ver Acl-Permissões ", "slug" => "ver-acl-permissoes", "resource" => "Acl-Permissoes", "System" => true],
                    ["name" => "Criar Acl-Permissões ", "slug" => "criar-acl-permissoes", "resource" => "Acl-Permissoes", "System" => true],
                    ["name" => "Atualizar Acl-Permissões ", "slug" => "atualizar-acl-permissoes", "resource" => "Acl-Permissoes", "System" => true],
                    ["name" => "Deletar Acl-Permissões ", "slug" => "deletar-acl-permissoes", "resource" => "Acl-Permissoes", "System" => true],
                    ["name" => "Listar Acl-Permissões ", "slug" => "listar-acl-permissoes", "resource" => "Acl-Permissoes", "System" => true],
                    ]
                ],
                //end Acl-Permissões permissions resource - 12
            "acl-users" => [
                "name" => "Acl-Usuarios ", "value" => "Acl-Usuários", "permissions" => [
                    ["name" => "Gerenciar Acl-Usuários ", "slug" => "gerenciar-acl-usuarios", "resource" => "Acl-Usuarios", "System" => true],
                    ["name" => "Ver Acl-Usuários ", "slug" => "ver-acl-usuarios", "resource" => "Acl-Usuarios", "System" => true],
                    ["name" => "Criar Acl-Usuários ", "slug" => "criar-acl-usuarios", "resource" => "Acl-Usuarios", "System" => true],
                    ["name" => "Atualizar Acl-Usuários ", "slug" => "atualizar-acl-usuarios", "resource" => "Acl-Usuarios", "System" => true],
                    ["name" => "Deletar Acl-Usuários ", "slug" => "deletar-acl-usuarios", "resource" => "Acl-Usuarios", "System" => true],
                    ["name" => "Listar Acl-Usuários ", "slug" => "listar-acl-usuarios", "resource" => "Acl-Usuarios", "System" => true],
                    ]
                ],
                //end Acl-Usuários permissions resource - 13
            "acl-roles" => [
                "name" => "Acl-Funcoes ", "value" => "Acl-Funções", "permissions" => [
                    ["name" => "Gerenciar Acl-Funções ", "slug" => "gerenciar-acl-funcoes", "resource" => "Acl-Funcoes", "System" => true],
                    ["name" => "Ver Acl-Funções ", "slug" => "ver-acl-funcoes", "resource" => "Acl-Funcoes", "System" => true],
                    ["name" => "Criar Acl-Funções ", "slug" => "criar-acl-funcoes", "resource" => "Acl-Funcoes", "System" => true],
                    ["name" => "Atualizar Acl-Funções ", "slug" => "atualizar-acl-funcoes", "resource" => "Acl-Funcoes", "System" => true],
                    ["name" => "Deletar Acl-Funções ", "slug" => "deletar-acl-funcoes", "resource" => "Acl-Funcoes", "System" => true],
                    ["name" => "Listar Acl-Funções ", "slug" => "listar-acl-funcoes", "resource" => "Acl-Funcoes", "System" => true],
                    ]
                ],
                //end Acl-Funções permissions resource - 14
            "projects" => [
                "name" => "Projetos", "value" => "Projetos", "permissions" => [
                    ["name" => "Gerenciar Projetos", "slug" => "gerenciar-projetos", "resource" => "Projetos", "System" => true],
                    ["name" => "Ver Projetos", "slug" => "ver-projetos", "resource" => "Projetos", "System" => true],
                    ["name" => "Criar Projetos", "slug" => "criar-projetos", "resource" => "Projetos", "System" => true],
                    ["name" => "Atualizar Projetos", "slug" => "atualizar-projetos", "resource" => "Projetos", "System" => true],
                    ["name" => "Deletar Projetos", "slug" => "deletar-projetos", "resource" => "Projetos", "System" => true],
                    ["name" => "Listar Projetos", "slug" => "listar-projetos", "resource" => "Projetos", "System" => true],
                    ]
                ],
                //end Projetos permissions resource - 15
            "bases" => [
                "name" => "Bases", "value" => "Bases", "permissions" => [
                    ["name" => "Gerenciar Bases", "slug" => "gerenciar-bases", "resource" => "Bases", "System" => true],
                    ["name" => "Ver Bases", "slug" => "ver-bases", "resource" => "Bases", "System" => true],
                    ["name" => "Criar Bases", "slug" => "criar-bases", "resource" => "Bases", "System" => true],
                    ["name" => "Atualizar Bases", "slug" => "atualizar-bases", "resource" => "Bases", "System" => true],
                    ["name" => "Deletar Bases", "slug" => "deletar-bases", "resource" => "Bases", "System" => true],
                    ["name" => "Listar Bases", "slug" => "listar-bases", "resource" => "Bases", "System" => true],
                    ]
                ],
                //end Bases permissions resource - 16 
            "sectors" => [
                "name" => "Setores", "value" => "Setores", "permissions" => [
                    ["name" => "Gerenciar Setores", "slug" => "gerenciar-setores", "resource" => "Setores", "System" => true],
                    ["name" => "Ver Setores", "slug" => "ver-setores", "resource" => "Setores", "System" => true],
                    ["name" => "Criar Setores", "slug" => "criar-setores", "resource" => "Setores", "System" => true],
                    ["name" => "Atualizar Setores", "slug" => "atualizar-setores", "resource" => "Setores", "System" => true],
                    ["name" => "Deletar Setores", "slug" => "deletar-setores", "resource" => "Setores", "System" => true],
                    ["name" => "Listar Setores", "slug" => "listar-setores", "resource" => "Setores", "System" => true],
                    ]
                ],
                //end Setores permissions resource - 17
            "stoks" => [
                "name" => "Estoque", "value" => "Estoque", "permissions" => [
                    ["name" => "Gerenciar Estoque", "slug" => "gerenciar-estoque", "resource" => "Estoque", "System" => true],
                    ["name" => "Ver Estoque", "slug" => "ver-estoque", "resource" => "Estoque", "System" => true],
                    ["name" => "Criar Estoque", "slug" => "criar-estoque", "resource" => "Estoque", "System" => true],
                    ["name" => "Atualizar Estoque", "slug" => "atualizar-estoque", "resource" => "Estoque", "System" => true],
                    ["name" => "Deletar Estoque", "slug" => "deletar-estoque", "resource" => "Estoque", "System" => true],
                    ["name" => "Listar Estoque", "slug" => "listar-estoque", "resource" => "Estoque", "System" => true],
                    ]
                ],
                //end Estoque permissions resource

        ];
    }
}
