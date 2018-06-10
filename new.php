<?php
function emMsg($v) {
    echo($v);
}

 include_once 'mysql.php';
 
 class getList {
 
     private $db;
 
    function __construct() {
        $this->db = MySql::getInstance();
    }

    function getPkList($tid = null) {
        $res = $this->db->query('SELECT * FROM gamelist' . (empty($tid) ? '' : ' where gameTid=\'' . $tid . '\''));
        $list = array();
        if (!$this->db->num_rows($res))
            $list = $this->initList_4399();
        else
            while ($row = $this->db->fetch_array($res)) {
               $list[] = $row;
            }
        return $list;
    }

    /*
     * 初始化积分游戏
*/

    function initList_4399() {
        $this->db->query('delete from gamelist');

        $echo_arr = array();

        for ($j = 1; $j < 12; $j++) {
            $file_contents = iconv('gb2312', 'utf-8//ignore', file_get_contents('http://pk.4399.com/flash/' . $j . '_1.htm'));
            $out = array();
            //<a href="http://pk.4399.com/user/377.htm" target="_blank"><img title="野人钓鱼" alt="野人钓鱼" border="0" src="http://swfpk.4399pk.com:8080/4399pkbak/bak/pkimg/index_img/377.jpg" width="75" height="75"></a>
            if (preg_match_all('/<li><a href="http:\/\/pk\.4399\.com\/user\/(\d+)\.htm" target="\_blank"><img.*?title="(.*?)".*?src="(.*?)".*?><\/a><p>.*?<\/p><\/li>/', $file_contents, $out)) {
                //return $out;
                if (count($out) == 4) {
                    for ($i = 0; $i < count($out[1]); $i++) {
                        $sql = "insert into gamelist (gameId,gameName,gameImg,gameTid) values('{$out[1][$i]}','{$out[2][$i]}','{$out[3][$i]}','{$j}')";
                        $this->db->query($sql);
                        array_push($echo_arr, array($out[1][$i], $out[2][$i], $out[3][$i]));
                    }
                }
            }
            sleep(2);
        }
        return $echo_arr;
    }

    /*
     * 得到积分
 58      * $id 游戏ID
 59      * $total 个数
 60      * $model 模式 current 当前 all 总排行 month 月排行 last 上轮
 61 */

    function getSocre_4399($id, $model = 'all', $total = 3) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://my.4399.com/flashgame.php?ac=score_' . $model . '&gameid=' . $id);
        curl_setopt($curl, CURLOPT_COOKIE, 'Pauth=403370469|66847612|7082ed77f7c271b74d84de349009452a|1328319929|10002|bbeae2e37479547b7c0d5da25d8eb004|0;');
        //                                        403370469|66847612|c389c838712319dc773eef783f972fef|1328331099|10001|60bfe9367afff7e737d00b2f998dd7f8|0
        //                                        403370469|66847612|580ea10bd8ccf57035a31c7d2abef941|1328333572|10002|ef2b08825599a1fc7ef0ef399b630ca4|0
        //                                        403370469|66847612|0773296261e645a773fc245d039db2a6|1328333608|10002|83a5f67767d051e8f31d26df70445663|0
        //curl_setopt($curl, CURLOPT_REFERER, 'http://www.360buy.com/');
        //curl_setopt($curl,CURLOPT_HTTPHEADER,array('Referer:http://www.360buy.com/'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $file_contents = curl_exec($curl);
        curl_close($curl);
        //$file_contents = iconv('gb2312', 'utf-8//ignore', $file_contents);
        /* <td><a href="flashgame.php?ac=profile&uid=212607398">1051414225</a></td>
 77           <td>151478</td>
 78          * <td align="center"><a href="flashgame.php?ac=profile&uid=103301144">wawa6346</a></td><td align="center">172895</td>
 79          *  */
        //echo $file_contents;
        $out = array();
        if (preg_match_all('/<td.*?><a href="flashgame.php\?ac\=profile&uid=.*?">.*?<\/a><\/td>.*?<td.*?>(\d+)<\/td>/s', $file_contents, $out)) {
            $ret_array = array_slice($out[1], 0, $total);
            $sql = 'update gamelist set gameScore=\'' . json_encode($ret_array) . "' where gameId='{$id}'";
            $this->db->query($sql);
            return $ret_array;
        }
        return array();
        //echo $file_contents;
    }

    function setSocre_4399($id, $m = null, $arr = null) {
        if (empty($arr)) {
            $arr = $this->db->once_fetch_array('SELECT gameScore FROM gamelist where gameId=\'' . $id . '\'');
            $arr = json_decode($arr['gameScore'], true);
        }
        if (empty($arr))
            return 'error';

        //平均分 冠军分 亚军分 季军分
        if (empty($m)) {
            $score = floor(array_sum($arr) / count($arr));
        } else {
            $score = $arr[$m - 1];
        }

        //toKen
        $token = substr(file_get_contents('http://my.4399.com/flashgame/flashgame_reload_token.php'), 7);
        $miyao = 'ok123';
        $orderId = date("YmdHis") . rand(100000, 999999);
        $link = 'xn';
        //_root.result + "xn" + _root.orderId + _root.miyao  "xn" + _level0.gameId + "xn" + _root.token
        //http://my.4399.com/flashgame.php?ac=score_subm&token=73880937914d7521321497fbf27a189beea76f&Mac=257be7e4641d73e9a94c968f986e7516&orderId=20120204234108456451&result=10&gameId=346
        $md5_token = md5($score . $link . $orderId . $link . $miyao . $link . $id . $link . $token);
        $url = "http://my.4399.com/flashgame.php?ac=score_submit&token={$token}&Mac={$md5_token}&orderId={$orderId}&result={$score}&gameId={$id}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_COOKIE, 'Pauth=403370469|66847612|7082ed77f7c271b74d84de349009452a|1328319929|10002|bbeae2e37479547b7c0d5da25d8eb004|0;');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, TRUE);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, "source=" . Vendor_Sina::appid . "&target_id={$target_id}");
        $file_contents = curl_exec($curl);
        curl_close($curl);
        $out = array();
        if (preg_match('/<div class="score_number"><h3>.*?<\/h3><p>(\d+)<\/p><\/div>/', $file_contents, $out)) {
            if (is_numeric($out[1]))
                return $out[1];
        }
        return 'null';
    }

}