<?php
// При установке нового значения - функция вернёт старое
def_accessor('user', 'waserd');
echo user('bubujka')."\n";
echo user();
---
waserd
bubujka
