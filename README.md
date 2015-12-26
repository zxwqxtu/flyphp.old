## 界面输出字符编码 ##
config.php设置charset=UTF-8

# 控制器 #
## 模板 ##
1. 默认为views/{controller}/{action}.php
2. $this->view='test/index',则表示views/test/index.php

## layout布局 ##
$this->layout='index',则表示layout/index.php

## theme主题 ##
$this->theme = 'new',则表示layout/new/index.php

