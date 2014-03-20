<?php

#error_reporting(E_ALL);
#ini_set("display_errors", 1);

/**
 * i-Educar - Sistema de gest�o escolar
 *
 * Copyright (C) 2006  Prefeitura Municipal de Itaja�
 *                     <ctima@itajai.sc.gov.br>
 *
 * Este programa � software livre; voc� pode redistribu�-lo e/ou modific�-lo
 * sob os termos da Licen�a P�blica Geral GNU conforme publicada pela Free
 * Software Foundation; tanto a vers�o 2 da Licen�a, como (a seu crit�rio)
 * qualquer vers�o posterior.
 *
 * Este programa � distribu��do na expectativa de que seja �til, por�m, SEM
 * NENHUMA GARANTIA; nem mesmo a garantia impl��cita de COMERCIABILIDADE OU
 * ADEQUA��O A UMA FINALIDADE ESPEC�FICA. Consulte a Licen�a P�blica Geral
 * do GNU para mais detalhes.
 *
 * Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral do GNU junto
 * com este programa; se n�o, escreva para a Free Software Foundation, Inc., no
 * endere�o 59 Temple Street, Suite 330, Boston, MA 02111-1307 USA.
 *
 * @author    Prefeitura Municipal de Itaja� <ctima@itajai.sc.gov.br>
 * @category  i-Educar
 * @license   @@license@@
 * @package   iEd_Pmieducar
 * @since     Arquivo dispon�vel desde a vers�o 1.0.0
 * @version   $Id$
 */

require_once 'include/pmieducar/geral.inc.php';

/**
 * clsPmieducarEscola class.
 *
 * @author    Prefeitura Municipal de Itaja� <ctima@itajai.sc.gov.br>
 * @category  i-Educar
 * @license   @@license@@
 * @package   iEd_Pmieducar
 * @since     Classe dispon�vel desde a vers�o 1.0.0
 * @version   @@package_version@@
 */
class clsPmieducarEscola
{
  var $cod_escola;
  var $ref_usuario_cad;
  var $ref_usuario_exc;
  var $ref_cod_instituicao;
  var $ref_cod_escola_localizacao;
  var $ref_cod_escola_rede_ensino;
  var $ref_idpes;
  var $sigla;
  var $data_cadastro;
  var $data_exclusao;
  var $ativo;

  var $situacao_funcionamento;
  var $dependencia_administrativa;
  var $regulamentacao;
  var $acesso;
  var $ref_idpes_gestor;
  var $cargo_gestor;
  var $condicao;
  var $decreto_criacao;
  var $area_terreno_total;
  var $area_disponivel;
  var $area_construida;
  var $num_pavimentos;
  var $tipo_piso;
  var $medidor_energia;
  var $agua_consumida;
  var $agua_rede_publica;
  var $agua_poco_artesiano;
  var $agua_cacimba_cisterna_poco;
  var $agua_fonte_rio;
  var $agua_inexistente;
  var $energia_rede_publica;
  var $energia_gerador;
  var $energia_outros;
  var $energia_inexistente;
  var $esgoto_rede_publica;
  var $esgoto_fossa;
  var $esgoto_inexistente;
  var $lixo_coleta_periodica;
  var $lixo_queima;
  var $lixo_joga_outra_area;
  var $lixo_recicla;
  var $lixo_enterra;
  var $lixo_outros;
  var $dependencia_sala_diretoria;
  var $dependencia_sala_professores;
  var $dependencia_sala_secretaria;
  var $dependencia_laboratorio_informatica;
  var $dependencia_laboratorio_ciencias;
  var $dependencia_sala_aee;
  var $dependencia_quadra_coberta;
  var $dependencia_quadra_descoberta;
  var $dependencia_cozinha;
  var $dependencia_biblioteca;
  var $dependencia_sala_leitura;
  var $dependencia_parque_infantil;
  var $dependencia_bercario;
  var $dependencia_banheiro_fora;
  var $dependencia_banheiro_dentro;
  var $dependencia_banheiro_infantil;
  var $dependencia_banheiro_deficiente;
  var $dependencia_banheiro_chuveiro;
  var $dependencia_refeitorio;
  var $dependencia_dispensa;
  var $dependencia_aumoxarifado;
  var $dependencia_auditorio;
  var $dependencia_patio_coberto;

  /**
   * Armazena o total de resultados obtidos na �ltima chamada ao m�todo lista().
   * @var int
   */
  var $_total;

  /**
   * Nome do schema.
   * @var string
   */
  var $_schema;

  /**
   * Nome da tabela.
   * @var string
   */
  var $_tabela;

  /**
   * Lista separada por v�rgula, com os campos que devem ser selecionados na
   * pr�xima chamado ao m�todo lista().
   * @var string
   */
  var $_campos_lista;

  /**
   * Lista com todos os campos da tabela separados por v�rgula, padr�o para
   * sele��o no m�todo lista.
   * @var string
   */
  var $_todos_campos;

  /**
   * Valor que define a quantidade de registros a ser retornada pelo m�todo lista().
   * @var int
   */
  var $_limite_quantidade;

  /**
   * Define o valor de offset no retorno dos registros no m�todo lista().
   * @var int
   */
  var $_limite_offset;

  /**
   * Define o campo para ser usado como padr�o de ordena��o no m�todo lista().
   * @var string
   */
  var $_campo_order_by;

  /**
   * Construtor.
   */
  function clsPmieducarEscola($cod_escola = NULL,
                              $ref_usuario_cad = NULL,
                              $ref_usuario_exc = NULL,
                              $ref_cod_instituicao = NULL,
                              $ref_cod_escola_localizacao = NULL,
                              $ref_cod_escola_rede_ensino = NULL,
                              $ref_idpes = NULL,
                              $sigla = NULL,
                              $data_cadastro = NULL,
                              $data_exclusao = NULL,
                              $ativo = NULL,
                              $bloquear_lancamento_diario_anos_letivos_encerrados = NULL) {
    $db = new clsBanco();
    $this->_schema = 'pmieducar.';
    $this->_tabela = $this->_schema . 'escola';

    $this->_campos_lista = $this->_todos_campos = 'e.cod_escola, e.ref_usuario_cad, e.ref_usuario_exc, e.ref_cod_instituicao, e.ref_cod_escola_localizacao, e.ref_cod_escola_rede_ensino, e.ref_idpes, e.sigla, e.data_cadastro, 
          e.data_exclusao, e.ativo, e.bloquear_lancamento_diario_anos_letivos_encerrados, e.situacao_funcionamento, e.dependencia_administrativa, e.regulamentacao, e.acesso, e.cargo_gestor, e.ref_idpes_gestor, e.area_terreno_total,
          e.condicao, e.area_construida, e.area_disponivel, e.num_pavimentos, e.decreto_criacao, e.tipo_piso, e.medidor_energia, e.agua_consumida, e.agua_rede_publica, e.agua_poco_artesiano, e.agua_cacimba_cisterna_poco, e.agua_fonte_rio, 
          e.agua_inexistente, e.energia_rede_publica, e.energia_outros, e.energia_gerador, e.energia_inexistente, e.esgoto_rede_publica, e.esgoto_fossa, e.esgoto_inexistente, e.lixo_coleta_periodica, e.lixo_queima, e.lixo_joga_outra_area, 
          e.lixo_recicla, e.lixo_enterra, e.lixo_outros, e.dependencia_sala_diretoria, e.dependencia_sala_professores, e.dependencia_sala_secretaria, e.dependencia_laboratorio_informatica, e.dependencia_laboratorio_ciencias, e.dependencia_sala_aee,
          e.dependencia_quadra_coberta, e.dependencia_quadra_descoberta, e.dependencia_cozinha, e.dependencia_biblioteca, e.dependencia_sala_leitura, e.dependencia_parque_infantil, e.dependencia_bercario, e.dependencia_banheiro_fora, 
          e.dependencia_banheiro_dentro, e.dependencia_banheiro_infantil, e.dependencia_banheiro_deficiente, e.dependencia_banheiro_chuveiro, e.dependencia_refeitorio, e.dependencia_dispensa, e.dependencia_aumoxarifado, e.dependencia_auditorio, 
          e.dependencia_patio_coberto


           ';

    if (is_numeric($ref_usuario_cad)) {
      if (class_exists("clsPmieducarUsuario")) {
        $tmp_obj = new clsPmieducarUsuario($ref_usuario_cad);
        if (method_exists($tmp_obj, "existe")) {
          if ($tmp_obj->existe()) {
            $this->ref_usuario_cad = $ref_usuario_cad;
          }
        }
        elseif (method_exists($tmp_obj, "detalhe")) {
          if ($tmp_obj->detalhe()) {
            $this->ref_usuario_cad = $ref_usuario_cad;
          }
        }
      }
      else {
        if ($db->CampoUnico("SELECT 1 FROM pmieducar.usuario WHERE cod_usuario = '{$ref_usuario_cad}'")) {
          $this->ref_usuario_cad = $ref_usuario_cad;
        }
      }
    }

    if (is_numeric($ref_usuario_exc)) {
      if (class_exists("clsPmieducarUsuario")) {
        $tmp_obj = new clsPmieducarUsuario($ref_usuario_exc);
        if (method_exists($tmp_obj, "existe")) {
          if ($tmp_obj->existe()) {
            $this->ref_usuario_exc = $ref_usuario_exc;
          }
        }
        elseif (method_exists($tmp_obj, "detalhe")) {
          if ($tmp_obj->detalhe()) {
            $this->ref_usuario_exc = $ref_usuario_exc;
          }
        }
      }
      else {
        if ($db->CampoUnico("SELECT 1 FROM pmieducar.usuario WHERE cod_usuario = '{$ref_usuario_exc}'")) {
          $this->ref_usuario_exc = $ref_usuario_exc;
        }
      }
    }

    if (is_numeric($ref_cod_instituicao)) {
      if (class_exists("clsPmieducarInstituicao")) {
        $tmp_obj = new clsPmieducarInstituicao($ref_cod_instituicao);
        if (method_exists($tmp_obj, "existe")) {
          if ($tmp_obj->existe()) {
            $this->ref_cod_instituicao = $ref_cod_instituicao;
          }
        }
        elseif (method_exists($tmp_obj, "detalhe")) {
          if ($tmp_obj->detalhe()) {
            $this->ref_cod_instituicao = $ref_cod_instituicao;
          }
        }
      }
      else {
        if ($db->CampoUnico("SELECT 1 FROM pmieducar.instituicao WHERE cod_instituicao = '{$ref_cod_instituicao}'")) {
          $this->ref_cod_instituicao = $ref_cod_instituicao;
        }
      }
    }

    if (is_numeric($ref_cod_escola_localizacao)) {
      if (class_exists("clsPmieducarEscolaLocalizacao")) {
        $tmp_obj = new clsPmieducarEscolaLocalizacao($ref_cod_escola_localizacao);
        if (method_exists($tmp_obj, "existe")) {
          if ($tmp_obj->existe()) {
            $this->ref_cod_escola_localizacao = $ref_cod_escola_localizacao;
          }
        }
        elseif (method_exists($tmp_obj, "detalhe")) {
          if ($tmp_obj->detalhe()) {
            $this->ref_cod_escola_localizacao = $ref_cod_escola_localizacao;
          }
        }
      }
      else {
        if ($db->CampoUnico("SELECT 1 FROM pmieducar.escola_localizacao WHERE cod_escola_localizacao = '{$ref_cod_escola_localizacao}'")) {
          $this->ref_cod_escola_localizacao = $ref_cod_escola_localizacao;
        }
      }
    }

    if (is_numeric($ref_cod_escola_rede_ensino)) {
      if (class_exists("clsPmieducarEscolaRedeEnsino")) {
        $tmp_obj = new clsPmieducarEscolaRedeEnsino($ref_cod_escola_rede_ensino);
        if (method_exists($tmp_obj, "existe")) {
          if ($tmp_obj->existe()) {
            $this->ref_cod_escola_rede_ensino = $ref_cod_escola_rede_ensino;
          }
        }
        elseif (method_exists($tmp_obj, "detalhe")) {
          if ($tmp_obj->detalhe())
          {
            $this->ref_cod_escola_rede_ensino = $ref_cod_escola_rede_ensino;
          }
        }
      }
      else {
        if ($db->CampoUnico("SELECT 1 FROM pmieducar.escola_rede_ensino WHERE cod_escola_rede_ensino = '{$ref_cod_escola_rede_ensino}'")) {
          $this->ref_cod_escola_rede_ensino = $ref_cod_escola_rede_ensino;
        }
      }
    }

    if (is_numeric($ref_idpes)) {
      if (class_exists("clsCadastroJuridica")) {
        $tmp_obj = new clsCadastroJuridica($ref_idpes);
        if (method_exists($tmp_obj, "existe")) {
          if ($tmp_obj->existe()) {
            $this->ref_idpes = $ref_idpes;
          }
        }
        elseif (method_exists($tmp_obj, "detalhe")) {
          if ($tmp_obj->detalhe()) {
            $this->ref_idpes = $ref_idpes;
          }
        }
      }
      else {
        if ($db->CampoUnico("SELECT 1 FROM cadastro.juridica WHERE idpes = '{$ref_idpes}'")) {
          $this->ref_idpes = $ref_idpes;
        }
      }
    }

    if (is_numeric($cod_escola)) {
      $this->cod_escola = $cod_escola;
    }

    if (is_string($sigla)) {
      $this->sigla = $sigla;
    }

    if (is_string($data_cadastro)) {
      $this->data_cadastro = $data_cadastro;
    }

    if (is_string($data_exclusao)) {
      $this->data_exclusao = $data_exclusao;
    }

    if (is_numeric($ativo)) {
      $this->ativo = $ativo;
    }

    $this->bloquear_lancamento_diario_anos_letivos_encerrados = $bloquear_lancamento_diario_anos_letivos_encerrados;
  }

  /**
   * Cria um novo registro.
   * @return bool
   */
  function cadastra()
  {
    if (is_numeric($this->ref_usuario_cad) && is_numeric($this->ref_cod_instituicao) &&
      is_numeric($this->ref_cod_escola_localizacao) &&
      is_numeric($this->ref_cod_escola_rede_ensino) && is_string($this->sigla)
    ) {
      $db = new clsBanco();

      $campos = "";
      $valores = "";
      $gruda = "";

      if (is_numeric($this->ref_usuario_cad)) {
        $campos .= "{$gruda}ref_usuario_cad";
        $valores .= "{$gruda}'{$this->ref_usuario_cad}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_usuario_exc)) {
        $campos .= "{$gruda}ref_usuario_exc";
        $valores .= "{$gruda}'{$this->ref_usuario_exc}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_cod_instituicao)) {
        $campos .= "{$gruda}ref_cod_instituicao";
        $valores .= "{$gruda}'{$this->ref_cod_instituicao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_cod_escola_localizacao)) {
        $campos .= "{$gruda}ref_cod_escola_localizacao";
        $valores .= "{$gruda}'{$this->ref_cod_escola_localizacao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_cod_escola_rede_ensino)) {
        $campos .= "{$gruda}ref_cod_escola_rede_ensino";
        $valores .= "{$gruda}'{$this->ref_cod_escola_rede_ensino}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_idpes)) {
        $campos .= "{$gruda}ref_idpes";
        $valores .= "{$gruda}'{$this->ref_idpes}'";
        $gruda = ", ";
      }

      if (is_string($this->sigla)) {
        $campos .= "{$gruda}sigla";
        $valores .= "{$gruda}'{$this->sigla}'";
        $gruda = ", ";
      }

      if (is_numeric($this->bloquear_lancamento_diario_anos_letivos_encerrados)) {
        $campos .= "{$gruda}bloquear_lancamento_diario_anos_letivos_encerrados";
        $valores .= "{$gruda}'{$this->bloquear_lancamento_diario_anos_letivos_encerrados}'";
        $gruda = ", ";
      }

      if (is_numeric($this->situacao_funcionamento)) {
        $campos .= "{$gruda}situacao_funcionamento";
        $valores .= "{$gruda}'{$this->situacao_funcionamento}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_administrativa)) {
        $campos .= "{$gruda}dependencia_administrativa";
        $valores .= "{$gruda}'{$this->dependencia_administrativa}'";
        $gruda = ", ";
      }

      if (is_numeric($this->regulamentacao)) {
        $campos .= "{$gruda}regulamentacao";
        $valores .= "{$gruda}'{$this->regulamentacao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->acesso)) {
        $campos .= "{$gruda}acesso";
        $valores .= "{$gruda}'{$this->acesso}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_idpes_gestor)) {
        $campos .= "{$gruda}ref_idpes_gestor";
        $valores .= "{$gruda}'{$this->ref_idpes_gestor}'";
        $gruda = ", ";
      }

      if (is_numeric($this->cargo_gestor)) {
        $campos .= "{$gruda}cargo_gestor";
        $valores .= "{$gruda}'{$this->cargo_gestor}'";
        $gruda = ", ";
      }

      if (is_numeric($this->condicao)) {
        $campos .= "{$gruda}condicao";
        $valores .= "{$gruda}'{$this->condicao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->num_pavimentos)) {
        $campos .= "{$gruda}num_pavimentos";
        $valores .= "{$gruda}'{$this->num_pavimentos}'";
        $gruda = ", ";
      }

      if (is_string($this->decreto_criacao)) {
        $campos .= "{$gruda}decreto_criacao";
        $valores .= "{$gruda}'{$this->decreto_criacao}'";
        $gruda = ", ";
      }

      if (is_string($this->area_terreno_total)) {
        $campos .= "{$gruda}area_terreno_total";
        $valores .= "{$gruda}'{$this->area_terreno_total}'";
        $gruda = ", ";
      }

      if (is_string($this->area_disponivel)) {
        $campos .= "{$gruda}area_disponivel";
        $valores .= "{$gruda}'{$this->area_disponivel}'";
        $gruda = ", ";
      }

      if (is_string($this->area_construida)) {
        $campos .= "{$gruda}area_construida";
        $valores .= "{$gruda}'{$this->area_construida}'";
        $gruda = ", ";
      }

      if (is_numeric($this->tipo_piso)) {
        $campos .= "{$gruda}tipo_piso";
        $valores .= "{$gruda}'{$this->tipo_piso}'";
        $gruda = ", ";
      }

      if (is_numeric($this->medidor_energia)) {
        $campos .= "{$gruda}medidor_energia";
        $valores .= "{$gruda}'{$this->medidor_energia}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_consumida)) {
        $campos .= "{$gruda}agua_consumida";
        $valores .= "{$gruda}'{$this->agua_consumida}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_rede_publica)) {
        $campos .= "{$gruda}agua_rede_publica";
        $valores .= "{$gruda}'{$this->agua_rede_publica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_poco_artesiano)) {
        $campos .= "{$gruda}agua_poco_artesiano";
        $valores .= "{$gruda}'{$this->agua_poco_artesiano}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_cacimba_cisterna_poco)) {
        $campos .= "{$gruda}agua_cacimba_cisterna_poco";
        $valores .= "{$gruda}'{$this->agua_cacimba_cisterna_poco}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_fonte_rio)) {
        $campos .= "{$gruda}agua_fonte_rio";
        $valores .= "{$gruda}'{$this->agua_fonte_rio}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_inexistente)) {
        $campos .= "{$gruda}agua_inexistente";
        $valores .= "{$gruda}'{$this->agua_inexistente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_rede_publica)) {
        $campos .= "{$gruda}energia_rede_publica";
        $valores .= "{$gruda}'{$this->energia_rede_publica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_gerador)) {
        $campos .= "{$gruda}energia_gerador";
        $valores .= "{$gruda}'{$this->energia_gerador}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_outros)) {
        $campos .= "{$gruda}energia_outros";
        $valores .= "{$gruda}'{$this->energia_outros}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_inexistente)) {
        $campos .= "{$gruda}energia_inexistente";
        $valores .= "{$gruda}'{$this->energia_inexistente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->esgoto_rede_publica)) {
        $campos .= "{$gruda}esgoto_rede_publica";
        $valores .= "{$gruda}'{$this->esgoto_rede_publica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->esgoto_fossa)) {
        $campos .= "{$gruda}esgoto_fossa";
        $valores .= "{$gruda}'{$this->esgoto_fossa}'";
        $gruda = ", ";
      }

      if (is_numeric($this->esgoto_inexistente)) {
        $campos .= "{$gruda}esgoto_inexistente";
        $valores .= "{$gruda}'{$this->esgoto_inexistente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_coleta_periodica)) {
        $campos .= "{$gruda}lixo_coleta_periodica";
        $valores .= "{$gruda}'{$this->lixo_coleta_periodica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_queima)) {
        $campos .= "{$gruda}lixo_queima";
        $valores .= "{$gruda}'{$this->lixo_queima}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_joga_outra_area)) {
        $campos .= "{$gruda}lixo_joga_outra_area";
        $valores .= "{$gruda}'{$this->lixo_joga_outra_area}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_recicla)) {
        $campos .= "{$gruda}lixo_recicla";
        $valores .= "{$gruda}'{$this->lixo_recicla}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_enterra)) {
        $campos .= "{$gruda}lixo_enterra";
        $valores .= "{$gruda}'{$this->lixo_enterra}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_outros)) {
        $campos .= "{$gruda}lixo_outros";
        $valores .= "{$gruda}'{$this->lixo_outros}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_diretoria)) {
        $campos .= "{$gruda}dependencia_sala_diretoria";
        $valores .= "{$gruda}'{$this->dependencia_sala_diretoria}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_professores)) {
        $campos .= "{$gruda}dependencia_sala_professores";
        $valores .= "{$gruda}'{$this->dependencia_sala_professores}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_secretaria)) {
        $campos .= "{$gruda}dependencia_sala_secretaria";
        $valores .= "{$gruda}'{$this->dependencia_sala_secretaria}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_laboratorio_informatica)) {
        $campos .= "{$gruda}dependencia_laboratorio_informatica";
        $valores .= "{$gruda}'{$this->dependencia_laboratorio_informatica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_laboratorio_ciencias)) {
        $campos .= "{$gruda}dependencia_laboratorio_ciencias";
        $valores .= "{$gruda}'{$this->dependencia_laboratorio_ciencias}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_aee)) {
        $campos .= "{$gruda}dependencia_sala_aee";
        $valores .= "{$gruda}'{$this->dependencia_sala_aee}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_quadra_coberta)) {
        $campos .= "{$gruda}dependencia_quadra_coberta";
        $valores .= "{$gruda}'{$this->dependencia_quadra_coberta}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_quadra_descoberta)) {
        $campos .= "{$gruda}dependencia_quadra_descoberta";
        $valores .= "{$gruda}'{$this->dependencia_quadra_descoberta}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_cozinha)) {
        $campos .= "{$gruda}dependencia_cozinha";
        $valores .= "{$gruda}'{$this->dependencia_cozinha}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_biblioteca)) {
        $campos .= "{$gruda}dependencia_biblioteca";
        $valores .= "{$gruda}'{$this->dependencia_biblioteca}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_leitura)) {
        $campos .= "{$gruda}dependencia_sala_leitura";
        $valores .= "{$gruda}'{$this->dependencia_sala_leitura}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_parque_infantil)) {
        $campos .= "{$gruda}dependencia_parque_infantil";
        $valores .= "{$gruda}'{$this->dependencia_parque_infantil}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_bercario)) {
        $campos .= "{$gruda}dependencia_bercario";
        $valores .= "{$gruda}'{$this->dependencia_bercario}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_fora)) {
        $campos .= "{$gruda}dependencia_banheiro_fora";
        $valores .= "{$gruda}'{$this->dependencia_banheiro_fora}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_dentro)) {
        $campos .= "{$gruda}dependencia_banheiro_dentro";
        $valores .= "{$gruda}'{$this->dependencia_banheiro_dentro}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_infantil)) {
        $campos .= "{$gruda}dependencia_banheiro_infantil";
        $valores .= "{$gruda}'{$this->dependencia_banheiro_infantil}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_deficiente)) {
        $campos .= "{$gruda}dependencia_banheiro_deficiente";
        $valores .= "{$gruda}'{$this->dependencia_banheiro_deficiente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_deficiente)) {
        $campos .= "{$gruda}dependencia_banheiro_deficiente";
        $valores .= "{$gruda}'{$this->dependencia_banheiro_deficiente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_chuveiro)) {
        $campos .= "{$gruda}dependencia_banheiro_chuveiro";
        $valores .= "{$gruda}'{$this->dependencia_banheiro_chuveiro}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_refeitorio)) {
        $campos .= "{$gruda}dependencia_refeitorio";
        $valores .= "{$gruda}'{$this->dependencia_refeitorio}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_dispensa)) {
        $campos .= "{$gruda}dependencia_dispensa";
        $valores .= "{$gruda}'{$this->dependencia_dispensa}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_aumoxarifado)) {
        $campos .= "{$gruda}dependencia_aumoxarifado";
        $valores .= "{$gruda}'{$this->dependencia_aumoxarifado}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_auditorio)) {
        $campos .= "{$gruda}dependencia_auditorio";
        $valores .= "{$gruda}'{$this->dependencia_auditorio}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_patio_coberto)) {
        $campos .= "{$gruda}dependencia_patio_coberto";
        $valores .= "{$gruda}'{$this->dependencia_patio_coberto}'";
        $gruda = ", ";
      }

      $campos .= "{$gruda}data_cadastro";
      $valores .= "{$gruda}NOW()";
      $gruda = ", ";

      $campos .= "{$gruda}ativo";
      $valores .= "{$gruda}'1'";

      $db->Consulta("INSERT INTO {$this->_tabela} ($campos) VALUES ($valores)");
      $recordId = $db->InsertId("{$this->_tabela}_cod_escola_seq");

      return $recordId;
    }
    else {
      echo "<br><br>is_numeric($this->ref_usuario_cad) && is_numeric($this->ref_cod_instituicao) && is_numeric($this->ref_cod_escola_localizacao) && is_numeric($this->ref_cod_escola_rede_ensino) && is_string($this->sigla )";
    }

    return FALSE;
  }

  /**
   * Edita os dados de um registro.
   * @return bool
   */
  function edita()
  {
    if (is_numeric($this->cod_escola)) {
      $db = new clsBanco();
      $set = "";

      if (is_numeric($this->ref_usuario_cad)) {
        $set .= "{$gruda}ref_usuario_cad = '{$this->ref_usuario_cad}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_usuario_exc)) {
        $set .= "{$gruda}ref_usuario_exc = '{$this->ref_usuario_exc}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_cod_instituicao)) {
        $set .= "{$gruda}ref_cod_instituicao = '{$this->ref_cod_instituicao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_cod_escola_localizacao)) {
        $set .= "{$gruda}ref_cod_escola_localizacao = '{$this->ref_cod_escola_localizacao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_cod_escola_rede_ensino)) {
        $set .= "{$gruda}ref_cod_escola_rede_ensino = '{$this->ref_cod_escola_rede_ensino}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_idpes)) {
        $set .= "{$gruda}ref_idpes = '{$this->ref_idpes}'";
        $gruda = ", ";
      }

      if (is_string($this->sigla)) {
        $set .= "{$gruda}sigla = '{$this->sigla}'";
        $gruda = ", ";
      }

      if (is_string($this->data_cadastro)) {
        $set .= "{$gruda}data_cadastro = '{$this->data_cadastro}'";
        $gruda = ", ";
      }

      $set .= "{$gruda}data_exclusao = NOW()";
      $gruda = ", ";

      if (is_numeric($this->ativo)) {
        $set .= "{$gruda}ativo = '{$this->ativo}'";
        $gruda = ", ";
      }

      if (is_numeric($this->bloquear_lancamento_diario_anos_letivos_encerrados)) {
        $set .= "{$gruda}bloquear_lancamento_diario_anos_letivos_encerrados = '{$this->bloquear_lancamento_diario_anos_letivos_encerrados}'";
        $gruda = ", ";
      }

      if (is_numeric($this->situacao_funcionamento)) {
        $set .= "{$gruda}situacao_funcionamento = '{$this->situacao_funcionamento}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_administrativa)) {
        $set .= "{$gruda}dependencia_administrativa = '{$this->dependencia_administrativa}'";
        $gruda = ", ";
      }

      if (is_numeric($this->regulamentacao)) {
        $set .= "{$gruda}regulamentacao = '{$this->regulamentacao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->acesso)) {
        $set .= "{$gruda}acesso = '{$this->acesso}'";
        $gruda = ", ";
      }

      if (is_numeric($this->ref_idpes_gestor)) {
        $set .= "{$gruda}ref_idpes_gestor = '{$this->ref_idpes_gestor}'";
        $gruda = ", ";
      }

      if (is_numeric($this->cargo_gestor)) {
        $set .= "{$gruda}cargo_gestor = '{$this->cargo_gestor}'";
        $gruda = ", ";
      }

      if (is_numeric($this->num_pavimentos)) {
        $set .= "{$gruda}num_pavimentos = '{$this->num_pavimentos}'";
        $gruda = ", ";
      }

      if (is_numeric($this->condicao)) {
        $set .= "{$gruda}condicao = '{$this->condicao}'";
        $gruda = ", ";
      }

      if (is_string($this->area_terreno_total)) {
        $set .= "{$gruda}area_terreno_total = '{$this->area_terreno_total}'";
        $gruda = ", ";
      }

      if (is_string($this->area_construida)) {
        $set .= "{$gruda}area_construida = '{$this->area_construida}'";
        $gruda = ", ";
      }

      if (is_string($this->area_disponivel)) {
        $set .= "{$gruda}area_disponivel = '{$this->area_disponivel}'";
        $gruda = ", ";
      }

      if (is_string($this->decreto_criacao)) {
        $set .= "{$gruda}decreto_criacao = '{$this->decreto_criacao}'";
        $gruda = ", ";
      }

      if (is_numeric($this->tipo_piso)) {
        $set .= "{$gruda}tipo_piso = '{$this->tipo_piso}'";
        $gruda = ", ";
      }

      if (is_numeric($this->medidor_energia)) {
        $set .= "{$gruda}medidor_energia = '{$this->medidor_energia}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_consumida)) {
        $set .= "{$gruda}agua_consumida = '{$this->agua_consumida}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_rede_publica)) {
        $set .= "{$gruda}agua_rede_publica = '{$this->agua_rede_publica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_poco_artesiano)) {
        $set .= "{$gruda}agua_poco_artesiano = '{$this->agua_poco_artesiano}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_cacimba_cisterna_poco)) {
        $set .= "{$gruda}agua_cacimba_cisterna_poco = '{$this->agua_cacimba_cisterna_poco}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_fonte_rio)) {
        $set .= "{$gruda}agua_fonte_rio = '{$this->agua_fonte_rio}'";
        $gruda = ", ";
      }

      if (is_numeric($this->agua_inexistente)) {
        $set .= "{$gruda}agua_inexistente = '{$this->agua_inexistente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_rede_publica)) {
        $set .= "{$gruda}energia_rede_publica = '{$this->energia_rede_publica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_gerador)) {
        $set .= "{$gruda}energia_gerador = '{$this->energia_gerador}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_inexistente)) {
        $set .= "{$gruda}energia_inexistente = '{$this->energia_inexistente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->energia_outros)) {
        $set .= "{$gruda}energia_outros = '{$this->energia_outros}'";
        $gruda = ", ";
      }

      if (is_numeric($this->esgoto_rede_publica)) {
        $set .= "{$gruda}esgoto_rede_publica = '{$this->esgoto_rede_publica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->esgoto_fossa)) {
        $set .= "{$gruda}esgoto_fossa = '{$this->esgoto_fossa}'";
        $gruda = ", ";
      }

      if (is_numeric($this->esgoto_inexistente)) {
        $set .= "{$gruda}esgoto_inexistente = '{$this->esgoto_inexistente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_coleta_periodica)) {
        $set .= "{$gruda}lixo_coleta_periodica = '{$this->lixo_coleta_periodica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_queima)) {
        $set .= "{$gruda}lixo_queima = '{$this->lixo_queima}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_joga_outra_area)) {
        $set .= "{$gruda}lixo_joga_outra_area = '{$this->lixo_joga_outra_area}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_recicla)) {
        $set .= "{$gruda}lixo_recicla = '{$this->lixo_recicla}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_enterra)) {
        $set .= "{$gruda}lixo_enterra = '{$this->lixo_enterra}'";
        $gruda = ", ";
      }

      if (is_numeric($this->lixo_outros)) {
        $set .= "{$gruda}lixo_outros = '{$this->lixo_outros}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_diretoria)) {
        $set .= "{$gruda}dependencia_sala_diretoria = '{$this->dependencia_sala_diretoria}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_professores)) {
        $set .= "{$gruda}dependencia_sala_professores = '{$this->dependencia_sala_professores}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_secretaria)) {
        $set .= "{$gruda}dependencia_sala_secretaria = '{$this->dependencia_sala_secretaria}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_laboratorio_informatica)) {
        $set .= "{$gruda}dependencia_laboratorio_informatica = '{$this->dependencia_laboratorio_informatica}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_laboratorio_ciencias)) {
        $set .= "{$gruda}dependencia_laboratorio_ciencias = '{$this->dependencia_laboratorio_ciencias}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_aee)) {
        $set .= "{$gruda}dependencia_sala_aee = '{$this->dependencia_sala_aee}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_quadra_coberta)) {
        $set .= "{$gruda}dependencia_quadra_coberta = '{$this->dependencia_quadra_coberta}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_quadra_descoberta)) {
        $set .= "{$gruda}dependencia_quadra_descoberta = '{$this->dependencia_quadra_descoberta}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_cozinha)) {
        $set .= "{$gruda}dependencia_cozinha = '{$this->dependencia_cozinha}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_biblioteca)) {
        $set .= "{$gruda}dependencia_biblioteca = '{$this->dependencia_biblioteca}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_sala_leitura)) {
        $set .= "{$gruda}dependencia_sala_leitura = '{$this->dependencia_sala_leitura}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_parque_infantil)) {
        $set .= "{$gruda}dependencia_parque_infantil = '{$this->dependencia_parque_infantil}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_bercario)) {
        $set .= "{$gruda}dependencia_bercario = '{$this->dependencia_bercario}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_fora)) {
        $set .= "{$gruda}dependencia_banheiro_fora = '{$this->dependencia_banheiro_fora}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_dentro)) {
        $set .= "{$gruda}dependencia_banheiro_dentro = '{$this->dependencia_banheiro_dentro}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_infantil)) {
        $set .= "{$gruda}dependencia_banheiro_infantil = '{$this->dependencia_banheiro_infantil}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_deficiente)) {
        $set .= "{$gruda}dependencia_banheiro_deficiente = '{$this->dependencia_banheiro_deficiente}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_banheiro_chuveiro)) {
        $set .= "{$gruda}dependencia_banheiro_chuveiro = '{$this->dependencia_banheiro_chuveiro}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_refeitorio)) {
        $set .= "{$gruda}dependencia_refeitorio = '{$this->dependencia_refeitorio}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_dispensa)) {
        $set .= "{$gruda}dependencia_dispensa = '{$this->dependencia_dispensa}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_aumoxarifado)) {
        $set .= "{$gruda}dependencia_aumoxarifado = '{$this->dependencia_aumoxarifado}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_auditorio)) {
        $set .= "{$gruda}dependencia_auditorio = '{$this->dependencia_auditorio}'";
        $gruda = ", ";
      }

      if (is_numeric($this->dependencia_patio_coberto)) {
        $set .= "{$gruda}dependencia_patio_coberto = '{$this->dependencia_patio_coberto}'";
        $gruda = ", ";
      }

      if ($set) {
        $db->Consulta("UPDATE {$this->_tabela} SET $set WHERE cod_escola = '{$this->cod_escola}'");
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * Retorna uma lista de registros filtrados de acordo com os par�metros.
   * @return array
   */
  public function lista($int_cod_escola = NULL, $int_ref_usuario_cad = NULL,
    $int_ref_usuario_exc = NULL, $int_ref_cod_instituicao = NULL,
    $int_ref_cod_escola_localizacao = NULL, $int_ref_cod_escola_rede_ensino = NULL,
    $int_ref_idpes = NULL, $str_sigla = NULL, $date_data_cadastro = NULL,
    $date_data_exclusao = NULL, $int_ativo = NULL, $str_nome = NULL,
    $escola_sem_avaliacao = NULL)
  {

    $sql = "
      SELECT * FROM
      (
        SELECT j.fantasia AS nome, {$this->_campos_lista}, 1 AS tipo_cadastro
          FROM {$this->_tabela} e, cadastro.juridica j
          WHERE e.ref_idpes = j.idpes
        UNION
        SELECT c.nm_escola AS nome, {$this->_campos_lista}, 2 AS tipo_cadastro
          FROM {$this->_tabela} e, pmieducar.escola_complemento c
          WHERE e.cod_escola = c.ref_cod_escola
      ) AS sub";
    $filtros = "";

    $whereAnd = " WHERE ";

    if (is_numeric($int_cod_escola)) {
      $filtros .= "{$whereAnd} cod_escola = '{$int_cod_escola}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ref_usuario_cad)) {
      $filtros .= "{$whereAnd} ref_usuario_cad = '{$int_ref_usuario_cad}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ref_usuario_exc)) {
      $filtros .= "{$whereAnd} ref_usuario_exc = '{$int_ref_usuario_exc}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ref_cod_instituicao)) {
      $filtros .= "{$whereAnd} ref_cod_instituicao = '{$int_ref_cod_instituicao}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ref_cod_escola_localizacao)) {
      $filtros .= "{$whereAnd} ref_cod_escola_localizacao = '{$int_ref_cod_escola_localizacao}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ref_cod_escola_rede_ensino)) {
      $filtros .= "{$whereAnd} ref_cod_escola_rede_ensino = '{$int_ref_cod_escola_rede_ensino}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ref_idpes)) {
      $filtros .= "{$whereAnd} ref_idpes = '{$int_ref_idpes}'";
      $whereAnd = " AND ";
    }

    if (is_string($str_sigla)) {
      $filtros .= "{$whereAnd} sigla LIKE '%{$str_sigla}%'";
      $whereAnd = " AND ";
    }

    if (is_string($date_data_cadastro_ini)) {
      $filtros .= "{$whereAnd} data_cadastro >= '{$date_data_cadastro_ini}'";
      $whereAnd = " AND ";
    }

    if (is_string($date_data_cadastro_fim)) {
      $filtros .= "{$whereAnd} data_cadastro <= '{$date_data_cadastro_fim}'";
      $whereAnd = " AND ";
    }

    if (is_string($date_data_exclusao_ini)) {
      $filtros .= "{$whereAnd} data_exclusao >= '{$date_data_exclusao_ini}'";
      $whereAnd = " AND ";
    }

    if (is_string($date_data_exclusao_fim)) {
      $filtros .= "{$whereAnd} data_exclusao <= '{$date_data_exclusao_fim}'";
      $whereAnd = " AND ";
    }

    if (is_numeric($int_ativo)) {
      $filtros .= "{$whereAnd} ativo = '{$int_ativo}'";
      $whereAnd = " AND ";
    }else{
      $filtros .= "{$whereAnd} ativo = 1";
      $whereAnd = " AND ";
    }

    if (is_string( $str_nome)) {
      $filtros .= "{$whereAnd} nome LIKE '%{$str_nome}%'";
      $whereAnd = " AND ";
    }

    if (is_bool($escola_sem_avaliacao)) {
      if (dbBool($escola_sem_avaliacao)) {
        $filtros .= "{$whereAnd} NOT EXISTS (SELECT 1 FROM pmieducar.escola_curso ec, pmieducar.curso c WHERE
                        ec.ref_cod_escola = cod_escola
                        AND ec.ref_cod_curso = c.cod_curso
                        AND ec.ativo = 1 AND c.ativo = 1)";
      }
      else {
        $filtros .= "{$whereAnd} EXISTS (SELECT 1 FROM pmieducar.escola_curso ec, pmieducar.curso c WHERE
                        ec.ref_cod_escola = cod_escola
                        AND ec.ref_cod_curso = c.cod_curso
                        AND ec.ativo = 1 AND c.ativo = 1)";
      }
    }

    $db = new clsBanco();
    $countCampos = count(explode(',', $this->_campos_lista));
    $resultado = array();
    $sql .= $filtros . $this->getOrderby() . $this->getLimite();

    $db->Consulta("
        SELECT COUNT(0) FROM
        (
          SELECT j.fantasia AS nome, {$this->_campos_lista}, 1 AS tipo_cadastro
          FROM {$this->_tabela} e, cadastro.juridica j
          WHERE e.ref_idpes = j.idpes
        UNION
          SELECT c.nm_escola AS nome, {$this->_campos_lista}, 2 AS tipo_cadastro
          FROM {$this->_tabela} e, pmieducar.escola_complemento c
          WHERE e.cod_escola = c.ref_cod_escola
        ) AS sub
        {$filtros}
    ");

    $db->ProximoRegistro();
    list($this->_total) = $db->Tupla();
    $db->Consulta($sql);

    if($countCampos > 1) {
      while ($db->ProximoRegistro()) {
        $tupla = $db->Tupla();
        $resultado[] = $tupla;
      }
    }
    else {
      while ($db->ProximoRegistro()) {
        $tupla = $db->Tupla();
        $resultado[] = $tupla[$this->_campos_lista];
        $this->_total = count( $tupla);
      }
    }

    if (count($resultado)) {
      return $resultado;
    }

    return FALSE;
  }

  /**
   * Retorna um array com os dados de um registro.
   * @return array
   */
  function detalhe()
  {
    if (is_numeric($this->cod_escola)) {
      $db = new clsBanco();
      $db->Consulta( "
        SELECT * FROM
        (
          SELECT c.nm_escola AS nome, {$this->_todos_campos}, 2 AS tipo_cadastro
          FROM {$this->_tabela} e, pmieducar.escola_complemento c
          WHERE e.cod_escola = c.ref_cod_escola

        UNION

          SELECT j.fantasia AS nome, {$this->_todos_campos}, 1 AS tipo_cadastro
          FROM {$this->_tabela} e, cadastro.juridica j
          WHERE e.ref_idpes = j.idpes


        ) AS sub WHERE cod_escola = '{$this->cod_escola}'"
      );
      $db->ProximoRegistro();
      return $db->Tupla();
    }

    return FALSE;
  }

  /**
   * Retorna um array com os dados de um registro.
   * @return array
   */
  function existe()
  {
    if (is_numeric($this->cod_escola)) {
      $db = new clsBanco();
      $db->Consulta("SELECT 1 FROM {$this->_tabela} WHERE cod_escola = '{$this->cod_escola}'");
      $db->ProximoRegistro();
      return $db->Tupla();
    }

    return FALSE;
  }

  /**
   * Exclui um registro.
   * @return bool
   */
  function excluir()
  {
    if (is_numeric($this->cod_escola)) {
      $this->ativo = 0;
      return $this->edita();
    }

    return FALSE;
  }

  /**
   * Define quais campos da tabela ser�o selecionados no m�todo Lista().
   */
  function setCamposLista($str_campos)
  {
    $this->_campos_lista = $str_campos;
  }

  /**
   * Define que o m�todo Lista() deverpa retornar todos os campos da tabela.
   */
  function resetCamposLista()
  {
    $this->_campos_lista = $this->_todos_campos;
  }

  /**
   * Define limites de retorno para o m�todo Lista().
   */
  function setLimite($intLimiteQtd, $intLimiteOffset = NULL)
  {
    $this->_limite_quantidade = $intLimiteQtd;
    $this->_limite_offset = $intLimiteOffset;
  }

  /**
   * Retorna a string com o trecho da query respons�vel pelo limite de
   * registros retornados/afetados.
   *
   * @return string
   */
  function getLimite()
  {
    if (is_numeric($this->_limite_quantidade)) {
      $retorno = " LIMIT {$this->_limite_quantidade}";
      if (is_numeric($this->_limite_offset)) {
        $retorno .= " OFFSET {$this->_limite_offset} ";
      }
      return $retorno;
    }
    return '';
  }

  /**
   * Define o campo para ser utilizado como ordena��o no m�todo Lista().
   */
  function setOrderby($strNomeCampo)
  {
    if (is_string($strNomeCampo) && $strNomeCampo ) {
      $this->_campo_order_by = $strNomeCampo;
    }
  }

  /**
   * Retorna a string com o trecho da query respons�vel pela Ordena��o dos
   * registros.
   *
   * @return string
   */
  function getOrderby()
  {
    if (is_string($this->_campo_order_by)) {
      return " ORDER BY {$this->_campo_order_by} ";
    }
    return '';
  }
}
