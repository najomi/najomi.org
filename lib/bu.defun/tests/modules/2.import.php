<?php
// С помощью import возможно загрузить функции в глобальное пространство.
def("foo::one", function(){echo 1;});
def("foo::two", function(){echo 2;});
def("foo::three", function(){echo 3;});
foo::one();
foo::two();
foo::three();
echo "\n";
import("foo");
one();
two();
three();
---
123
123
