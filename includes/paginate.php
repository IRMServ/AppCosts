<?php

/**
 * Cria uma paginação de resultados, indicando-se a tabela a se paginar, 
 * quantos resultados por pagina, qual página começar a paginar, se a tabela possui o campo ‘ativo’,
 * se de uma plataforma específica ou de um cliente específico.
 * @global resource $conn Conexão externa ao banco
 * @param string $table Qual tabela paginar
 * @param integer $perpage Quantos registros por página
 * @param integer $page Qual página atual
 * @param bool $ativo Se o registro está ativo
 * @param integer $plataform Qual paltaforma
 * @param integer $client Qual cliente
 * @return mixed
 */
function paginate($table, $perpage = 20, $page = 1, $ativo = false, $plataform = 0, $client = 0) {
    global $conn;
    $queryt = "select count(*) as total from {$table}";
    $queryt .= $plataform != 0 || $plataform != 0 || $client != 0 || $ativo ? " where " : '';
    $queryt .= $plataform != 0 ? " textos_fk={$plataform}" : '';
    $queryt .= $client != 0 ? " and Clientes_fk={$client}" : '';
    $queryt .= $plataform != 0 && $ativo ? ' and' : '';
    $queryt .= $ativo ? ' ativo=1' : '';
    //exit($queryt);
    $qt = $conn->query($queryt);
    $rt = $qt->fetch_object();
    $show = $perpage * $page;
if($page == 1 || $page == 0){$show = 0;}
    $pages = ceil($rt->total / $perpage);
    $id = "id{$table}" ;
    $queryp = "Select * from {$table}";
    $queryp .= $plataform != 0 || $plataform != 0 || $client != 0 || $ativo ? " where " : '';
    $queryp .= $plataform != 0 ? "  textos_fk={$plataform}" : '';
    $queryp .= $plataform != 0 && $ativo ? ' and' : '';
    $queryp .= $ativo ? " ativo=1" : '';

    $queryp .= "  order by {$id} desc limit {$show},{$perpage}";
    //exit($queryp);
    $qp = $conn->query($queryp);
    $return = array();
    $disabled = $page == 0 ? 'disabled' : '';
    $disabledp = $page == ($pages - 1) ? 'disabled' : '';

    $prev = $page == 0 ? $page : $page - 1;
    $next = $page == $pages - 1 ? $page : $page + 1;
    $red = '';
    if ($pages > 1) {
        $querystring = '';
        if (isset($_SERVER['QUERY_STRING'])) {
            $querystring .= $_SERVER['QUERY_STRING'] . '&';
        }
        $red .= "<div class=\"pagination  pagination-centered\">
              <ul>
                  <li class=\"{$disabled}\"><a href=\"?{$querystring}page={$prev}\">Prev</a></li>";


        for ($i = 0; $i < $pages; $i++) {
            $p = $i + 1;
            $red .= "<li class=''><a href=\"?{$querystring}page={$i}\">{$p}</a></li>";
        }

        $red .= "<li class=\"{$disabledp}\"><a href=\"?{$querystring}page={$next}\">Next</a></li>";
        $red .="</ul>
            </div>";
    }

    $return[0] = $red;
    $return[1] = $qp;
    return $return;
}