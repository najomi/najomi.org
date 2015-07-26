<?php
// Второй аргумент в функции - значение по умолчанию. 
def_accessor('user', 'waserd');
echo user()."\n";
user('bubujka');
echo user();
---
waserd
bubujka
