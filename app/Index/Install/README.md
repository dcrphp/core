lock存在 表示已经安装过

entity里的uniqueConstraints 名字要唯一，因为sqlite会判断所有的key名是不是重复  
所以index命名规则是udx_表名缩写_字段名缩写或idx_表名缩写_字段名缩写  
  
entity可以从app\model\entity下复制过来，然后改下namespace和default值  

其中如果是0:  
options={"default"=0}  

字符串是空值的话，如果是'':  
options={"default"=""}  