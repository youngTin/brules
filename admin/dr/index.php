<?php
    require_once('../../sys_load.php');
    require_once('../../data/cache/base_code.php');
    $smarty = new WebSmarty;
    //$smarty->caching = FALSE;
    $pdo = new MysqlPdo();
    
    $pageSize = 15;
    $offset = 0;
    $subPages=15;//每次显示的页数
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
    if($currentPage>0) $offset=($currentPage-1)*$pageSize;
    
    $_GET['type'] = empty($_GET['type'])&&$_GET['type']!='1' ? 0 : 1;
    
    $values1 = $values2 = array(0,0,0,0);
    
    $elems = array('in_province', 'in_city', 'in_dist');
    $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>';

    $where = doRequestFilter($_GET);
    $limit = " limit $offset,$pageSize ";
    $sql = " select * from ".DB_PREFIX_DR."info where $where $limit";
    $info = $pdo->getAll($sql);
    $count = $pdo->find(DB_PREFIX_DR.'info ',$where,'count(id) as count');
    $smarty->assign('info',$info);
    
    $page_info = "type={$_GET['type']}&";
    $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
    $subPages=$page->get_page_html();
    
    $smarty->assign('num',$count['count']);
    $smarty->assign('pagesize',$pageSize);
    $smarty->assign('subPages',$subPages);
    //$elems = array('on_province', 'on_city', 'on_dist');
//    $dist2 = '<span id="residedistrictbox2">'.showdistricts($values2, $elems, 'residedistrictbox2').'</span>';
    
    $smarty->assign('dist1',$dist1);
//    $smarty->assign('dist2',$dist2);

    $smarty->assign('crecate_radio',$crecate_radio);
    $smarty->assign('score_option',$score_option);
    $smarty->assign('crecate',$crecate_radio);
    $smarty->assign('min_expectprice',$min_expectprice_option);
    $smarty->assign('task_status',$task_status);
    $smarty->assign('type',$_GET['type']);
    $smarty->show();
    
    /**
    *处理传值 
    */
    function doRequestFilter($request)
    {
        $where  = '  1  ';
        $where .= " and type = '{$request['type']}'";
        if(!empty($request['on_province'])){
            $where .= " and on_province = '{$request['on_province']}'";
            if(!empty($request['on_city'])){
                $where .= " and on_city = '{$request['on_city']}'";
                if(!empty($request['on_dist'])){
                    $where .= " and on_dist = '{$request['on_dist']}'";
                }
            }
        }
        
        $where .=  !empty($request['crecate']) ? " and crecate = '{$request['crecate']}'" : '';
        if(!empty($request['score']))
        {
            $where .=   " and score >= '{$request['score']}' " ;
        }
        $where .=  !empty($request['min_expectprice']) ? " and min_expectprice <= '{$request['min_expectprice']}'" : '';
        $where .=  !empty($request['licensdate']) ? " and licensdate >= '".($request['licensdate'])."'" : '';
        return $where;
    }
    
?>