<?php
/*
 * E-cidade Software Publico para Gestao Municipal
 * Copyright (C) 2014 DBSeller Servicos de Informatica
 * www.dbseller.com.br
 * e-cidade@dbseller.com.br
 *
 * Este programa e software livre; voce pode redistribui-lo e/ou
 * modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 * publicada pela Free Software Foundation; tanto a versao 2 da
 * Licenca como (a seu criterio) qualquer versao mais nova.
 *
 * Este programa e distribuido na expectativa de ser util, mas SEM
 * QUALQUER GARANTIA; sem mesmo a garantia implicita de
 * COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 * PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 * detalhes.
 *
 * Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 * junto com este programa; se nao, escreva para a Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307, USA.
 *
 * Copia da licenca no diretorio licenca/licenca_en.txt
 * licenca/licenca_pt.txt
 */
class cl_slipdepartamento extends DAOBasica {
	public function __construct() {
		parent::__construct ( "plugins.slipdepartamento" );
	}
	
	public function sql_query_departamento($k17_codigo = null, $campos = "*", $ordem = null, $dbwhere = "") {
		$sql = "select ";
		if ($campos != "*") {
			$campos_sql = split ( "#", $campos );
			$virgula = "";
			for($i = 0; $i < sizeof ( $campos_sql ); $i ++) {
				$sql .= $virgula . $campos_sql [$i];
				$virgula = ",";
			}
		} else {
			$sql .= $campos;
		}
		
		$sql .= "from slip ";
		$sql .= " left join plugins.slipdepartamento sd on sd.slip            	 = slip.k17_codigo";
		$sql .= " left join db_depart   dep             on dep.coddepto 		 = sd.departamento";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($k17_codigo != null) {
				$sql2 .= " where slip.k17_codigo = $k17_codigo ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql2 .= ($sql2 != "" ? " and " : " where ") . " k17_instit = " . db_getsession ( "DB_instit" );
		$sql .= $sql2;
		if ($ordem != null) {
			$sql .= " order by ";
			$campos_sql = split ( "#", $ordem );
			$virgula = "";
			for($i = 0; $i < sizeof ( $campos_sql ); $i ++) {
				$sql .= $virgula . $campos_sql [$i];
				$virgula = ",";
			}
		}
		return $sql;
	}
	
	public function sql_query_txtbanco($e89_codmov = null, $campos = "*", $ordem = null, $dbwhere = "") {
		$sql = "select ";
		if ($campos != "*") {
			$campos_sql = split ( "#", $campos );
			$virgula = "";
			for($i = 0; $i < sizeof ( $campos_sql ); $i ++) {
				$sql .= $virgula . $campos_sql [$i];
				$virgula = ",";
			}
		} else {
			$sql .= $campos;
		}
		
		$sql .= " from empageslip ";
		$sql .= "      inner join empagemov                on empagemov.e81_codmov             = empageslip.e89_codmov";
		$sql .= "      inner join empage   b               on b.e80_codage                     = empagemov.e81_codage";
		$sql .= "	   inner join empageconf               on e86_codmov                       = e81_codmov ";
		$sql .= "	   inner join empagemovforma           on e81_codmov                       = e97_codmov ";
		$sql .= "      inner join empagepag                on e85_codmov                       = empagemov.e81_codmov";
		$sql .= "      inner join empagetipo               on empagetipo.e83_codtipo           = empagepag.e85_codtipo";
		$sql .= "      inner join slip s                   on e89_codigo                       = s.k17_codigo";
		$sql .= "      inner join plugins.slipdepartamento on slipdepartamento.slip            = s.k17_codigo                  ";
		$sql .= "      inner join db_departorg             on db_departorg.db01_coddepto       = slipdepartamento.departamento ";
		$sql .= "                                         and db_departorg.db01_anousu         = " . db_getsession ( "DB_anousu" );
		$sql .= "      inner join orcunidade               on orcunidade.o41_unidade           = db_departorg.db01_unidade";
		$sql .= "                                         and orcunidade.o41_orgao             = db_departorg.db01_orgao";
		$sql .= "                                         and orcunidade.o41_anousu            = db_departorg.db01_anousu";
		$sql .= "      inner join orcorgao                 on orcorgao.o40_orgao               = orcunidade.o41_orgao  ";
		$sql .= "                                         and orcorgao.o40_anousu              = orcunidade.o41_anousu "; 
		$sql .= "	   inner join conplanoreduz pag        on pag.c61_reduz                    = e83_conta ";
		$sql .= "                                         and pag.c61_anousu                   = " . db_getsession ( "DB_anousu" );
		$sql .= "	   inner join conplano conpag          on conpag.c60_codcon                = pag.c61_codcon ";
		$sql .= "                                         and conpag.c60_anousu                = pag.c61_anousu ";
		$sql .= "	   inner join conplanoconta            on conpag.c60_codcon                = conplanoconta.c63_codcon "; 
		$sql .= "                                         and conpag.c60_anousu                = conplanoconta.c63_anousu ";
		$sql .= "      inner join conplanocontabancaria    on conplanocontabancaria.c56_codcon = conplanoconta.c63_codcon ";
        $sql .= "                                         and conplanocontabancaria.c56_anousu = conplanoconta.c63_anousu ";
		$sql .= "      inner join contabancaria            on contabancaria.db83_sequencial    = conplanocontabancaria.c56_contabancaria ";
		$sql .= "	   inner join orctiporec               on pag.c61_codigo                   = o15_codigo  ";
		$sql .= "       left join emphist                  on s.k17_hist                       = e40_codhist ";
		$sql .= "	   inner join slipnum o                on o.k17_codigo                     = s.k17_codigo";
		$sql .= "	    left join cgm                      on z01_numcgm                       = o.k17_numcgm";
		$sql .= "	    left join empageconfgera           on e81_codmov                       = e90_codmov  ";
		$sql .= "       left join empagemovconta           on empagemovconta.e98_codmov        = empagemov.e81_codmov ";
		$sql .= "       left join pcfornecon               on pcfornecon.pc63_contabanco       = empagemovconta.e98_contabanco";
		$sql .= "	    left join conplanoreduz cre        on cre.c61_reduz                    = k17_debito"; 
		$sql .= "                                         and cre.c61_anousu                   = " . db_getsession ( "DB_anousu" );
		$sql .= "	    left join conplano concre          on concre.c60_codcon                = cre.c61_codcon ";
		$sql .= "                                         and concre.c60_anousu                = cre.c61_anousu ";
		$sql .= "	    left join conplanoconta descrconta on concre.c60_codcon                = descrconta.c63_codcon"; 
		$sql .= "                                         and concre.c60_anousu                = descrconta.c63_anousu ";
		$sql .= "       left join empagemovtipotransmissao on e25_empagemov                    = empagemov.e81_codmov ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($e89_codmov != null) {
				$sql2 .= " where empageslip.e89_codmov = $e89_codmov ";
			}
			if ($e89_codigo != null) {
				if ($sql2 != "") {
					$sql2 .= " and ";
				} else {
					$sql2 .= " where ";
				}
				$sql2 .= " empageslip.e89_codigo = $e89_codigo ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql2 .= ($sql2 != "" ? " and " : " where ") . " k17_instit = " . db_getsession ( "DB_instit" );
		$sql .= $sql2;
		if ($ordem != null) {
			$sql .= " order by ";
			$campos_sql = split ( "#", $ordem );
			$virgula = "";
			for($i = 0; $i < sizeof ( $campos_sql ); $i ++) {
				$sql .= $virgula . $campos_sql [$i];
				$virgula = ",";
			}
		}
		return $sql;
	}
	
	
	function sql_query_txt($e81_codmov = null, $campos = "*", $ordem = null, $dbwhere = "") {
		$sql = "select ";
		if ($campos != "*") {
			$campos_sql = split ( "#", $campos );
			$virgula = "";
			for($i = 0; $i < sizeof ( $campos_sql ); $i ++) {
				$sql .= $virgula . $campos_sql [$i];
				$virgula = ",";
			}
		} else {
			$sql .= $campos;
		}
		$sql .= " from empagemov ";
		$sql .= "      inner join empagemovforma           on  empagemovforma.e97_codmov       = empagemov.e81_codmov            ";
		$sql .= "      inner join empage                   on  empage.e80_codage               = empagemov.e81_codage            ";
		$sql .= "      inner join empagepag                on  empagepag.e85_codmov            = empagemov.e81_codmov            ";
		$sql .= "      inner join empagetipo               on  empagetipo.e83_codtipo          = empagepag.e85_codtipo           ";
		$sql .= "      inner join conplanoreduz            on  conplanoreduz.c61_reduz         = empagetipo.e83_conta            ";
        $sql .= "                                         and  conplanoreduz.c61_anousu        = " . db_getsession ( "DB_anousu" ); 
        $sql .= "                                         and  conplanoreduz.c61_instit        = " . db_getsession ( "DB_instit" );
		$sql .= "      inner join conplanoconta            on conplanoconta.c63_codcon         = conplanoreduz.c61_codcon ";
		$sql .= "                                         and conplanoconta.c63_anousu         = conplanoreduz.c61_anousu ";
		$sql .= "      inner join conplanocontabancaria    on conplanocontabancaria.c56_codcon = conplanoconta.c63_codcon ";
        $sql .= "                                         and conplanocontabancaria.c56_anousu = conplanoconta.c63_anousu ";
		$sql .= "      inner join contabancaria            on contabancaria.db83_sequencial    =  conplanocontabancaria.c56_contabancaria ";
		$sql .= "      inner join empageconf               on empageconf.e86_codmov            = empagemov.e81_codmov          ";
		$sql .= "      left  join empageconfgera           on empageconfgera.e90_codmov        = empagemov.e81_codmov          ";
		$sql .= "      inner join empempenho               on empempenho.e60_numemp            = empagemov.e81_numemp          ";
		$sql .= "      inner join orcdotacao               on orcdotacao.o58_coddot            = empempenho.e60_coddot         ";
		$sql .= "                                         and orcdotacao.o58_anousu            = empempenho.e60_anousu         ";
		$sql .= "      inner join orcunidade               on orcunidade.o41_unidade           = orcdotacao.o58_unidade        ";
		$sql .= "                                         and orcunidade.o41_orgao             = orcdotacao.o58_orgao          ";
		$sql .= "                                         and orcunidade.o41_anousu            = orcdotacao.o58_anousu         ";
		$sql .= "      inner join orcorgao                 on orcorgao.o40_orgao               = orcunidade.o41_orgao          ";
		$sql .= "                                         and orcorgao.o40_anousu              = orcunidade.o41_anousu         ";		
		$sql .= "      inner join orctiporec               on orctiporec.o15_codigo            = orcdotacao.o58_codigo         ";
		$sql .= "      inner join empord                   on empord.e82_codmov                = empagemov.e81_codmov          ";
		$sql .= "      inner join pagordem                 on pagordem.e50_codord              = empord.e82_codord             ";
		$sql .= "      inner join pagordemele              on pagordem.e50_codord              = pagordemele.e53_codord        ";
		$sql .= "      left  join empagemovconta           on empagemovconta.e98_codmov        = empagemov.e81_codmov          ";
		$sql .= "      left  join pcfornecon               on pcfornecon.pc63_contabanco       = empagemovconta.e98_contabanco ";
		$sql .= "      left  join cgm                      on cgm.z01_numcgm                   = pcfornecon.pc63_numcgm        ";
		$sql .= "      left  join saltes                   on saltes.k13_conta                 = empagetipo.e83_conta          ";
		$sql .= "      left  join empagedadosretmov        on empagedadosretmov.e76_codmov     = empagemov.e81_codmov          ";
		$sql .= "      left  join empagemovtipotransmissao on e25_empagemov                    = empagemov.e81_codmov          ";
		
		$sql2 = "";
		if ($dbwhere == "") {
			if ($e81_codmov != null) {
				$sql2 .= " where empagemov.e81_codmov = $e81_codmov ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if ($ordem != null) {
			$sql .= " order by ";
			$campos_sql = split ( "#", $ordem );
			$virgula = "";
			for($i = 0; $i < sizeof ( $campos_sql ); $i ++) {
				$sql .= $virgula . $campos_sql [$i];
				$virgula = ",";
			}
		}
		return $sql;
	}
}