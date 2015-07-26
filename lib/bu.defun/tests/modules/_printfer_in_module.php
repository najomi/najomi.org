<?php
// Проверяем что не только def работает при определении функций внутри модуля
def_printfer("html::body", "<body></body>");
html::body();
---
<body></body>
