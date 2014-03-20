<?php

#error_reporting(E_ALL);
#ini_set("display_errors", 1);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	*																	     *
	*	@author Prefeitura Municipal de Itaja�								 *
	*	@updated 29/03/2007													 *
	*   Pacote: i-PLB Software P�blico Livre e Brasileiro					 *
	*																		 *
	*	Copyright (C) 2006	PMI - Prefeitura Municipal de Itaja�			 *
	*						ctima@itajai.sc.gov.br					    	 *
	*																		 *
	*	Este  programa  �  software livre, voc� pode redistribu�-lo e/ou	 *
	*	modific�-lo sob os termos da Licen�a P�blica Geral GNU, conforme	 *
	*	publicada pela Free  Software  Foundation,  tanto  a vers�o 2 da	 *
	*	Licen�a   como  (a  seu  crit�rio)  qualquer  vers�o  mais  nova.	 *
	*																		 *
	*	Este programa  � distribu�do na expectativa de ser �til, mas SEM	 *
	*	QUALQUER GARANTIA. Sem mesmo a garantia impl�cita de COMERCIALI-	 *
	*	ZA��O  ou  de ADEQUA��O A QUALQUER PROP�SITO EM PARTICULAR. Con-	 *
	*	sulte  a  Licen�a  P�blica  Geral  GNU para obter mais detalhes.	 *
	*																		 *
	*	Voc�  deve  ter  recebido uma c�pia da Licen�a P�blica Geral GNU	 *
	*	junto  com  este  programa. Se n�o, escreva para a Free Software	 *
	*	Foundation,  Inc.,  59  Temple  Place,  Suite  330,  Boston,  MA	 *
	*	02111-1307, USA.													 *
	*																		 *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
require_once ("include/clsBase.inc.php");
require_once ("include/clsCadastro.inc.php");
require_once ("include/clsBanco.inc.php");
require_once( "include/pmieducar/geral.inc.php" );
require_once 'Portabilis/View/Helper/Application.php';

class clsIndexBase extends clsBase
{
	function Formular()
	{
		$this->SetTitulo( "{$this->_instituicao} i-Educar - Escola" );
		$this->processoAp = "561";
	}
}

class indice extends clsCadastro
{
	/**
	 * Referencia pega da session para o idpes do usuario atual
	 *
	 * @var int
	 */
	var $pessoa_logada;

	var $cod_escola;
	var $ref_usuario_cad;
	var $ref_usuario_exc;
	var $ref_cod_instituicao;
	var $ref_cod_escola_localizacao;
	var $ref_cod_escola_rede_ensino;
	var $ref_idpes;
	var $cnpj;
	var $sigla;
	var $data_cadastro;
	var $data_exclusao;
	var $ativo;
	var $nm_escola;
	var $passou;
	var $escola_curso;
	var $ref_cod_curso;
	var $fantasia;

	var $sigla_uf_;
	var $cidade_;
	var $cep_;
	var $idtlog_;
	var $idbai_;


	var $endereco;
	var $cep;
	var $ref_bairro;
	var $p_ddd_telefone_1;
	var $p_telefone_1;
	var $p_ddd_telefone_2;
	var $p_telefone_2;
	var $p_ddd_telefone_mov;
	var $p_telefone_mov;
	var $p_ddd_telefone_fax;
	var $p_telefone_fax;
	var $p_email;
	var $p_http;
	var $tipo_pessoa;
	var $cidade;
	var $bairro;
	var $logradouro;
	var $idlog;
	var $idbai;
	var $idtlog;
	var $sigla_uf;
	var $complemento;
	var $numero;
	var $andar;

	var $situacao_funcionamento;
	var $dependencia_administrativa;
	var $regulamentacao;
	var $acesso;
	var $gestor_id;
	var $cargo_gestor;	
	var $condicao;	
	var $decreto_criacao;	
	var $area_terreno_total;	
	var $area_construida;	
	var $area_disponivel;	
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

	var $incluir_curso;
	var $excluir_curso;

	var $sem_cnpj;
	var $com_cnpj;

	var $isEnderecoExterno = 0;

	function Inicializar()
	{
		$retorno = "Novo";
		@session_start();
		$this->pessoa_logada = $_SESSION['id_pessoa'];
		@session_write_close();

		$obj_permissoes = new clsPermissoes();
		$obj_permissoes->permissao_cadastra( 561, $this->pessoa_logada, 7, "educar_escola_lst.php" );

		$this->cod_escola = $_GET["cod_escola"];

		$this->sem_cnpj = false;

		// verifica se eh cadastro ou edicao de uma escola sem CNPJ
//		if (is_numeric( $_POST["sem_cnpj"] ) && !$this->ref_idpes)
//		{
//			$this->passo = 3;
////			$retorno = "Novo";
//		}
//		else if ($_POST['cnpj'])
//		{
//			$retorno = "Editar";
//		}// verifica se eh um novo cadastro
//		elseif ($_POST['cnpj'] == "" && empty($_POST))
//		{
//			$this->passo = 1;
//		}// verifica se eh uma cadastro ou edicao de uma escola com CNPJ
//		else
//		{
//			$this->passo = 2;
//		}

		// cadastro Novo sem CNPJ
		if (is_numeric( $_POST["sem_cnpj"] ) && !$this->cod_escola)
		{
//			$this->passo = 3;
			// vai para Novo, + o cadastro sera sem CNPJ
//			die("Sem CNPJ");
			$this->sem_cnpj = true;
			$retorno = "Novo";

		}// cadastro Novo com CNPJ
		else if ($_POST["cnpj"])
		{
			$this->com_cnpj = true;
//			echo "<pre>";print_r($_POST["cnpj"]);
//			echo idFederal2int($_POST["cnpj"]);

			$obj_juridica = new clsPessoaJuridica();
			$lst_juridica = $obj_juridica->lista( idFederal2int($_POST["cnpj"]) );
			// caso exista o CNPJ na BD
			if (is_array($lst_juridica))
			{
//				die("juridica");
				$retorno = "Editar";
				$det_juridica = array_shift($lst_juridica);
				$this->ref_idpes = $det_juridica["idpes"];

				$obj = new clsPmieducarEscola();
				$lst_escola = $obj->lista( null,null,null,null,null,null,$this->ref_idpes,null,null,null,1 );
				if (is_array($lst_escola))
				{
					$registro = array_shift($lst_escola);
					$this->cod_escola = $registro["cod_escola"];
				}

//				echo "idpes: ".$this->ref_idpes;
			}// caso nao exista o CNPJ
			else
			{
//				die("novo");
				$retorno = "Editar";
			}
		}// cadastro Editar
		if (is_numeric( $this->cod_escola ) && !$_POST["passou"])
		{
			$obj = new clsPmieducarEscola( $this->cod_escola );
			$registro = $obj->detalhe();

			if( $registro["ref_idpes"] )
			{
				$this->com_cnpj = true;
			}
			else
			{
				$this->sem_cnpj = true;
			}

			if( $registro)
			{

				foreach( $registro AS $campo => $val )	// passa todos os valores obtidos no registro para atributos do objeto
					$this->$campo = $val;

				$objEndereco = new clsPessoaEndereco( $this->ref_idpes );
						$detEndereco = $objEndereco->detalhe();

						if ($detEndereco) {

							$this->isEnderecoExterno = 0;
						}else
						{

							$this->isEnderecoExterno = 1;
						}

					$this->fantasia = $registro['nome'];

				$objJuridica = new clsPessoaJuridica( $this->ref_idpes );
				$det = $objJuridica->detalhe();
				$this->cnpj = int2CNPJ($det["cnpj"]);

				$this->fexcluir = $obj_permissoes->permissao_excluir( 561, $this->pessoa_logada, 3 );
				$retorno = "Editar";
				if( $registro["tipo_cadastro"] == 1 )
				{
					$objJuridica = new clsPessoaJuridica( false, idFederal2int( $this->cnpj ) );
					$det = $objJuridica->detalhe();
					$objPessoa = new clsPessoaFj( $det["idpes"] );
					list( $this->endereco,
						  $this->cep,
						  $this->ref_bairro,
						  $this->p_ddd_telefone_1,
						  $this->p_telefone_1,
						  $this->p_ddd_telefone_2,
						  $this->p_telefone_2,
						  $this->p_ddd_telefone_mov,
						  $this->p_telefone_mov,
						  $this->p_ddd_telefone_fax,
						  $this->p_telefone_fax,
						  $this->p_email,
						  $this->p_http,
						  $this->tipo_pessoa,
						  $this->cidade,
						  $this->bairro,
						  $this->logradouro,
						  $this->idlog,
						  $this->idbai,
						  $this->idtlog,
						  $this->sigla_uf,
						  $this->complemento,
						  $this->numero,
						  $this->andar ) = $objPessoa->queryRapida( $det["idpes"],
						  											"endereco",
						  											"cep",
						  											"bairro",
						  											"ddd_1",
						  											"fone_1",
						  											"ddd_2",
						  											"fone_2",
						  											"ddd_mov",
						  											"fone_mov",
						  											"ddd_fax",
						  											"fone_fax",
						  											"email",
						  											"url",
						  											"tipo",
						  											"cidade",
						  											"bairro",
						  											"logradouro",
						  											"idlog",
						  											"idbai",
						  											"idtlog",
						  											"sigla_uf",
						  											"complemento",
						  											"numero",
						  											"andar" );


				}
				else
				{

					$objEscolaComplemento = new clsPmieducarEscolaComplemento( $this->cod_escola );
					$detComplemento = $objEscolaComplemento->detalhe();
					foreach ( $detComplemento AS $campo => $val )
						$this->$campo = $val;

					$this->cep_ = $this->cep;
					$this->p_email = $this->email;
					$this->cidade = $this->municipio;
					$this->p_ddd_telefone_1 = $this->ddd_telefone;
					$this->p_telefone_1 = $this->telefone;
					$this->p_ddd_telefone_fax = $this->ddd_fax;
					$this->p_telefone_fax = $this->fax;
				}
			}
		}
		elseif($_POST['cnpj'] && !$_POST["passou"])
		{
//			echo idFederal2int( $_POST['cnpj'] );
			$objJuridica = new clsPessoaJuridica( false, idFederal2int( $_POST['cnpj'] ) );
			$det = $objJuridica->detalhe();
			$objPessoa = new clsPessoaFj( $det["idpes"] );
			list( $this->endereco,
				  $this->cep,
				  $this->ref_bairro,
				  $this->p_ddd_telefone_1,
				  $this->p_telefone_1,
				  $this->p_ddd_telefone_2,
				  $this->p_telefone_2,
				  $this->p_ddd_telefone_mov,
				  $this->p_telefone_mov,
				  $this->p_ddd_telefone_fax,
				  $this->p_telefone_fax,
				  $this->p_email,
				  $this->p_http,
				  $this->tipo_pessoa,
				  $this->cidade,
				  $this->bairro,
				  $this->logradouro,
				  $this->idlog,
				  $this->idbai,
				  $this->idtlog,
				  $this->sigla_uf,
				  $this->complemento,
				  $this->numero,
				  $this->andar ) = $objPessoa->queryRapida( $det["idpes"],
				  											"endereco",
				  											"cep",
				  											"bairro",
				  											"ddd_1",
				  											"fone_1",
				  											"ddd_2",
				  											"fone_2",
				  											"ddd_mov",
				  											"fone_mov",
				  											"ddd_fax",
				  											"fone_fax",
				  											"email",
				  											"url",
				  											"tipo",
				  											"cidade",
				  											"bairro",
				  											"logradouro",
				  											"idlog",
				  											"idbai",
				  											"idtlog",
				  											"sigla_uf",
				  											"complemento",
				  											"numero",
				  											"andar" );
		}

		$this->url_cancelar = ($retorno == "Editar") ? "educar_escola_det.php?cod_escola={$registro["cod_escola"]}" : "educar_escola_lst.php";
		$this->nome_url_cancelar = "Cancelar";

  	return $retorno;
	}

	function Gerar()
	{

		// js
		Portabilis_View_Helper_Application::loadJQueryLib($this);

		$scripts = array(
			'/modules/Portabilis/Assets/Javascripts/Utils.js',
			'/modules/Portabilis/Assets/Javascripts/ClientApi.js',
			'/modules/Cadastro/Assets/Javascripts/Escola.js'
			);

		Portabilis_View_Helper_Application::loadJavascript($this, $scripts);

	    $styles = array ('/modules/Cadastro/Assets/Stylesheets/Escola.css');

	    Portabilis_View_Helper_Application::loadStylesheet($this, $styles);

		$obj_permissoes = new clsPermissoes();
//		echo "<pre>";print_r($_POST);die;

		if( !$this->sem_cnpj && !$this->com_cnpj)
		{
			$parametros = new clsParametrosPesquisas();
			$parametros->setSubmit( 1 );
			$parametros->setPessoa( 'J' );
			$parametros->setPessoaCampo('sem_cnpj');
			$parametros->setPessoaNovo( "S" );
			$parametros->setPessoaCPF("N");
			$parametros->setPessoaTela('window');
			$this->campoOculto( "sem_cnpj", "" );
			$parametros->setCodSistema(13);
			$parametros->adicionaCampoTexto( "cnpj", "cnpj" );
			$this->campoCnpjPesq( "cnpj", "CNPJ", $this->cnpj, "pesquisa_pessoa_lst.php", $parametros->serializaCampos(), true );


			//			$this->acao_enviar = "obj = document.getElementById(\"cnpj\");if(obj.value != \"\" ) {document.getElementById(\"formcadastro\").submit(); } else { acao(); }";
			$this->acao_enviar = false;
			$this->url_cancelar = false;
			$this->array_botao = array("Continuar","Cancelar");
			$this->array_botao_url_script = array("obj = document.getElementById('cnpj');if(obj.value != '' ) { acao(); } else { acao(); }","go('educar_escola_lst.php');");
		}
		else
		{
  		$this->inputsHelper()->integer('escola_inep_id', array('label' => 'C�digo inep', 'required' => false, 'max_length' => 14));

			if( $_POST )
			foreach( $_POST AS $campo => $val )
			{
				if ( $campo != 'tipoacao' && $campo != 'sem_cnpj')
					$this->$campo =  ( $this->$campo ) ? $this->$campo : $val;
			}

			if ($this->sem_cnpj)
			{
				$this->campoOculto( "sem_cnpj", $this->sem_cnpj );

				// cadastro novo sem CNPJ
				$this->p_ddd_telefone_1 = ( $this->p_ddd_telefone_1 == null ) ? "": $this->p_ddd_telefone_1;
				$this->p_ddd_telefone_fax = ( $this->p_ddd_telefone_fax == null ) ? "": $this->p_ddd_telefone_fax;

				if( $this->ref_idpes )
				{
					$objTemp = new clsPessoaJuridica( $this->ref_idpes );
					$detalhe = $objTemp->detalhe();
				}
//				$this->campoOculto( "passo", 4 );
//				$this->campoOculto( "sem_cnpj", 0 );
				$this->campoOculto( "cod_escola", $this->cod_escola );

				// text
				$this->campoTexto( "fantasia", "Escola", $this->fantasia, 30, 255, true );
				$this->campoTexto( "sigla", "Sigla", $this->sigla, 30, 255, true );

				// foreign keys
				$nivel = $obj_permissoes->nivel_acesso($this->pessoa_logada);
				if( $nivel == 1 )
				{
					$cabecalhos[] = "Instituicao";
					$objInstituicao = new clsPmieducarInstituicao();
					$opcoes = array( "" => "Selecione" );
					$objInstituicao->setOrderby( "nm_instituicao ASC" );
					$lista = $objInstituicao->lista();
					if( is_array( $lista ) )
					{
						foreach ( $lista AS $linha )
						{
							$opcoes[$linha["cod_instituicao"]] = $linha["nm_instituicao"];
						}
					}
					$this->campoLista( "ref_cod_instituicao", "Institui&ccedil;&atilde;o", $opcoes, $this->ref_cod_instituicao );
				}
				else
				{
					$this->ref_cod_instituicao = $obj_permissoes->getInstituicao($this->pessoa_logada );
					if( $this->ref_cod_instituicao )
					{
						$this->campoOculto( "ref_cod_instituicao", $this->ref_cod_instituicao );
					}
					else
					{
						die( "Usu�rio n�o � do nivel poli-institucional e n�o possui uma institui��o" );
					}
				}


				$opcoes = array( "" => "Selecione" );
				if( class_exists( "clsPmieducarEscolaRedeEnsino" ) )
				{
					/*$todas_redes_ensino = "rede_ensino = new Array();\n";
					$objTemp = new clsPmieducarEscolaRedeEnsino();
					$lista = $objTemp->lista();
					if ( is_array( $lista ) && count( $lista ) )
					{
						foreach ( $lista as $registro )
						{
							$todas_redes_ensino .= "rede_ensino[rede_ensino.length] = new Array( {$registro["cod_escola_rede_ensino"]}, '{$registro['nm_rede']}', {$registro["ref_cod_instituicao"]} );\n";
						}
					}
					echo "<script>{$todas_redes_ensino}</script>";*/

					// EDITAR
					$script = "javascript:showExpansivelIframe(520, 120, 'educar_escola_rede_ensino_cad_pop.php');";
					if ($this->ref_cod_instituicao)
					{
						$objTemp = new clsPmieducarEscolaRedeEnsino();
						$lista = $objTemp->lista( null,null,null,null,null,null,null,null,1,$this->ref_cod_instituicao );
						if ( is_array( $lista ) && count( $lista ) )
						{
							foreach ( $lista as $registro )
							{
								$opcoes["{$registro['cod_escola_rede_ensino']}"] = "{$registro['nm_rede']}";
							}
						}
						$script = "<img id='img_rede_ensino' style='display: \'\'' src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
					}
					else
					{
						$script = "<img id='img_rede_ensino' style='display: none;'  src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
					}
				}
				else
				{
					echo "<!--\nErro\nClasse clsPmieducarEscolaRedeEnsino nao encontrada\n-->";
					$opcoes = array( "" => "Erro na geracao" );
				}
				$this->campoLista( "ref_cod_escola_rede_ensino", "Rede Ensino", $opcoes, $this->ref_cod_escola_rede_ensino, "", false, "", $script );
				$opcoes = array( "" => "Selecione" );
				if( class_exists( "clsPmieducarEscolaLocalizacao" ) )
				{
					/*$todas_escolas_localizacao = "escola_localizacao = new Array();\n";
					$objTemp = new clsPmieducarEscolaLocalizacao();
					$lista = $objTemp->lista();
					if ( is_array( $lista ) && count( $lista ) )
					{
						foreach ( $lista as $registro )
						{
							$todas_escolas_localizacao .= "escola_localizacao[escola_localizacao.length] = new Array( {$registro["cod_escola_localizacao"]}, '{$registro['nm_localizacao']}', {$registro["ref_cod_instituicao"]} );\n";
						}
					}
					echo "<script>{$todas_escolas_localizacao}</script>";*/

					// EDITAR
					$script = "javascript:showExpansivelIframe(520, 120, 'educar_escola_localizacao_cad_pop.php');";
					if ($this->ref_cod_instituicao)
					{
						$objTemp = new clsPmieducarEscolaLocalizacao();
						$lista = $objTemp->lista( null,null,null,null,null,null,null,null,1,$this->ref_cod_instituicao );
						if ( is_array( $lista ) && count( $lista ) )
						{
							foreach ( $lista as $registro )
							{
								$opcoes["{$registro['cod_escola_localizacao']}"] = "{$registro['nm_localizacao']}";
							}
						}
						$script = "<img id='img_localizacao' style='display: \'\'' src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
					}
					else
					{
						$script = "<img id='img_localizacao' style='display: none;'  src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
					}
				}
				else
				{
					echo "<!--\nErro\nClasse clsPmieducarEscolaLocalizacao nao encontrada\n-->";
					$opcoes = array( "" => "Erro na geracao" );
				}
				$this->campoLista( "ref_cod_escola_localizacao", "Escola Localiza&ccedil;&atilde;o", $opcoes, $this->ref_cod_escola_localizacao, "", false, "", $script );

				if(is_numeric($this->cep))
				{
					$this->cep = int2CEP($this->cep);
				}

//				$this->campoCep( "cep","CEP", $this->cep,true,"-",false,false );
				$this->campoCep( "cep","CEP", $this->cep,true,"-",false,false );
				$this->campoTexto( "cidade", "Cidade",  $this->cidade, "50", "255", true );
				$this->campoTexto( "bairro", "Bairro",  $this->bairro, "50", "20", true );
				$this->campoTexto( "logradouro", "Logradouro",  $this->logradouro, "50", "255",true );
				$this->campoTexto( "complemento", "Complemento",  $this->complemento, "22", "20", false );
				$this->campoNumero( "numero", "N�mero",  $this->numero, "6", "6", true );

				$this->campoTexto( "p_ddd_telefone_1", "DDD Telefone 1",  $this->p_ddd_telefone_1, "2", "2", false );
				$this->campoTexto( "p_telefone_1", "Telefone 1",  $this->p_telefone_1, "10", "15", false );
				$this->campoTexto( "p_ddd_telefone_fax", "DDD Fax",  $this->p_ddd_telefone_fax, "2", "2", false );
				$this->campoTexto( "p_telefone_fax", "Fax",  $this->p_telefone_fax, "10", "15", false );

				$this->campoTexto( "p_email", "E-mail",  $this->p_email, "50", "255", false );
			}

			if ($this->com_cnpj)
			{
				$this->campoOculto( "com_cnpj", $this->com_cnpj );
//				die("com CNPJ");
//				echo "<br>cep: ".$this->cep;
//				echo "<br>cep_: ".$this->cep_;
				if (!$this->cod_escola)
				{
					$this->cnpj = urldecode($_POST['cnpj']);
					$this->cnpj = idFederal2int($this->cnpj);
//					echo int2IdFederal($this->cnpj);
					$this->cnpj = int2IdFederal($this->cnpj);
				}

//				echo "sakdmk: ".$this->cnpj;die;
				// cadastro novo com CNPJ
				//echo "hehehe".idFederal2int($this->cnpj);echo "kiki".int2IdFederal($this->cnpj);die;

				$objJuridica = new clsPessoaJuridica( false, idFederal2int($this->cnpj) );
				$det = $objJuridica->detalhe();
				$this->ref_idpes = $det["idpes"];
//				if( $this->ref_idpes )
//				{
//					$this->p_ddd_telefone_1 = ( $this->p_ddd_telefone_1 == null ) ? "": is_numeric( $this->p_ddd_telefone_1 );
//					$this->p_ddd_telefone_2 = ( $this->p_ddd_telefone_2 == null ) ? "": is_numeric( $this->p_ddd_telefone_2 );
//					$this->p_ddd_telefone_3 = ( $this->p_ddd_telefone_3 == null ) ? "": is_numeric( $this->p_ddd_telefone_3 );

//					$obj_pessoa = new clsPessoa_( $this->ref_idpes );
//					$det_pessoa = $obj_pessoa->detalhe();
					//$this->fantasia = $det_pessoa["nome"];


//					$this->nm_escola = $det["nome"];
					if (!$this->fantasia)
						$this->fantasia = $det["fantasia"];

					if ($this->passou){
						$this->cnpj = (is_numeric($this->cnpj)) ? $this->cnpj : idFederal2int($this->cnpj);
						$this->cnpj = int2IdFederal($this->cnpj);
					}
//
					$this->campoRotulo( "cnpj_", "CNPJ", $this->cnpj );
					$this->campoOculto( "cnpj", idFederal2int( $this->cnpj ) );
					$this->campoOculto( "ref_idpes", $this->ref_idpes );
//					$this->campoOculto( "passo", 3 );
					$this->campoOculto( "cod_escola", $this->cod_escola );

					// text
					$this->campoTexto( "fantasia", "Escola", $this->fantasia, 30, 255, true );
					$this->campoTexto( "sigla", "Sigla", $this->sigla, 30, 20, true );

					// foreign keys
					$nivel = $obj_permissoes->nivel_acesso($this->pessoa_logada);
					if( $nivel == 1 )
					{
						$cabecalhos[] = "Instituicao";
						$objInstituicao = new clsPmieducarInstituicao();
						$opcoes = array( "" => "Selecione" );
						$objInstituicao->setOrderby( "nm_instituicao ASC" );
						$lista = $objInstituicao->lista();
						if( is_array( $lista ) )
						{
							foreach ( $lista AS $linha )
							{
								$opcoes[$linha["cod_instituicao"]] = $linha["nm_instituicao"];
							}
						}
						$this->campoLista( "ref_cod_instituicao", "Instituicao", $opcoes, $this->ref_cod_instituicao );
					}
					else
					{
						$this->ref_cod_instituicao = $obj_permissoes->getInstituicao($this->pessoa_logada );
						if( $this->ref_cod_instituicao )
						{
							$this->campoOculto( "ref_cod_instituicao", $this->ref_cod_instituicao );
						}
						else
						{
							die( "Usu�rio n�o � do nivel poli-institucional e n�o possui uma institui��o" );
						}
					}

					$opcoes = array( "" => "Selecione" );
					if( class_exists( "clsPmieducarEscolaRedeEnsino" ) )
					{
						/*$todas_redes_ensino = "rede_ensino = new Array();\n";
						$objTemp = new clsPmieducarEscolaRedeEnsino();
						$lista = $objTemp->lista( null,null,null,null,null,null,null,null,1 );
						if ( is_array( $lista ) && count( $lista ) )
						{
							foreach ( $lista as $registro )
							{
								$todas_redes_ensino .= "rede_ensino[rede_ensino.length] = new Array( {$registro["cod_escola_rede_ensino"]}, '{$registro['nm_rede']}', {$registro["ref_cod_instituicao"]} );\n";
							}
						}
						echo "<script>{$todas_redes_ensino}</script>";*/

						// EDITAR
						$script = "javascript:showExpansivelIframe(520, 120, 'educar_escola_rede_ensino_cad_pop.php');";
						if ($this->ref_cod_instituicao)
						{
							$objTemp = new clsPmieducarEscolaRedeEnsino();
							$lista = $objTemp->lista( null,null,null,null,null,null,null,null,1,$this->ref_cod_instituicao );
							if ( is_array( $lista ) && count( $lista ) )
							{
								foreach ( $lista as $registro )
								{
									$opcoes["{$registro['cod_escola_rede_ensino']}"] = "{$registro['nm_rede']}";
								}
							}
							$script = "<img id='img_rede_ensino' style='display:\'\'' src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
						}
						else
						{
							$script = "<img id='img_rede_ensino' style='display: none;'  src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
						}
					}
					else
					{
						echo "<!--\nErro\nClasse clsPmieducarEscolaRedeEnsino nao encontrada\n-->";
						$opcoes = array( "" => "Erro na geracao" );
					}
					$this->campoLista( "ref_cod_escola_rede_ensino", "Rede Ensino", $opcoes, $this->ref_cod_escola_rede_ensino, "", false, "", $script );

					$opcoes = array( "" => "Selecione" );
					if( class_exists( "clsPmieducarEscolaLocalizacao" ) )
					{
						/*$todas_escolas_localizacao = "escola_localizacao = new Array();\n";
						$objTemp = new clsPmieducarEscolaLocalizacao();
						$lista = $objTemp->lista( null,null,null,null,null,null,null,null,1 );
						if ( is_array( $lista ) && count( $lista ) )
						{
							foreach ( $lista as $registro )
							{
								$todas_escolas_localizacao .= "escola_localizacao[escola_localizacao.length] = new Array( {$registro["cod_escola_localizacao"]}, '{$registro['nm_localizacao']}', {$registro["ref_cod_instituicao"]} );\n";
							}
						}
						echo "<script>{$todas_escolas_localizacao}</script>";*/

						// EDITAR
						$script = "javascript:showExpansivelIframe(520, 120, 'educar_escola_localizacao_cad_pop.php');";
						if ($this->ref_cod_instituicao)
						{
							$objTemp = new clsPmieducarEscolaLocalizacao();
							$lista = $objTemp->lista( null,null,null,null,null,null,null,null,1,$this->ref_cod_instituicao );
							if ( is_array( $lista ) && count( $lista ) )
							{
								foreach ( $lista as $registro )
								{
									$opcoes["{$registro['cod_escola_localizacao']}"] = "{$registro['nm_localizacao']}";
								}
							}
							$script = "<img id='img_localizacao' style='display:\'\'' src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
						}
						else
						{
							$script = "<img id='img_localizacao' style='display: none;' src='imagens/banco_imagens/escreve.gif' style='cursor:hand; cursor:pointer;' border='0' onclick=\"{$script}\">";
						}
					}
					else
					{
						echo "<!--\nErro\nClasse clsPmieducarEscolaLocalizacao nao encontrada\n-->";
						$opcoes = array( "" => "Erro na geracao" );
					}
					$this->campoLista( "ref_cod_escola_localizacao", "Escola Localiza&ccedil;&atilde;o", $opcoes, $this->ref_cod_escola_localizacao, "", false, "", $script );

					// Detalhes do Endereco
					$objUf = new clsUf();
					$listauf = $objUf->lista();
					$listaEstado = array(""=>"Selecione");
					if($listauf)
					{
						foreach ($listauf as $uf)
						{
							$listaEstado[$uf['sigla_uf']] = $uf['sigla_uf'];
						}
					}

					$objTipoLog = new clsTipoLogradouro();
					$listaTipoLog = $objTipoLog->lista();
					$listaTLog = array(""=>"Selecione");
					if($listaTipoLog)
					{
						foreach ($listaTipoLog as $tipoLog)
						{
							$listaTLog[urldecode($tipoLog['idtlog'])] = $tipoLog['descricao'];
						}
					}


					$this->campoOculto("isEnderecoExterno",$this->isEnderecoExterno);
				//	echo "$this->cep ,$this->sigla_uf ";
					$this->campoOculto( "cep_", $this->cep_ );
					$this->campoOculto( "sigla_uf_", $this->sigla_uf_ );
					$this->campoOculto( "cidade_", $this->cidade_ );
					$this->campoOculto( "bairro_", $this->bairro_ );
					$this->campoOculto( "idbai", $this->idbai );
					$this->campoOculto( "logradouro_", $this->logradouro_ );
					$this->campoOculto( "idlog", $this->idlog );
					$this->campoOculto( "idtlog_", $this->idtlog_ );
					$disabled = $this->isEnderecoExterno ? false : true ;
					if($this->idlog && $this->idbai && $this->cep && $this->ref_idpes)
					{
						$this->campoOculto( "cep_", $this->cep );
						$this->cep_ = int2CEP($this->cep);
						//$this->campoLista( "ref_cod_escola_localizacao", "Escola Localizac&atilde;o", $opcoes, $this->ref_cod_escola_localizacao );
//						$this->campoCep("cep_","CEP", int2CEP($this->cep),true,"-","&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_f('pesquisa_cep3.php', 'enderecos')\" style=\"cursor: hand;\">",true);
//						$this->campoCep( "cep_", "CEP", int2CEP( $this->cep ), true, "-", "&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_f( 'pesquisa_cep_lst.php', 'enderecos' )\" style=\"cursor: hand;\">", false );
						//$this->campoCep( "cep", "CEP", int2CEP( $this->cep ), true, "-", "&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_popless('pesquisa_cep_lst.php', 'enderecos')\" style=\"cursor: hand;\">", true );
						$this->campoCep("cep", "CEP", $this->cep_ , true, "-", "<img id='lupa' src=\"imagens/lupa.png\" border=\"0\" onclick=\"showExpansivel( 500,500, '<iframe name=\'miolo\' id=\'miolo\' frameborder=\'0\' height=\'100%\' width=\'500\' marginheight=\'0\' marginwidth=\'0\' src=\'educar_pesquisa_cep_log_bairro.php?campo1=bairro&campo2=idbai&campo3=cep_&campo4=logradouro&campo5=idlog&campo6=sigla_uf_&campo7=cidade&campo8=idtlog_&campo9=isEnderecoExterno&campo10=cep&campo11=sigla_uf&campo12=idtlog&campo13=cidade_\'></iframe>');\">", $disabled);
						$this->campoLista( "sigla_uf", "Estado", $listaEstado, $this->sigla_uf, false, false, false, false, true,true );
						$this->campoTexto( "cidade", "Cidade",  $this->cidade, "50", "255", true, false, false, "", "", "", "onKeyUp", true );
						$this->campoTexto( "bairro", "Bairro",  $this->bairro, "50", "255", true, false, false, "", "", "", "onKeyUp", true );
						$this->campoLista( "idtlog", "Tipo Logradouro", $listaTLog, $this->idtlog, false, false, false, false, true ,true);
						$this->campoTexto( "logradouro", "Logradouro",  $this->logradouro, "50", "255", true, false, false, "", "", "", "onKeyUp", true );
						$this->campoTexto( "complemento", "Complemento",  $this->complemento, "22", "20", false, false );
						$this->campoNumero("numero", "N�mero", $this->numero, "6", "6", false );
						$this->campoNumero("andar", "Andar", $this->andar, "2","2", false);
					}
					elseif($this->ref_idpes && $this->cep)
					{
						$this->cep = (is_numeric($this->cep)) ? int2CEP($this->cep): $this->cep;

//						$this->campoCep("cep_","CEP", int2CEP($this->cep),true,"-","&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_f('pesquisa_cep3.php', 'enderecos')\" style=\"cursor: hand;\">",false);
//						$this->campoCep( "cep_", "CEP", int2CEP( $this->cep ), true, "-", "&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_f( 'pesquisa_cep_lst.php', 'enderecos' )\" style=\"cursor: hand;\">", false );
						//$this->campoCep( "cep", "CEP", int2CEP( $this->cep ), true, "-", "&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_popless('pesquisa_cep_lst.php', 'enderecos')\" style=\"cursor: hand;\">", false );
						$this->campoCep("cep", "CEP", $this->cep, true, "-", "<img id='lupa' src=\"imagens/lupa.png\" border=\"0\" onclick=\"showExpansivel( 500,500, '<iframe name=\'miolo\' id=\'miolo\' frameborder=\'0\' height=\'100%\' width=\'500\' marginheight=\'0\' marginwidth=\'0\' src=\'educar_pesquisa_cep_log_bairro.php?campo1=bairro&campo2=idbai&campo3=cep_&campo4=logradouro&campo5=idlog&campo6=sigla_uf_&campo7=cidade&campo8=idtlog_&campo9=isEnderecoExterno&campo10=cep&campo11=sigla_uf&campo12=idtlog&campo13=cidade_\'></iframe>');\">");
						$this->campoLista( "sigla_uf", "Estado", $listaEstado, $this->sigla_uf, "", false, "", "", false,true );
						$this->campoTexto( "cidade", "Cidade",  $this->cidade, "50", "255", true, false, false, "", "", "", "onKeyUp", false);
						$this->campoTexto( "bairro", "Bairro",  $this->bairro, "50", "255",true, false, false, "", "", "", "onKeyUp", false );
						$this->campoLista( "idtlog", "Tipo Logradouro", $listaTLog, $this->idtlog, "", false, "", "", false,true );
						$this->campoTexto( "logradouro", "Logradouro",  $this->logradouro, "50", "255", true, false, false, "", "", "", "onKeyUp", false );
						$this->campoTexto( "complemento", "Complemento",  $this->complemento, "22", "20", false, false, false, "", "", "", "onKeyUp", false );
						$this->campoNumero( "numero", "N�mero",  $this->numero, 6, 6, false, "", ""  );
						$this->campoNumero( "andar", "Andar", $this->andar, "2","2", false );
					}
					else
					{

if(!$this->isEnderecoExterno){
						$obj_bairro = new clsBairro($this->idbai);
						$this->cep_ = int2CEP($this->cep_);

						$obj_bairro_det = $obj_bairro->detalhe();

						if($obj_bairro_det){

							$this->bairro = $obj_bairro_det["nome"];
						}

						$obj_log = new clsLogradouro($this->idlog);
						$obj_log_det = $obj_log->detalhe();

						if($obj_log_det){

							$this->logradouro = $obj_log_det["nome"];

							$this->idtlog = $obj_log_det["idtlog"]->idtlog;
							$obj_mun = new clsMunicipio( $obj_log_det["idmun"]);
							$det_mun = $obj_mun->detalhe();

							if($det_mun)
								$this->cidade = strtoupper(ucfirst(strtolower($det_mun["nome"])));

							$this->sigla_uf = $this->sigla_uf_ =  $det_mun['sigla_uf']->sigla_uf;
						}
}else
{
	$this->cep_ = $this->cep;
}

					/*$obj_bairro = new clsBairro($obj_endereco_det["ref_idbai"]);
					$obj_bairro_det = $obj_bairro->detalhe();

					if($obj_bairro_det){

						$this->bairro = $obj_bairro_det["nome"];
					}*/
//						$this->campoCep("cep_","CEP", int2CEP($this->cep),true,"-","&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_f('pesquisa_cep3.php', 'enderecos')\" style=\"cursor: hand;\">",true);
//						$this->campoCep( "cep_", "CEP", int2CEP( $this->cep ), true, "-", "&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_f( 'pesquisa_cep_lst.php', 'enderecos' )\" style=\"cursor: hand;\">", false );
//						$this->campoCep( "cep_", "CEP", int2CEP( $this->cep ), true, "-", "&nbsp;<img src=\"imagens/lupa.png\" border=\"0\" onclick=\"pesquisa_valores_popless('pesquisa_cep_lst.php', 'enderecos')\" style=\"cursor: hand;\">", false );
						$this->campoCep("cep", "CEP", $this->cep_ , true, "-", "<img id='lupa' src=\"imagens/lupa.png\" border=\"0\" onclick=\"showExpansivel( 500,500, '<iframe name=\'miolo\' id=\'miolo\' frameborder=\'0\' height=\'100%\' width=\'500\' marginheight=\'0\' marginwidth=\'0\' src=\'educar_pesquisa_cep_log_bairro.php?campo1=bairro&campo2=idbai&campo3=cep_&campo4=logradouro&campo5=idlog&campo6=sigla_uf_&campo7=cidade&campo8=idtlog_&campo9=isEnderecoExterno&campo10=cep&campo11=sigla_uf&campo12=idtlog&campo13=cidade_\'></iframe>');\">", $disabled);
 					//	$this->campoCep("cep_", "CEP", $this->cep_, true, "-", "<img id='lupa' src=\"imagens/lupa.png\" border=\"0\" onclick=\"showExpansivel( 500,500, '<iframe name=\'miolo\' id=\'miolo\' frameborder=\'0\' height=\'100%\' width=\'500\' marginheight=\'0\' marginwidth=\'0\' src=\'educar_pesquisa_cep_log_bairro.php?campo1=nm_bairro&campo2=id_bairro&campo3=id_cep&campo4=nm_logradouro&campo5=id_logradouro&campo6=ref_sigla_uf&campo7=cidade&campo8=ref_idtlog_&campo9=isEnderecoExterno&campo10=cep_&campo11=ref_sigla_uf_&campo12=ref_idtlog&campo13=id_cidade\'></iframe>');\">", $disabled);
						$this->campoLista("sigla_uf","Estado",$listaEstado,$this->sigla_uf,false,false,false,false,$disabled,true);
						$this->campoTexto( "cidade", "Cidade",  $this->cidade, "50", "255", true,false,false,"","","","",$disabled,true );
						$this->campoTexto( "bairro", "Bairro",  $this->bairro, "50", "20", true ,false,false,"","","","",$disabled ,true);
						$this->campoLista("idtlog","Tipo Logradouro",$listaTLog,$this->idtlog,false,false,false,false,$disabled,true);
						$this->campoTexto( "logradouro", "Logradouro",  $this->logradouro, "50", "255",true,false,false,"","","","",$disabled,true );
						$this->campoTexto( "complemento", "Complemento",  $this->complemento, "22", "20", false,false,false );
						$this->campoNumero( "numero", "N&uacute;mero",  $this->numero, "6", "6", false );
						$this->campoNumero("andar", "Andar", $this->andar, "2","2", false);
					}

					$this->campoNumero( "p_ddd_telefone_1", "DDD Telefone 1",  $this->p_ddd_telefone_1, 2, 2, false );
					$this->campoNumero( "p_telefone_1", "Telefone 1",  $this->p_telefone_1, 10, 15, false );
					$this->campoNumero( "p_ddd_telefone_2", "DDD Telefone 2",  $this->p_ddd_telefone_2, 2, 2, false );
					$this->campoNumero( "p_telefone_2", "Telefone",  $this->p_telefone_2, 10, 15, false );
					$this->campoNumero( "p_ddd_telefone_fax", "DDD Fax",  $this->p_ddd_telefone_fax, 2, 2, false );
					$this->campoNumero( "p_telefone_fax", "Fax",  $this->p_telefone_fax, 10, 15, false );
					$this->campoTexto( "p_http", "Site",  $this->p_http, "50", "255", false );
					$this->campoTexto( "p_email", "E-mail",  $this->p_email, "50", "255", false );

//				}
//				else
//				{
//					$this->mensagem = "nop";
//				}
				$this->passou = true;
				$this->campoOculto( "passou", $this->passou );
			}
//			else if ( $this->passo == 3 )
//			{
//
//
//
//			}

  		$this->campoCheck("bloquear_lancamento_diario_anos_letivos_encerrados", "Bloquear lan�amento no di�rio para anos letivos encerrados", $this->bloquear_lancamento_diario_anos_letivos_encerrados);


  		$resources = array(1 => 'Em atividade',
	                       2 => 'Paralisada',
	                       3 => 'Extinta');

	    $options = array('label' => Portabilis_String_Utils::toLatin1('Situa��o de funcionamento'), 'resources' => $resources, 'value' => $this->situacao_funcionamento);
	    $this->inputsHelper()->select('situacao_funcionamento', $options);	   	   

  		$resources = array(1 => 'Federal',
	                       2 => 'Estadual',
	                       3 => 'Municipal',
	                       4 => 'Privada');

  		$options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncia administrativa'), 'resources' => $resources, 'value' => $this->dependencia_administrativa);
	    $this->inputsHelper()->select('dependencia_administrativa', $options);

  		$resources = array(0 => Portabilis_String_Utils::toLatin1('N�o'),
		                   1 => 'Sim',
		                   2 => Portabilis_String_Utils::toLatin1('Em tramita��o'));

  		$options = array('label' => Portabilis_String_Utils::toLatin1('Regulamenta��o/ Autoriza��o no conselho ou �rg�o p�blico de educa��o'), 'resources' => $resources, 'value' => $this->regulamentacao, 'size' => 70,);
	    $this->inputsHelper()->select('regulamentacao', $options);  		

	    $hiddenInputOptions = array('options' => array('value' => $this->gestor_id));
	    $helperOptions      = array('objectName' => 'gestor', 'hiddenInputOptions' => $hiddenInputOptions);

	    $options            = array('label'      => 'Gestor Escolar',
	                                'size'       => 50,
	                                'required'   => false);

	    $this->inputsHelper()->simpleSearchPessoa('nome', $options, $helperOptions);


	    $resources = array( 1    => 'Diretor',
		                    2    => 'Outro cargo');

  		$options = array('label' => Portabilis_String_Utils::toLatin1('Cargo do Gestor Escolar'), 'resources' => $resources, 'value' => $this->cargo_gestor, 'required' => false, 'size' => 50,);
	    $this->inputsHelper()->select('cargo_gestor', $options);


			if ( $_POST["escola_curso"] )
				$this->escola_curso = unserialize( urldecode( $_POST["escola_curso"] ) );
			if( is_numeric( $this->cod_escola ) && !$_POST )
			{
				$obj = new clsPmieducarEscolaCurso( $this->cod_escola );
				$registros = $obj->lista( $this->cod_escola );
				if( $registros )
				{
					foreach ( $registros AS $campo )
					{
						$this->escola_curso[$campo["ref_cod_curso"]] = $campo["ref_cod_curso"];

					}
				}
			}
			if ( $_POST["ref_cod_curso"] )
			{
				$this->escola_curso[$_POST["ref_cod_curso"]] = $_POST["ref_cod_curso"];
				unset( $this->ref_cod_curso );
			}
			$this->campoQuebra();

			$this->campoOculto( "excluir_curso", "" );
			unset($aux);

			if ( $this->escola_curso )
			{
//				echo "<pre>";print_r($this->escola_curso);
				foreach ( $this->escola_curso as $curso )
				{
					if ( $this->excluir_curso == $curso )
					{
						unset($this->escola_curso[$curso]);// = null;
						$this->excluir_curso = null;
					}
					else
					{
						$obj_curso = new clsPmieducarCurso($curso);
						$obj_curso_det = $obj_curso->detalhe();
						$nm_curso = $obj_curso_det["nm_curso"];
						$this->campoTextoInv( "ref_cod_curso_{$curso}", "", $nm_curso, 30, 255, false, false, false, "", "<a href='#' onclick=\"getElementById('excluir_curso').value = '{$curso}'; getElementById('tipoacao').value = ''; {$this->__nome}.submit();\"><img src='imagens/nvp_bola_xis.gif' title='Excluir' border=0></a>" );
						$aux[$curso] = $curso;
					}

				}
				unset($this->escola_curso);
				$this->escola_curso = $aux;
			}

			$this->campoOculto( "escola_curso", serialize( $this->escola_curso ) );

			$opcoes = array( "" => "Selecione" );
			if( class_exists( "clsPmieducarCurso" ) )
			{
				/*$todos_cursos = "curso = new Array();\n";
				$objTemp = new clsPmieducarCurso();
				$objTemp->setOrderby("nm_curso");
				$lista = $objTemp->lista( null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,1 );
				if ( is_array( $lista ) && count( $lista ) )
				{
					foreach ( $lista as $registro )
					{
						$todos_cursos .= "curso[curso.length] = new Array({$registro["cod_curso"]},'{$registro["nm_curso"]}', {$registro["ref_cod_instituicao"]});\n";
					}
				}
				echo "<script>{$todos_cursos}</script>";*/

				// EDITAR
				if ($this->cod_escola || $this->ref_cod_instituicao)
				{
					$objTemp = new clsPmieducarCurso();
					$objTemp->setOrderby("nm_curso");
					$lista = $objTemp->lista(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,1,null,$this->ref_cod_instituicao);
					if ( is_array( $lista ) && count( $lista ) )
					{
						foreach ( $lista as $registro )
						{
							$opcoes["{$registro['cod_curso']}"] = "{$registro['nm_curso']}";
						}
					}
				}
			}
			else
			{
				echo "<!--\nErro\nClasse clsPmieducarCurso n&atilde;o encontrada\n-->";
				$opcoes = array( "" => "Erro na gera&ccedil;&atilde;o" );
			}
			if ( $aux )
				$this->campoLista( "ref_cod_curso", "Curso", $opcoes, $this->ref_cod_curso,"",false,"","<a href='#' onclick=\"getElementById('incluir_curso').value = 'S'; getElementById('tipoacao').value = ''; {$this->__nome}.submit();\"><img src='imagens/nvp_bot_adiciona.gif' title='Incluir' border=0></a>",false,false);
			else
				$this->campoLista( "ref_cod_curso", "Curso", $opcoes, $this->ref_cod_curso,"",false,"","<a href='#' onclick=\"getElementById('incluir_curso').value = 'S'; getElementById('tipoacao').value = ''; {$this->__nome}.submit();\"><img src='imagens/nvp_bot_adiciona.gif' title='Incluir' border=0></a>");

			$this->campoOculto( "incluir_curso", "" );
			$this->campoQuebra();

			$resources = array(0 => 'Alugado',
			                   1 => Portabilis_String_Utils::toLatin1('Pr�prio'),
			                   2 => 'Cedido');

	  		$options = array('label' => Portabilis_String_Utils::toLatin1('Condi��o'), 'resources' => $resources, 'value' => $this->condicao, 'size' => 70, 'required' => false);
		    $this->inputsHelper()->select('condicao', $options);

			$resources = array( null => 'Selecione',
			                    1    => Portabilis_String_Utils::toLatin1('Dif�cil'),
			                    2    => 'Dific�limo');

	  		$options = array('label' => Portabilis_String_Utils::toLatin1('Acesso � escola'), 'resources' => $resources, 'value' => $this->acesso, 'required' => false, 'size' => 50,);
		    $this->inputsHelper()->select('acesso', $options);

	  		$options = array('label' => Portabilis_String_Utils::toLatin1('Decreto de cria��o de unidade'), 'resources' => $resources, 'value' => $this->decreto_criacao, 'required' => false, 'size' => 50,);
		    $this->inputsHelper()->text('decreto_criacao', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('�rea do terreno total'), 'resources' => $resources, 'value' => $this->area_terreno_total, 'required' => false, 'size' => 10, 'placeholder' => '');
		    $this->inputsHelper()->text('area_terreno_total', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('�rea constru�da'), 'resources' => $resources, 'value' => $this->area_construida, 'required' => false, 'size' => 10, 'placeholder' => '');
		    $this->inputsHelper()->text('area_construida', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('�rea dispon�vel'), 'resources' => $resources, 'value' => $this->area_disponivel, 'required' => false, 'size' => 10, 'placeholder' => '');
		    $this->inputsHelper()->text('area_disponivel', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('N�mero de pavimentos'), 'resources' => $resources, 'value' => $this->num_pavimentos, 'required' => false, 'size' => 5, 'placeholder' => '');
		    $this->inputsHelper()->integer('num_pavimentos', $options);

		    $resources = array( null => 'Selecione',
			                    1    => Portabilis_String_Utils::toLatin1('Cer�mica'),
			                    2    => 'Acimentado',
			                    3    => 'Madeira',
			                    4    => 'Outros',);

	  		$options = array('label' => 'Tipo de piso', 'resources' => $resources, 'value' => $this->tipo_piso, 'required' => false, 'size' => 70,);
		    $this->inputsHelper()->select('tipo_piso', $options);

		    $resources = array( null => 'Selecione',
			                    1    => Portabilis_String_Utils::toLatin1('Monof�sico'),
			                    2    => Portabilis_String_Utils::toLatin1('Bif�sico'),
			                    3    => Portabilis_String_Utils::toLatin1('Trif�sico'),
			                    4   => Portabilis_String_Utils::toLatin1('N�o'),);

	  		$options = array('label' => 'Medidor de energia', 'resources' => $resources, 'value' => $this->medidor_energia, 'required' => false, 'size' => 70,);
		    $this->inputsHelper()->select('medidor_energia', $options);

		    $resources = array( null => 'Selecione',
			                    1    => Portabilis_String_Utils::toLatin1('N�o filtrada'),
			                    2    => 'Filtrada',);

	  		$options = array('label' => Portabilis_String_Utils::toLatin1('�gua consumida pelos alunos'), 'resources' => $resources, 'value' => $this->agua_consumida, 'required' => false, 'size' => 70,);
		    $this->inputsHelper()->select('agua_consumida', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de �gua - Rede p�blica'), 'value' => $this->agua_rede_publica);
		    $this->inputsHelper()->checkbox('agua_rede_publica', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de �gua - Po�o artesiano'), 'value' => $this->agua_poco_artesiano);
		    $this->inputsHelper()->checkbox('agua_poco_artesiano', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de �gua - Cacimba / cisterna / po�o'), 'value' => $this->agua_cacimba_cisterna_poco);
		    $this->inputsHelper()->checkbox('agua_cacimba_cisterna_poco', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de �gua - Fonte / rio / igarap� / riacho / corr�go'), 'value' => $this->agua_fonte_rio);
		    $this->inputsHelper()->checkbox('agua_fonte_rio', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de �gua - Inexistente'), 'value' => $this->agua_inexistente);
		    $this->inputsHelper()->checkbox('agua_inexistente', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de energia el�trica - Rede p�blica'), 'value' => $this->energia_rede_publica);
		    $this->inputsHelper()->checkbox('energia_rede_publica', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de energia el�trica - Gerador'), 'value' => $this->energia_gerador);
		    $this->inputsHelper()->checkbox('energia_gerador', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de energia el�trica - Outros'), 'value' => $this->energia_outros);
		    $this->inputsHelper()->checkbox('energia_outros', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Abastecimento de energia el�trica - Inexistente'), 'value' => $this->energia_inexistente);
		    $this->inputsHelper()->checkbox('energia_inexistente', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Esgoto sanit�rio - Rede p�blica'), 'value' => $this->esgoto_rede_publica);
		    $this->inputsHelper()->checkbox('esgoto_rede_publica', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Esgoto sanit�rio - Fossa'), 'value' => $this->esgoto_fossa);
		    $this->inputsHelper()->checkbox('esgoto_fossa', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Esgoto sanit�rio - Inexistente'), 'value' => $this->esgoto_inexistente);
		    $this->inputsHelper()->checkbox('esgoto_inexistente', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Destina��o do lixo - Coleta peri�dica'), 'value' => $this->lixo_coleta_periodica);
		    $this->inputsHelper()->checkbox('lixo_coleta_periodica', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Destina��o do lixo - Queima'), 'value' => $this->lixo_queima);
		    $this->inputsHelper()->checkbox('lixo_queima', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Destina��o do lixo - Joga em outra �rea'), 'value' => $this->lixo_joga_outra_area);
		    $this->inputsHelper()->checkbox('lixo_joga_outra_area', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Destina��o do lixo - Recicla'), 'value' => $this->lixo_recicla);
		    $this->inputsHelper()->checkbox('lixo_recicla', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Destina��o do lixo - Enterra'), 'value' => $this->lixo_enterra);
		    $this->inputsHelper()->checkbox('lixo_enterra', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Destina��o do lixo - Outros'), 'value' => $this->lixo_outros);
		    $this->inputsHelper()->checkbox('lixo_outros', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Sala de diretoria'), 'value' => $this->dependencia_sala_diretoria);
		    $this->inputsHelper()->checkbox('dependencia_sala_diretoria', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Sala de diretoria'), 'value' => $this->dependencia_sala_diretoria);
		    $this->inputsHelper()->checkbox('dependencia_sala_diretoria', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Sala de professores'), 'value' => $this->dependencia_sala_professores);
		    $this->inputsHelper()->checkbox('dependencia_sala_professores', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Sala de secretaria'), 'value' => $this->dependencia_sala_secretaria);
		    $this->inputsHelper()->checkbox('dependencia_sala_secretaria', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Laborat�rio de inform�tica'), 'value' => $this->dependencia_laboratorio_informatica);
		    $this->inputsHelper()->checkbox('dependencia_laboratorio_informatica', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Laborat�rio de ci�ncias'), 'value' => $this->dependencia_laboratorio_ciencias);
		    $this->inputsHelper()->checkbox('dependencia_laboratorio_ciencias', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Sala de recursos multifuncionais para atendimento educacional especializado - AEE'), 'value' => $this->dependencia_sala_aee);
		    $this->inputsHelper()->checkbox('dependencia_sala_aee', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Quadra de esportes coberta'), 'value' => $this->dependencia_quadra_coberta);
		    $this->inputsHelper()->checkbox('dependencia_quadra_coberta', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Quadra de esportes descoberta'), 'value' => $this->dependencia_quadra_descoberta);
		    $this->inputsHelper()->checkbox('dependencia_quadra_descoberta', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Cozinha'), 'value' => $this->dependencia_cozinha);
		    $this->inputsHelper()->checkbox('dependencia_cozinha', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Biblioteca'), 'value' => $this->dependencia_biblioteca);
		    $this->inputsHelper()->checkbox('dependencia_biblioteca', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Sala de leitura'), 'value' => $this->dependencia_sala_leitura);
		    $this->inputsHelper()->checkbox('dependencia_sala_leitura', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Parque infantil'), 'value' => $this->dependencia_parque_infantil);
		    $this->inputsHelper()->checkbox('dependencia_parque_infantil', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Ber�ario'), 'value' => $this->dependencia_bercario);
		    $this->inputsHelper()->checkbox('dependencia_bercario', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Banheiro fora do pr�dio'), 'value' => $this->dependencia_banheiro_fora);
		    $this->inputsHelper()->checkbox('dependencia_banheiro_fora', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Banheiro dentro do pr�dio'), 'value' => $this->dependencia_banheiro_dentro);
		    $this->inputsHelper()->checkbox('dependencia_banheiro_dentro', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Banheiro adequado a Educa��o Infantil'), 'value' => $this->dependencia_banheiro_infantil);
		    $this->inputsHelper()->checkbox('dependencia_banheiro_infantil', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Banheiro adequado a deficientes'), 'value' => $this->dependencia_banheiro_deficiente);
		    $this->inputsHelper()->checkbox('dependencia_banheiro_deficiente', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Banheiro com chuveiro'), 'value' => $this->dependencia_banheiro_chuveiro);
		    $this->inputsHelper()->checkbox('dependencia_banheiro_chuveiro', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Refeit�rio'), 'value' => $this->dependencia_refeitorio);
		    $this->inputsHelper()->checkbox('dependencia_refeitorio', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Despensa'), 'value' => $this->dependencia_dispensa);
		    $this->inputsHelper()->checkbox('dependencia_dispensa', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Aumoxarifado'), 'value' => $this->dependencia_aumoxarifado);
		    $this->inputsHelper()->checkbox('dependencia_aumoxarifado', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � Audit�rio'), 'value' => $this->dependencia_auditorio);
		    $this->inputsHelper()->checkbox('dependencia_auditorio', $options);

		    $options = array('label' => Portabilis_String_Utils::toLatin1('Depend�ncias existentes na escola � P�tio coberto'), 'value' => $this->dependencia_patio_coberto);
		    $this->inputsHelper()->checkbox('dependencia_patio_coberto', $options);

		}
	}

	function Novo()
	{

		@session_start();
		 $this->pessoa_logada = $_SESSION['id_pessoa'];
		@session_write_close();

		$obj_permissoes = new clsPermissoes();
		$obj_permissoes->permissao_cadastra( 561, $this->pessoa_logada, 3, "educar_escola_lst.php" );

    $this->bloquear_lancamento_diario_anos_letivos_encerrados = is_null($this->bloquear_lancamento_diario_anos_letivos_encerrados) ? 0 : 1;

		if ($this->com_cnpj)
		{
//			echo "clsPessoa_( false, $this->fantasia, $this->pessoa_logada, $this->p_http, "J", false, false, $this->p_email )";
			$objPessoa = new clsPessoa_( false, $this->fantasia, $this->pessoa_logada, $this->p_http, "J", false, false, $this->p_email );
			$this->ref_idpes = $objPessoa->cadastra();
			if ($this->ref_idpes)
			{
//				echo "clsJuridica( $this->ref_idpes,$this->cnpj,$this->fantasia,false,false,$this->pessoa_logada )";
				$obj_pes_juridica = new clsJuridica( $this->ref_idpes,$this->cnpj,$this->fantasia,false,false,$this->pessoa_logada );
				$cadastrou = $obj_pes_juridica->cadastra();

				if ($cadastrou)
				{
					$obj = new clsPmieducarEscola( null, $this->pessoa_logada, null, $this->ref_cod_instituicao, $this->ref_cod_escola_localizacao, $this->ref_cod_escola_rede_ensino, $this->ref_idpes, $this->sigla, null, null, 1, NULL, $this->bloquear_lancamento_diario_anos_letivos_encerrados);
					$obj->situacao_funcionamento = $this->situacao_funcionamento;
					$obj->dependencia_administrativa = $this->dependencia_administrativa;
					$obj->regulamentacao = $this->regulamentacao;
					$obj->acesso = $this->acesso;
					$obj->ref_idpes_gestor = $this->gestor_id;
					$obj->cargo_gestor = $this->cargo_gestor;
					$obj->condicao = $this->condicao;
					$obj->decreto_criacao = $this->decreto_criacao;
					$obj->area_terreno_total = $this->area_terreno_total;
					$obj->area_construida = $this->area_construida;
					$obj->area_disponivel = $this->area_disponivel;
					$obj->num_pavimentos = $this->num_pavimentos;
					$obj->tipo_piso = $this->tipo_piso;
					$obj->medidor_energia = $this->medidor_energia;
					$obj->agua_consumida = $this->agua_consumida == 'on' ? 1 : 0;
					$obj->agua_rede_publica = $this->agua_rede_publica == 'on' ? 1 : 0;
					$obj->agua_poco_artesiano = $this->agua_poco_artesiano == 'on' ? 1 : 0;
					$obj->agua_cacimba_cisterna_poco = $this->agua_cacimba_cisterna_poco == 'on' ? 1 : 0;
					$obj->agua_fonte_rio = $this->agua_fonte_rio == 'on' ? 1 : 0;
					$obj->agua_inexistente = $this->agua_inexistente == 'on' ? 1 : 0;
					$obj->energia_rede_publica = $this->energia_rede_publica == 'on' ? 1 : 0;
					$obj->energia_gerador = $this->energia_gerador == 'on' ? 1 : 0;
					$obj->energia_outros = $this->energia_outros == 'on' ? 1 : 0;
					$obj->energia_inexistente = $this->energia_inexistente == 'on' ? 1 : 0;
					$obj->esgoto_rede_publica = $this->esgoto_rede_publica == 'on' ? 1 : 0;
					$obj->esgoto_fossa = $this->esgoto_fossa == 'on' ? 1 : 0;
					$obj->esgoto_inexistente = $this->esgoto_inexistente == 'on' ? 1 : 0;
					$obj->lixo_coleta_periodica = $this->lixo_coleta_periodica == 'on' ? 1 : 0;
					$obj->lixo_queima = $this->lixo_queima == 'on' ? 1 : 0;
					$obj->lixo_joga_outra_area = $this->lixo_joga_outra_area == 'on' ? 1 : 0;
					$obj->lixo_recicla = $this->lixo_recicla == 'on' ? 1 : 0;
					$obj->lixo_enterra = $this->lixo_enterra == 'on' ? 1 : 0;
					$obj->lixo_outros = $this->lixo_outros == 'on' ? 1 : 0;
					$obj->dependencia_sala_diretoria = $this->dependencia_sala_diretoria == 'on' ? 1 : 0;
					$obj->dependencia_sala_professores = $this->dependencia_sala_professores == 'on' ? 1 : 0;
					$obj->dependencia_sala_secretaria = $this->dependencia_sala_secretaria == 'on' ? 1 : 0;
					$obj->dependencia_laboratorio_informatica = $this->dependencia_laboratorio_informatica == 'on' ? 1 : 0;
					$obj->dependencia_laboratorio_ciencias = $this->dependencia_laboratorio_ciencias == 'on' ? 1 : 0;
					$obj->dependencia_sala_aee = $this->dependencia_sala_aee == 'on' ? 1 : 0;
					$obj->dependencia_quadra_coberta = $this->dependencia_quadra_coberta == 'on' ? 1 : 0;
					$obj->dependencia_quadra_descoberta = $this->dependencia_quadra_descoberta == 'on' ? 1 : 0;
					$obj->dependencia_cozinha = $this->dependencia_cozinha == 'on' ? 1 : 0;
					$obj->dependencia_biblioteca = $this->dependencia_biblioteca == 'on' ? 1 : 0;
					$obj->dependencia_sala_leitura = $this->dependencia_sala_leitura == 'on' ? 1 : 0;
					$obj->dependencia_parque_infantil = $this->dependencia_parque_infantil == 'on' ? 1 : 0;
					$obj->dependencia_bercario = $this->dependencia_bercario == 'on' ? 1 : 0;
					$obj->dependencia_banheiro_fora = $this->dependencia_banheiro_fora == 'on' ? 1 : 0;
					$obj->dependencia_banheiro_dentro = $this->dependencia_banheiro_dentro == 'on' ? 1 : 0;
					$obj->dependencia_banheiro_infantil = $this->dependencia_banheiro_infantil == 'on' ? 1 : 0;
					$obj->dependencia_banheiro_deficiente = $this->dependencia_banheiro_deficiente == 'on' ? 1 : 0;
					$obj->dependencia_banheiro_chuveiro = $this->dependencia_banheiro_chuveiro == 'on' ? 1 : 0;
					$obj->dependencia_refeitorio = $this->dependencia_refeitorio == 'on' ? 1 : 0;
					$obj->dependencia_dispensa = $this->dependencia_dispensa == 'on' ? 1 : 0;
					$obj->dependencia_aumoxarifado = $this->dependencia_aumoxarifado == 'on' ? 1 : 0;
					$obj->dependencia_auditorio = $this->dependencia_auditorio == 'on' ? 1 : 0;
					$obj->dependencia_patio_coberto = $this->dependencia_patio_coberto == 'on' ? 1 : 0;					
					$cadastrou1 = $obj->cadastra();

					if( $cadastrou1 )
					{
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes);
						$objTelefone->excluiTodos();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 1, str_replace( "-", "", $this->p_telefone_1 ), $this->p_ddd_telefone_1 );
						$objTelefone->cadastra();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 2, str_replace( "-", "", $this->p_telefone_2 ), $this->p_ddd_telefone_2 );
						$objTelefone->cadastra();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 3, str_replace( "-", "", $this->p_telefone_mov ), $this->p_ddd_telefone_mov );
						$objTelefone->cadastra();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 4, str_replace( "-", "", $this->p_telefone_fax ), $this->p_ddd_telefone_fax );
						$objTelefone->cadastra();

						if ( !$this->isEnderecoExterno )
						{
//							die("Interno");
//							echo "<br>cep: ".$this->cep_;
//							$this->cep = idFederal2Int( $this->cep );
							$this->cep = $this->cep_;
//							echo "<br>cep: ".$this->cep;
//							echo "<br>clsPessoaEndereco( $this->ref_idpes, $this->cep, $this->idlog, $this->idbai, $this->numero, $this->complemento, false )";die;
							$objEndereco = new clsPessoaEndereco( $this->ref_idpes, $this->cep, $this->idlog, $this->idbai, $this->numero, $this->complemento, false );
							if( $objEndereco->detalhe() )
								$objEndereco->edita();
							else
								$objEndereco->cadastra();
						}
						else
						{
//							echo "<br>Externo";
//							echo "<br>cep_: ".$this->cep_;
							$this->cep = idFederal2int( $this->cep );
//							echo "<br>cep: ".$this->cep;
//							echo "<br>clsEnderecoExterno( $this->ref_idpes, 1, $this->idtlog, $this->logradouro, $this->numero, $this->letra, $this->complemento, $this->bairro, $this->cep, $this->cidade, $this->sigla_uf, false )";
							$objEnderecoExterno = new clsEnderecoExterno( $this->ref_idpes, "1", $this->idtlog, $this->logradouro, $this->numero, $this->letra, $this->complemento, $this->bairro, $this->cep, $this->cidade, $this->sigla_uf, false );
							if ( $objEnderecoExterno->existe() )
							{
//								echo "<br>editar";
								$objEnderecoExterno->edita();
							}
							else
							{
//								echo "<br>cadastra";
								$objEnderecoExterno->cadastra();
							}
						}

						//-----------------------CADASTRA CURSO------------------------//
						$this->escola_curso = unserialize( urldecode( $this->escola_curso ) );
						if ($this->escola_curso)
						{
//							echo "<pre>";print_r($this->escola_curso);die;
							foreach ( $this->escola_curso AS $campo )
							{
								$curso_escola = new clsPmieducarEscolaCurso( $cadastrou1, $campo, null, $this->pessoa_logada, null, null, 1 );
								$cadastrou_ = $curso_escola->cadastra();
								if ( !$cadastrou_ )
								{
									$this->mensagem = "Cadastro n&atilde;o realizado.<br>";
									echo "<!--\nErro ao cadastrar clsPmieducarEscolaCurso\nvalores obrigat&oacute;rios\nis_numeric( $cadastrou ) && is_numeric( {$campo} ) \n-->";
									return false;
								}
							}
						}
						//-----------------------FIM CADASTRA CURSO------------------------//
					}
					else
					{
						$this->mensagem = "Cadastro n&atilde;o realizado (clsPmieducarEscola).<br>";
//						echo "<!--\nErro ao cadastrar clsPmieducarEscola\nvalores obrigat&oacute;rios\nis_numeric( $this->pessoa_logada ) && is_numeric( {$campo[$i]} ) \n-->";
						return false;
					}
				}
				else
				{
					$this->mensagem = "Cadastro n&atilde;o realizado (clsJuridica).<br>";
//						echo "<!--\nErro ao cadastrar clsPmieducarEscola\nvalores obrigat&oacute;rios\nis_numeric( $this->pessoa_logada ) && is_numeric( {$campo[$i]} ) \n-->";
					return false;
				}
				$this->mensagem .= "Cadastro efetuado com sucesso.<br>";
				header( "Location: educar_escola_lst.php" );
				die();
				return true;
			}
			else
			{
				$this->mensagem = "Cadastro n&atilde;o realizado (clsPessoa_).<br>";
				return false;
			}
		}
		else if( $this->sem_cnpj )
		{
			$obj = new clsPmieducarEscola( null, $this->pessoa_logada, null, $this->ref_cod_instituicao, $this->ref_cod_escola_localizacao, $this->ref_cod_escola_rede_ensino, null, $this->sigla, null, null, 1, null, $this->bloquear_lancamento_diario_anos_letivos_encerrados );
			$obj->dependencia_administrativa = $this->dependencia_administrativa;
			$obj->regulamentacao = $this->regulamentacao;
			$obj->situacao_funcionamento = $this->situacao_funcionamento;
			$obj->acesso = $this->acesso;
			$obj->ref_idpes_gestor = $this->gestor_id;
			$obj->cargo_gestor = $this->cargo_gestor;
			$obj->condicao = $this->condicao;
			$obj->decreto_criacao = $this->decreto_criacao;
			$obj->area_terreno_total = $this->area_terreno_total;
			$obj->area_construida = $this->area_construida;
			$obj->area_disponivel = $this->area_disponivel;
			$obj->num_pavimentos = $this->num_pavimentos;		
			$obj->tipo_piso = $this->tipo_piso;
			$obj->medidor_energia = $this->medidor_energia;
			$obj->agua_consumida = $this->agua_consumida == 'on' ? 1 : 0;
			$obj->agua_rede_publica = $this->agua_rede_publica == 'on' ? 1 : 0;
			$obj->agua_poco_artesiano = $this->agua_poco_artesiano == 'on' ? 1 : 0;
			$obj->agua_cacimba_cisterna_poco = $this->agua_cacimba_cisterna_poco == 'on' ? 1 : 0;
			$obj->agua_fonte_rio = $this->agua_fonte_rio == 'on' ? 1 : 0;
			$obj->agua_inexistente = $this->agua_inexistente == 'on' ? 1 : 0;	
			$obj->energia_rede_publica = $this->energia_rede_publica == 'on' ? 1 : 0;
			$obj->energia_gerador = $this->energia_gerador == 'on' ? 1 : 0;
			$obj->energia_outros = $this->energia_outros == 'on' ? 1 : 0;
			$obj->energia_inexistente = $this->energia_inexistente == 'on' ? 1 : 0;
			$obj->esgoto_rede_publica = $this->esgoto_rede_publica == 'on' ? 1 : 0;
			$obj->esgoto_fossa = $this->esgoto_fossa == 'on' ? 1 : 0;
			$obj->esgoto_inexistente = $this->esgoto_inexistente == 'on' ? 1 : 0;
			$obj->lixo_coleta_periodica = $this->lixo_coleta_periodica == 'on' ? 1 : 0;
			$obj->lixo_queima = $this->lixo_queima == 'on' ? 1 : 0;
			$obj->lixo_joga_outra_area = $this->lixo_joga_outra_area == 'on' ? 1 : 0;
			$obj->lixo_recicla = $this->lixo_recicla == 'on' ? 1 : 0;
			$obj->lixo_enterra = $this->lixo_enterra == 'on' ? 1 : 0;
			$obj->lixo_outros = $this->lixo_outros == 'on' ? 1 : 0;
			$obj->dependencia_sala_diretoria = $this->dependencia_sala_diretoria == 'on' ? 1 : 0;
			$obj->dependencia_sala_professores = $this->dependencia_sala_professores == 'on' ? 1 : 0;
			$obj->dependencia_sala_secretaria = $this->dependencia_sala_secretaria == 'on' ? 1 : 0;
			$obj->dependencia_laboratorio_informatica = $this->dependencia_laboratorio_informatica == 'on' ? 1 : 0;
			$obj->dependencia_laboratorio_ciencias = $this->dependencia_laboratorio_ciencias == 'on' ? 1 : 0;
			$obj->dependencia_sala_aee = $this->dependencia_sala_aee == 'on' ? 1 : 0;
			$obj->dependencia_quadra_coberta = $this->dependencia_quadra_coberta == 'on' ? 1 : 0;
			$obj->dependencia_quadra_descoberta = $this->dependencia_quadra_descoberta == 'on' ? 1 : 0;
			$obj->dependencia_cozinha = $this->dependencia_cozinha == 'on' ? 1 : 0;
			$obj->dependencia_biblioteca = $this->dependencia_biblioteca == 'on' ? 1 : 0;
			$obj->dependencia_sala_leitura = $this->dependencia_sala_leitura == 'on' ? 1 : 0;
			$obj->dependencia_parque_infantil = $this->dependencia_parque_infantil == 'on' ? 1 : 0;
			$obj->dependencia_bercario = $this->dependencia_bercario == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_fora = $this->dependencia_banheiro_fora == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_dentro = $this->dependencia_banheiro_dentro == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_infantil = $this->dependencia_banheiro_infantil == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_deficiente = $this->dependencia_banheiro_deficiente == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_chuveiro = $this->dependencia_banheiro_chuveiro == 'on' ? 1 : 0;
			$obj->dependencia_refeitorio = $this->dependencia_refeitorio == 'on' ? 1 : 0;
			$obj->dependencia_dispensa = $this->dependencia_dispensa == 'on' ? 1 : 0;
			$obj->dependencia_aumoxarifado = $this->dependencia_aumoxarifado == 'on' ? 1 : 0;
			$obj->dependencia_auditorio = $this->dependencia_auditorio == 'on' ? 1 : 0;
			$obj->dependencia_patio_coberto = $this->dependencia_patio_coberto == 'on' ? 1 : 0;
			$cadastrou = $obj->cadastra();



			if ($cadastrou)
			{
				$obj2 = new clsPmieducarEscolaComplemento( $cadastrou, null, $this->pessoa_logada, idFederal2int( $this->cep ),$this->numero,$this->complemento,$this->p_email,$this->fantasia,$this->cidade,$this->bairro,$this->logradouro,$this->p_ddd_telefone_1, $this->p_telefone_1,$this->p_ddd_telefone_fax, $this->p_telefone_fax,null,null,1);
				$cadastrou2 = $obj2->cadastra();
				if ($cadastrou2)
				{
					//-----------------------CADASTRA CURSO------------------------//
					$this->escola_curso = unserialize( urldecode( $this->escola_curso ) );
					if ($this->escola_curso)
					{
						foreach ( $this->escola_curso AS $campo )
						{
							$curso_escola = new clsPmieducarEscolaCurso( $cadastrou, $campo, null, $this->pessoa_logada, null, null, 1 );
							$cadastrou_ = $curso_escola->cadastra();
							if ( !$cadastrou_ )
							{
								$this->mensagem = "Cadastro n&atilde;o realizado.<br>";
								echo "<!--\nErro ao cadastrar clsPmieducarEscolaCurso\nvalores obrigat&oacute;rios\nis_numeric( $cadastrou ) && is_numeric( {$campo} ) \n-->";
								return false;
							}
						}
					}
					//-----------------------FIM CADASTRA CURSO------------------------//
					$this->mensagem .= "Cadastro efetuado com sucesso.<br>";
					header( "Location: educar_escola_lst.php" );
					die();
					return true;
				}
				else
				{
					$this->mensagem = "Cadastro n&atilde;o realizado.<br>";
					echo "<!--\nErro ao cadastrar clsPmieducarEscolaComplemento\nvalores obrigat&oacute;rios\nis_numeric( $cadastrou ) && is_numeric( $this->pessoa_logada ) && is_numeric( $this->numero ) && is_string( $this->complemento ) && is_string( $this->p_email ) && is_string( $this->fantasia ) && is_string( $this->cidade ) && is_string( $this->bairro )\n-->";
					return false;
				}
			}
			else
			{
				$this->mensagem = "Cadastro n&atilde;o realizado (clsPmieducarEscola).<br>";
//				echo "<!--\nErro ao cadastrar clsPmieducarEscolaComplemento\nvalores obrigat&oacute;rios\nis_numeric( $cadastrou ) && is_numeric( $this->pessoa_logada ) && is_numeric( $this->numero ) && is_string( $this->complemento ) && is_string( $this->p_email ) && is_string( $this->fantasia ) && is_string( $this->cidade ) && is_string( $this->bairro )\n-->";
				return false;
			}
		}
	}

	function Editar()
	{

		@session_start();
		 $this->pessoa_logada = $_SESSION['id_pessoa'];
		@session_write_close();

		$obj_permissoes = new clsPermissoes();
		$obj_permissoes->permissao_cadastra( 561, $this->pessoa_logada, 7, "educar_escola_lst.php" );

    $this->bloquear_lancamento_diario_anos_letivos_encerrados = is_null($this->bloquear_lancamento_diario_anos_letivos_encerrados) ? 0 : 1;

//
//		echo "<br>cep: ".$this->cep;
//		echo "<br>cep_: ".$this->cep_;die;
		if ($this->cod_escola)
		{
			$obj = new clsPmieducarEscola($this->cod_escola, null, $this->pessoa_logada, $this->ref_cod_instituicao, $this->ref_cod_escola_localizacao, $this->ref_cod_escola_rede_ensino, $this->ref_idpes, $this->sigla, null, null, 1, $this->bloquear_lancamento_diario_anos_letivos_encerrados);
			$obj->dependencia_administrativa = $this->dependencia_administrativa;
			$obj->regulamentacao = $this->regulamentacao;
			$obj->situacao_funcionamento = $this->situacao_funcionamento;
			$obj->acesso = $this->acesso;
			$obj->ref_idpes_gestor = $this->gestor_id;
			$obj->cargo_gestor = $this->cargo_gestor;
			$obj->condicao = $this->condicao;
			$obj->decreto_criacao = $this->decreto_criacao;
			$obj->area_terreno_total = $this->area_terreno_total;
			$obj->area_construida = $this->area_construida;
			$obj->area_disponivel = $this->area_disponivel;
			$obj->num_pavimentos = $this->num_pavimentos;			
			$obj->tipo_piso = $this->tipo_piso;
			$obj->medidor_energia = $this->medidor_energia;
			$obj->agua_consumida = $this->agua_consumida == 'on' ? 1 : 0;
			$obj->agua_rede_publica = $this->agua_rede_publica == 'on' ? 1 : 0;
			$obj->agua_poco_artesiano = $this->agua_poco_artesiano == 'on' ? 1 : 0;
			$obj->agua_cacimba_cisterna_poco = $this->agua_cacimba_cisterna_poco == 'on' ? 1 : 0;
			$obj->agua_fonte_rio = $this->agua_fonte_rio == 'on' ? 1 : 0;
			$obj->agua_inexistente = $this->agua_inexistente == 'on' ? 1 : 0;
			$obj->energia_rede_publica = $this->energia_rede_publica == 'on' ? 1 : 0;
			$obj->energia_gerador = $this->energia_gerador == 'on' ? 1 : 0;
			$obj->energia_outros = $this->energia_outros == 'on' ? 1 : 0;
			$obj->energia_inexistente = $this->energia_inexistente == 'on' ? 1 : 0;
			$obj->esgoto_rede_publica = $this->esgoto_rede_publica == 'on' ? 1 : 0;
			$obj->esgoto_fossa = $this->esgoto_fossa == 'on' ? 1 : 0;
			$obj->esgoto_inexistente = $this->esgoto_inexistente == 'on' ? 1 : 0;
			$obj->lixo_coleta_periodica = $this->lixo_coleta_periodica == 'on' ? 1 : 0;
			$obj->lixo_queima = $this->lixo_queima == 'on' ? 1 : 0;
			$obj->lixo_joga_outra_area = $this->lixo_joga_outra_area == 'on' ? 1 : 0;
			$obj->lixo_recicla = $this->lixo_recicla == 'on' ? 1 : 0;
			$obj->lixo_enterra = $this->lixo_enterra == 'on' ? 1 : 0;
			$obj->lixo_outros = $this->lixo_outros == 'on' ? 1 : 0;	
			$obj->dependencia_sala_diretoria = $this->dependencia_sala_diretoria == 'on' ? 1 : 0;
			$obj->dependencia_sala_professores = $this->dependencia_sala_professores == 'on' ? 1 : 0;
			$obj->dependencia_sala_secretaria = $this->dependencia_sala_secretaria == 'on' ? 1 : 0;
			$obj->dependencia_laboratorio_informatica = $this->dependencia_laboratorio_informatica == 'on' ? 1 : 0;
			$obj->dependencia_laboratorio_ciencias = $this->dependencia_laboratorio_ciencias == 'on' ? 1 : 0;
			$obj->dependencia_sala_aee = $this->dependencia_sala_aee == 'on' ? 1 : 0;
			$obj->dependencia_quadra_coberta = $this->dependencia_quadra_coberta == 'on' ? 1 : 0;
			$obj->dependencia_quadra_descoberta = $this->dependencia_quadra_descoberta == 'on' ? 1 : 0;
			$obj->dependencia_cozinha = $this->dependencia_cozinha == 'on' ? 1 : 0;
			$obj->dependencia_biblioteca = $this->dependencia_biblioteca == 'on' ? 1 : 0;
			$obj->dependencia_sala_leitura = $this->dependencia_sala_leitura == 'on' ? 1 : 0;
			$obj->dependencia_parque_infantil = $this->dependencia_parque_infantil == 'on' ? 1 : 0;
			$obj->dependencia_bercario = $this->dependencia_bercario == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_fora = $this->dependencia_banheiro_fora == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_dentro = $this->dependencia_banheiro_dentro == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_infantil = $this->dependencia_banheiro_infantil == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_deficiente = $this->dependencia_banheiro_deficiente == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_chuveiro = $this->dependencia_banheiro_chuveiro == 'on' ? 1 : 0;
			$obj->dependencia_refeitorio = $this->dependencia_refeitorio == 'on' ? 1 : 0;
			$obj->dependencia_dispensa = $this->dependencia_dispensa == 'on' ? 1 : 0;
			$obj->dependencia_aumoxarifado = $this->dependencia_aumoxarifado == 'on' ? 1 : 0;
			$obj->dependencia_auditorio = $this->dependencia_auditorio == 'on' ? 1 : 0;
			$obj->dependencia_patio_coberto = $this->dependencia_patio_coberto == 'on' ? 1 : 0;		
			$editou = $obj->edita();

		}
		else
		{
			$obj = new clsPmieducarEscola(null, $this->pessoa_logada, null, $this->ref_cod_instituicao, $this->ref_cod_escola_localizacao, $this->ref_cod_escola_rede_ensino, $this->ref_idpes, $this->sigla, null, null, 1, $this->bloquear_lancamento_diario_anos_letivos_encerrados);
			$obj->situacao_funcionamento = $this->situacao_funcionamento;
			$obj->dependencia_administrativa = $this->dependencia_administrativa;
			$obj->regulamentacao = $this->regulamentacao;
			$obj->acesso = $this->acesso;
			$obj->ref_idpes_gestor = $this->gestor_id;
			$obj->cargo_gestor = $this->cargo_gestor;
			$obj->condicao = $this->condicao;
			$obj->decreto_criacao = $this->decreto_criacao;
			$obj->area_terreno_total = $this->area_terreno_total;
			$obj->area_construida = $this->area_construida;
			$obj->area_disponivel = $this->area_disponivel;
			$obj->num_pavimentos = $this->num_pavimentos;	
			$obj->tipo_piso = $this->tipo_piso;
			$obj->medidor_energia = $this->medidor_energia;
			$obj->agua_consumida = $this->agua_consumida == 'on' ? 1 : 0;
			$obj->agua_rede_publica = $this->agua_rede_publica == 'on' ? 1 : 0;
			$obj->agua_poco_artesiano = $this->agua_poco_artesiano == 'on' ? 1 : 0;
			$obj->agua_cacimba_cisterna_poco = $this->agua_cacimba_cisterna_poco == 'on' ? 1 : 0;
			$obj->agua_fonte_rio = $this->agua_fonte_rio == 'on' ? 1 : 0;
			$obj->agua_inexistente = $this->agua_inexistente == 'on' ? 1 : 0;		
			$obj->energia_rede_publica = $this->energia_rede_publica == 'on' ? 1 : 0;
			$obj->energia_gerador = $this->energia_gerador == 'on' ? 1 : 0;
			$obj->energia_outros = $this->energia_outros == 'on' ? 1 : 0;
			$obj->energia_inexistente = $this->energia_inexistente == 'on' ? 1 : 0;
			$obj->esgoto_rede_publica = $this->esgoto_rede_publica == 'on' ? 1 : 0;
			$obj->esgoto_fossa = $this->esgoto_fossa == 'on' ? 1 : 0;
			$obj->esgoto_inexistente = $this->esgoto_inexistente == 'on' ? 1 : 0;
			$obj->lixo_coleta_periodica = $this->lixo_coleta_periodica == 'on' ? 1 : 0;
			$obj->lixo_queima = $this->lixo_queima == 'on' ? 1 : 0;
			$obj->lixo_joga_outra_area = $this->lixo_joga_outra_area == 'on' ? 1 : 0;
			$obj->lixo_recicla = $this->lixo_recicla == 'on' ? 1 : 0;
			$obj->lixo_enterra = $this->lixo_enterra == 'on' ? 1 : 0;
			$obj->lixo_outros = $this->lixo_outros == 'on' ? 1 : 0;		
			$obj->dependencia_sala_diretoria = $this->dependencia_sala_diretoria == 'on' ? 1 : 0;
			$obj->dependencia_sala_professores = $this->dependencia_sala_professores == 'on' ? 1 : 0;
			$obj->dependencia_sala_secretaria = $this->dependencia_sala_secretaria == 'on' ? 1 : 0;
			$obj->dependencia_laboratorio_informatica = $this->dependencia_laboratorio_informatica == 'on' ? 1 : 0;
			$obj->dependencia_laboratorio_ciencias = $this->dependencia_laboratorio_ciencias == 'on' ? 1 : 0;
			$obj->dependencia_sala_aee = $this->dependencia_sala_aee == 'on' ? 1 : 0;
			$obj->dependencia_quadra_coberta = $this->dependencia_quadra_coberta == 'on' ? 1 : 0;
			$obj->dependencia_quadra_descoberta = $this->dependencia_quadra_descoberta == 'on' ? 1 : 0;
			$obj->dependencia_cozinha = $this->dependencia_cozinha == 'on' ? 1 : 0;
			$obj->dependencia_biblioteca = $this->dependencia_biblioteca == 'on' ? 1 : 0;
			$obj->dependencia_sala_leitura = $this->dependencia_sala_leitura == 'on' ? 1 : 0;
			$obj->dependencia_parque_infantil = $this->dependencia_parque_infantil == 'on' ? 1 : 0;
			$obj->dependencia_bercario = $this->dependencia_bercario == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_fora = $this->dependencia_banheiro_fora == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_dentro = $this->dependencia_banheiro_dentro == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_infantil = $this->dependencia_banheiro_infantil == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_deficiente = $this->dependencia_banheiro_deficiente == 'on' ? 1 : 0;
			$obj->dependencia_banheiro_chuveiro = $this->dependencia_banheiro_chuveiro == 'on' ? 1 : 0;
			$obj->dependencia_refeitorio = $this->dependencia_refeitorio == 'on' ? 1 : 0;
			$obj->dependencia_dispensa = $this->dependencia_dispensa == 'on' ? 1 : 0;
			$obj->dependencia_aumoxarifado = $this->dependencia_aumoxarifado == 'on' ? 1 : 0;
			$obj->dependencia_auditorio = $this->dependencia_auditorio == 'on' ? 1 : 0;
			$obj->dependencia_patio_coberto = $this->dependencia_patio_coberto == 'on' ? 1 : 0;
			$editou = $obj->cadastra();
			$this->cod_escola = $editou;

		}
		if( $editou )
		{
			if( $this->com_cnpj )
			{
				$objPessoa = new clsPessoa_( $this->ref_idpes, null, false, $this->p_http, false, $this->pessoa_logada, date( "Y-m-d H:i:s", time() ), $this->p_email );
				$editou1 = $objPessoa->edita();
				if ($editou1)
				{
					$obj_pes_juridica = new clsJuridica( $this->ref_idpes,$this->cnpj,$this->fantasia,false,false,false,$this->pessoa_logada );
					$editou2 = $obj_pes_juridica->edita();
					if ($editou2)
					{
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes);
						$objTelefone->excluiTodos();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 1, str_replace( "-", "", $this->p_telefone_1 ), $this->p_ddd_telefone_1 );
						$objTelefone->cadastra();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 2, str_replace( "-", "", $this->p_telefone_2 ), $this->p_ddd_telefone_2 );
						$objTelefone->cadastra();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 3, str_replace( "-", "", $this->p_telefone_mov ), $this->p_ddd_telefone_mov );
						$objTelefone->cadastra();
						$objTelefone = new clsPessoaTelefone( $this->ref_idpes, 4, str_replace( "-", "", $this->p_telefone_fax ), $this->p_ddd_telefone_fax );
						$objTelefone->cadastra();

						$objEndereco = new clsPessoaEndereco( $this->ref_idpes );
						$detEndereco = $objEndereco->detalhe();
						if ($this->cep) {
							$this->cep_ = idFederal2int($this->cep);
						}
						$this->cep = $this->cep;
						//echo "$this->ref_idpes, $this->cep_, $this->idlog, $this->idbai, $this->numero, $this->complemento, false, false, false, false, $this->andar ";die;
						//echo "<pre>";print_r($this);die;
	/*					$objEndereco2 = new clsPessoaEndereco( $this->ref_idpes, $this->cep_, $this->idlog, $this->idbai, $this->numero, $this->complemento, false, false, false, false, $this->andar );
						if ( $detEndereco && $this->cep_ && $this->idlog && $this->idbai )
							$objEndereco2->edita();
						elseif ( $this->cep_ && $this->idlog && $this->idbai )
							$objEndereco2->cadastra();

						elseif ( $detEndereco )
						{
							$objEndereco2->exclui();
							//$this->cep = $this->cep;
							$objEnderecoExterno = new clsEnderecoExterno( $this->ref_idpes );
							$detEnderecoExterno = $objEnderecoExterno->detalhe();

							//$this->cep = idFederal2int($this->cep) ;
							$objEnderecoExterno2 = new clsEnderecoExterno( $this->ref_idpes, "1", $this->idtlog, $this->logradouro, $this->numero, false, $this->complemento, $this->bairro, $this->cep_, $this->cidade, $this->sigla_uf, false, false, false, $this->andar );
							if( $detEnderecoExterno )
							{
								$objEnderecoExterno2->edita();
								if ( $detEndereco )
									$objEndereco->exclui();
							}
							else
							{
								$objEnderecoExterno2->cadastra();
								if ( $detEndereco )
									$objEndereco->exclui();
							}
						}
						else
						{
							$objEnderecoExterno = new clsEnderecoExterno( $this->ref_idpes );
							$detEnderecoExterno = $objEnderecoExterno->detalhe();

							$objEnderecoExterno2 = new clsEnderecoExterno( $this->ref_idpes, "1", $this->idtlog, $this->logradouro, $this->numero, false, $this->complemento, $this->bairro, $this->cep_, $this->cidade, $this->sigla_uf, false, false, false, $this->andar );
							if( $detEnderecoExterno )
							{
								$objEnderecoExterno2->edita();
							}
							else
							{
								$objEnderecoExterno2->cadastra();
							}
						}*/
						if ( !$this->isEnderecoExterno )
						{
//							die("Interno");
//							echo "<br>cep: ".$this->cep_;
//							$this->cep = idFederal2Int( $this->cep );
							$this->cep = $this->cep_;
//							echo "<br>cep: ".$this->cep;
//							echo "<br>clsPessoaEndereco( $this->ref_idpes, $this->cep, $this->idlog, $this->idbai, $this->numero, $this->complemento, false )";die;
							$objEndereco = new clsPessoaEndereco( $this->ref_idpes, $this->cep, $this->idlog, $this->idbai, $this->numero, $this->complemento, false );
							if( $objEndereco->detalhe() )
								$objEndereco->edita();
							else
								$objEndereco->cadastra();
						}
						else
						{
//							echo "<br>Externo";
//							echo "<br>cep_: ".$this->cep_;
							$this->cep = idFederal2int( $this->cep );
//							echo "<br>cep: ".$this->cep;
//							echo "<br>clsEnderecoExterno( $this->ref_idpes, 1, $this->idtlog, $this->logradouro, $this->numero, $this->letra, $this->complemento, $this->bairro, $this->cep, $this->cidade, $this->sigla_uf, false )";
							$objEnderecoExterno = new clsEnderecoExterno( $this->ref_idpes, "1", $this->idtlog, $this->logradouro, $this->numero, $this->letra, $this->complemento, $this->bairro, $this->cep, $this->cidade, $this->sigla_uf, false );
							if ( $objEnderecoExterno->existe() )
							{
//								echo "<br>editar";
								$objEnderecoExterno->edita();
							}
							else
							{
//								echo "<br>cadastra";
								$objEnderecoExterno->cadastra();
							}
						}
						//-----------------------EDITA CURSO------------------------//
						$this->escola_curso = unserialize( urldecode( $this->escola_curso ) );
						$obj  = new clsPmieducarEscolaCurso( $this->cod_escola );
						$excluiu = $obj->excluirTodos();

						if ( $excluiu )
						{
							if ($this->escola_curso)
							{
//								die("com cnpj");
								foreach ( $this->escola_curso AS $campo )
								{
									$obj = new clsPmieducarEscolaCurso( $this->cod_escola, $campo, null, $this->pessoa_logada, null, null, 1 );
									$cadastrou_  = $obj->cadastra();
									if ( !$cadastrou_ )
									{
										$this->mensagem = "Edi&ccedil;&atilde;o n&atilde;o realizada.<br>";
										echo "<!--\nErro ao editar clsPmieducarEscolaCurso\nvalores obrigat&oacute;rios\nis_numeric( $this->cod_serie ) && is_numeric( {$campo} ) && is_numeric( $this->pessoa_logada )\n-->";
										return false;
									}
								}
							}
						}
						//-----------------------FIM EDITA CURSO------------------------//
						$this->mensagem .= "Edi&ccedil;&atilde;o efetuada com sucesso.<br>";
						header( "Location: educar_escola_lst.php" );
						die();
						return true;
					}

				/*if($this->cep && $this->idbai && $this->idlog)
				{
					$objEndereco = new clsPessoaEndereco( $this->ref_idpes );
					$objEndereco2 = new clsPessoaEndereco($this->ref_idpes,$this->cep,$this->idlog,$this->idbai,$this->numero,$this->complemento, false,false, false, false, $this->andar);
					if( $objEndereco->detalhe() )
					{
						$objEndereco2->edita();
					}
					else
					{
						$objEndereco2->cadastra();
					}
					$objPessoa = new clsPessoaFj();
					list( $this->cidade, $this->bairro, $this->logradouro, $this->cep, $this->idtlog, $this->sigla_uf, $this->bloco, $this->apartamento, $this->andar ) = $objPessoa->queryRapida($this->ref_idpes, "cidade", "bairro", "logradouro", "cep", "idtlog", "sigla_uf", "bloco", "apartamento", "andar" );
				}
				else
				{
					$this->cep_ = idFederal2int($this->cep_);
					$objEnderecoExterno = new clsEnderecoExterno( $this->ref_idpes );
					$objEnderecoExterno2 = new clsEnderecoExterno( $this->ref_idpes,"1",$this->idtlog,$this->logradouro,$this->numero,false,$this->complemento,$this->bairro,$this->cep_,$this->cidade,$this->sigla_uf,false,false,false, $this->andar);
					if( $objEnderecoExterno->detalhe() )
					{
						$objEnderecoExterno2->edita();
					}
					else
					{
						$objEnderecoExterno2->cadastra();
					}
				}*/

				}
			}
			else if( $this->sem_cnpj )
			{
				$objComplemento = new clsPmieducarEscolaComplemento( $this->cod_escola, $this->pessoa_logada, null,idFederal2int( $this->cep_ ),$this->numero,$this->complemento,$this->p_email,$this->fantasia,$this->cidade,$this->bairro,$this->logradouro,$this->p_ddd_telefone_1, $this->p_telefone_1,$this->p_ddd_telefone_fax, $this->p_telefone_fax);
				$editou1 = $objComplemento->edita();
				if ($editou1)
				{
					//-----------------------EDITA CURSO------------------------//
					$this->escola_curso = unserialize( urldecode( $this->escola_curso ) );
					$obj  = new clsPmieducarEscolaCurso( $this->cod_escola );
					$excluiu = $obj->excluirTodos();

					if ( $excluiu )
					{
						if ($this->escola_curso)
						{
//							die("sem cnpj");
							foreach ( $this->escola_curso AS $campo )
							{
									$obj = new clsPmieducarEscolaCurso( $this->cod_escola, $campo, null, $this->pessoa_logada, null, null, 1 );
									$cadastrou_  = $obj->cadastra();
									if ( !$cadastrou_ )
									{
										$this->mensagem = "Edi&ccedil;&atilde;o n&atilde;o realizada.<br>";
										echo "<!--\nErro ao editar clsPmieducarEscolaCurso\nvalores obrigat&oacute;rios\nis_numeric( $this->cod_serie ) && is_numeric( {$campo[$i]} ) && is_numeric( $this->pessoa_logada )\n-->";
										return false;
									}
							}
						}
					}
					//-----------------------FIM EDITA CURSO------------------------//
					$this->mensagem .= "Edi&ccedil;&atilde;o efetuada com sucesso.<br>";
					header( "Location: educar_escola_lst.php" );
					die();
					return true;
				}
				else
				{
					$this->mensagem = "Edi&ccedil;&atilde;o n&atilde;o realizada (clsPmieducarEscolaComplemento).<br>";
	//					echo "<!--\nErro ao editar clsPmieducarEscola\nvalores obrigatorios\nif( is_numeric( $this->cod_escola ) && is_numeric( $this->pessoa_logada ) )\n-->";
					return false;
				}
			}
		}

		$this->mensagem = "Edi&ccedil;&atilde;o n&atilde;o realizada.<br>";
		echo "<!--\nErro ao editar clsPmieducarEscola\nvalores obrigatorios\nif( is_numeric( $this->cod_escola ) && is_numeric( $this->pessoa_logada ) )\n-->";
		return false;
	}

	function Excluir()
	{
		@session_start();
		 $this->pessoa_logada = $_SESSION['id_pessoa'];
		@session_write_close();

		$obj_permissoes = new clsPermissoes();
		$obj_permissoes->permissao_cadastra( 561, $this->pessoa_logada, 3, "educar_escola_lst.php" );

		$obj = new clsPmieducarEscola( $this->cod_escola,null,$this->pessoa_logada,null,null,null,null,null,null,null,0 );
		$excluiu = $obj->excluir();
		if( $excluiu )
		{
			$this->mensagem .= "Exclus&atilde;o efetuada com sucesso.<br>";
			header( "Location: educar_escola_lst.php" );
			die();
			return true;
		}

		$this->mensagem = "Exclus&atilde;o n&atilde;o realizada.<br>";
		echo "<!--\nErro ao excluir clsPmieducarEscola\nvalores obrigatorios\nif( is_numeric( $this->cod_escola ) && is_numeric( $this->pessoa_logada ) )\n-->";
		return false;
	}
}

// cria uma extensao da classe base
$pagina = new clsIndexBase();
// cria o conteudo
$miolo = new indice();
// adiciona o conteudo na clsBase
$pagina->addForm( $miolo );
// gera o html
$pagina->MakeAll();
?>
<script>

function getRedeEnsino(xml_escola_rede_ensino)
{
	/*
	var campoInstituicao = document.getElementById('ref_cod_instituicao').value;
	var campoRedeEnsino = document.getElementById('ref_cod_escola_rede_ensino');

	campoRedeEnsino.length = 1;
	for (var j = 0; j < rede_ensino.length; j++)
	{
		if (rede_ensino[j][2] == campoInstituicao)
		{
			campoRedeEnsino.options[campoRedeEnsino.options.length] = new Option( rede_ensino[j][1], rede_ensino[j][0],false,false);
		}
	}
	*/
	var campoRedeEnsino = document.getElementById('ref_cod_escola_rede_ensino');
	var DOM_array = xml_escola_rede_ensino.getElementsByTagName( "escola_rede_ensino" );

	if(DOM_array.length)
	{
		campoRedeEnsino.length = 1;
		campoRedeEnsino.options[0].text = 'Selecione uma rede de ensino';
		campoRedeEnsino.disabled = false;

		for( var i = 0; i < DOM_array.length; i++ )
		{
			campoRedeEnsino.options[campoRedeEnsino.options.length] = new Option( DOM_array[i].firstChild.data, DOM_array[i].getAttribute("cod_escola_rede_ensino"),false,false);
		}
	}
	else
		campoRedeEnsino.options[0].text = 'A institui��o n�o possui nenhuma rede de ensino';
}

function getLocalizacao(xml_escola_localizacao)
{
	/*
	var campoInstituicao = document.getElementById('ref_cod_instituicao').value;
	var campoLocalizacao = document.getElementById('ref_cod_escola_localizacao');

	campoLocalizacao.length = 1;
	for (var j = 0; j < escola_localizacao.length; j++)
	{
		if (escola_localizacao[j][2] == campoInstituicao)
		{
			campoLocalizacao.options[campoLocalizacao.options.length] = new Option( escola_localizacao[j][1], escola_localizacao[j][0],false,false);
		}
	}
	*/
	var campoLocalizacao = document.getElementById('ref_cod_escola_localizacao');
	var DOM_array = xml_escola_localizacao.getElementsByTagName( "escola_localizacao" );

	if(DOM_array.length)
	{
		campoLocalizacao.length = 1;
		campoLocalizacao.options[0].text = 'Selecione uma localiza��o';
		campoLocalizacao.disabled = false;

		for( var i = 0; i < DOM_array.length; i++ )
		{
			campoLocalizacao.options[campoLocalizacao.options.length] = new Option( DOM_array[i].firstChild.data, DOM_array[i].getAttribute("cod_escola_localizacao"),false,false);
		}
	}
	else
		campoLocalizacao.options[0].text = 'A institui��o n�o possui nenhuma localiza��o';
}

function getCurso(xml_curso)
{
	/*
	var campoInstituicao = document.getElementById('ref_cod_instituicao').value;
	var campoCurso = document.getElementById('ref_cod_curso');

	campoCurso.length = 1;
	for (var j = 0; j < curso.length; j++)
	{
		if (curso[j][2] == campoInstituicao)
		{
			campoCurso.options[campoCurso.options.length] = new Option( curso[j][1], curso[j][0],false,false);
		}
	}
	*/
	var campoCurso = document.getElementById('ref_cod_curso');
	var DOM_array = xml_curso.getElementsByTagName( "curso" );

	if(DOM_array.length)
	{
		campoCurso.length = 1;
		campoCurso.options[0].text = 'Selecione um curso';
		campoCurso.disabled = false;

		for( var i = 0; i < DOM_array.length; i++ )
		{
			campoCurso.options[campoCurso.options.length] = new Option( DOM_array[i].firstChild.data, DOM_array[i].getAttribute("cod_curso"),false,false);
		}
	}
	else
		campoCurso.options[0].text = 'A institui��o n�o possui nenhum curso';
}


if ( document.getElementById('ref_cod_instituicao') )
{
	document.getElementById('ref_cod_instituicao').onchange = function()
	{
		/*getRedeEnsino();
		getLocalizacao();
		getCurso();*/
		var campoInstituicao = document.getElementById('ref_cod_instituicao').value;

		var campoRedeEnsino = document.getElementById('ref_cod_escola_rede_ensino');
		campoRedeEnsino.length = 1;
		campoRedeEnsino.disabled = true;
		campoRedeEnsino.options[0].text = 'Carregando rede de ensino';

		var campoLocalizacao = document.getElementById('ref_cod_escola_localizacao');
		campoLocalizacao.length = 1;
		campoLocalizacao.disabled = true;
		campoLocalizacao.options[0].text = 'Carregando localiza��o';

		var campoCurso = document.getElementById('ref_cod_curso');
		campoCurso.length = 1;
		campoCurso.disabled = true;
		campoCurso.options[0].text = 'Carregando curso';

		var xml_escola_rede_ensino = new ajax( getRedeEnsino );
		xml_escola_rede_ensino.envia( "educar_escola_rede_ensino_xml.php?ins="+campoInstituicao );

		var xml_escola_localizacao = new ajax( getLocalizacao );
		xml_escola_localizacao.envia( "educar_escola_localizacao_xml.php?ins="+campoInstituicao );

		var xml_curso = new ajax( getCurso );
		xml_curso.envia( "educar_curso_xml2.php?ins="+campoInstituicao );

		if (this.value == '')
		{
			$('img_rede_ensino').style.display = 'none;';
			$('img_localizacao').style.display = 'none;';
		}
		else
		{
			$('img_rede_ensino').style.display = '';
			$('img_localizacao').style.display = '';
		}

	}
}

</script>
