<?php 
	require_once "header.php";
	echo <<<_end
<div class="welcom">
            <h1>
                您好，$user ！
                <span class="txt-rotate" data-period="2000" data-rotate='[ "工作辛苦了！注意身体！" ]'>
                </span>
            </h1>
        </div>
        <script src="js/welcom.js" type="text/javascript">
        </script>
_end;
?>