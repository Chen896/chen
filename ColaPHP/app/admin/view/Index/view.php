<?php
echo $this->id, '<br />';
echo $this->truncate($this->name, 7), '<br />';
print_r($this->data);
$this->page->display();
?>
下面的内容来自Widget：<br />
<?php $this->widget('foobar', 1234)->assign('foo', '111222', true)->display();?>



<a href="<?=B_APP?>/abc/">aadfa</a>