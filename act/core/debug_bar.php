<style>
#bu_debug_bar_block{
    z-index:9998;
    position: absolute;
    top: 0px;
    border: 2px solid black;
    background: white;
    padding: 10px;
    filter:alpha(opacity=70);
    -moz-opacity:0.7;
    -khtml-opacity: 0.7;
    opacity: 0.7;
}

#bu_debug_bar_log_block{
    display:none;
    z-index:9999;
    position: absolute;
    top: 0px;
    border: 2px solid black;
    background: white;
    padding: 10px;
}
#bu_debug_bar_timer_block{
    display:none;
    z-index:9999;
    position: absolute;
    top: 0px;
    border: 2px solid black;
    background: white;
    padding: 10px;
}
.bu_timer_system{
}

.bu_debug_bar_close{
    position: absolute;
    top: 0px;
    left: 0px;
    width: 16px;
    height: 16px;
    display: inline-block;
    background: url(/static/ico/mini/action_stop.gif) no-repeat;
}
.bu_debug_bar_clock{
    width: 16px;
    height: 16px;
    display: inline-block;
    background: url(/static/ico/mini/icon_clock.gif) no-repeat;
}
.bu_debug_bar_log{
    width: 16px;
    height: 16px;
    display: inline-block;
    background: url(/static/ico/mini/page_text.gif) no-repeat;
}
.bu_debug_bar_log_data{
    display: none;
}
.bu_debug_bar_log_time{
    display: none;
}
</style>

<div id='bu_debug_bar_log_block'>
    <?php
    echo buLogger::getLog();
    ?>
    <a href='javascript:$("#bu_debug_bar_log_block").css("display","none")' class='bu_debug_bar_close'></a>
</div>
<div id='bu_debug_bar_timer_block'>
    <?php
        $statistic = BuStatistic::getTimerStatistic();
        $statisticGroups = BuStatistic::getTimerGroups();
        $ft = false;
        $lt = false;
        foreach ($statistic as $k=>$v):
        if(!$ft)
        $ft = $k;
        $lt = $k;
        ?>
        <div class="bu_timer_<?php echo $statisticGroups[$k];?>">
        <b><?php echo sprintf('%.4f',($k-$ft));?> </b>: <?php echo $v;?> 
        </div>
    <?php endforeach;?>
    <a href='javascript:$("#bu_debug_bar_timer_block").css("display","none")' class='bu_debug_bar_close'></a>
</div>
<div id='bu_debug_bar_block'>
            Db Query: <?php echo BuDb::$count_q;?><br>
            Time: <?php echo sprintf('%.4f',($lt-$ft));?> <br>
            Memory: <?php echo floor(memory_get_peak_usage(true)/1024);?> kb.<br>
    <a href='javascript:$("#bu_debug_bar_block").css("display","none")' class='bu_debug_bar_close'></a>
    <a href='javascript:$("#bu_debug_bar_timer_block").css("display","block")' class='bu_debug_bar_clock'></a>
    <a href='javascript:$("#bu_debug_bar_log_block").css("display","block")' class='bu_debug_bar_log'></a>
</div>
