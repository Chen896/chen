<?php
class IndexController extends CommonController
{
    public function indexAction()
    {
        $this->response->lastModified(1252376412);
        $this->response->etag('foobar');
       $this->response->expires(100);
		print_r($_GET);
        echo 'Index@', time();
    }

    public function testAction()
    {
        $this->response->alert('Te"st');
        echo 'Test@', time();
    }

    public function dbAction()
    {
        $model = $this->model('Index');

        var_dump($model->test());
    }

    public function viewAction()
    {
        $id = $this->getVar('id');
        $this->view->id = $id;
        $this->view->name = '伟大领袖毛主席无限正确!';
        $this->response->charset();
        $data=array("aaaaa","dddddddd");
		$this->view->data=$data;

        $p = $this->request->param('p', 1);
        $page = new Cola_Com_Pager($p,20,48, '/index.php/index/view/p/%page%/');
        $this->view->page=$page;

        $this->display();
    }

    public function widgetAction()
    {
        $this->display();
    }

    public function showAction()
    {
        var_dump($this->getvar('c'));
    }

    public function mongoAction()
    {
        $config = array(
            'database' => '_autoIncrementIds'
        );

        $mongo = new Cola_Com_Mongo($config);

        var_dump($mongo->autoIncrementId('uId', '_data'));
    }
    public function pagerAction()
    {
        $p = $this->request->param('p', 1);
        $page = new Cola_Com_Pager($p,20,48, '/index.php/index/pager/p/%page%/');

        $page->display();
    }

    public function encryptAction()
    {
        $encrypt = new Cola_Com_Encrypt();

        //echo $encrypt->encode('fuchaoqun', 'chaoqun'), '<br />';

        $encrypt->config('xor', false);

        //$encrypt->config('noise', false);

        echo $encrypt->encode('QWkJMch92D+SkixmFvDpZW3U', 'SkixmFvDpZW3U'), '<br />';

        echo $encrypt->decode($encrypt->encode('1234567890123456', 'chaoqun'), 'chaoqun');
    }

    public function validateAction()
    {
        $data = array(
            //'uName' => 'chaoqun',
            'uPwd'  => '9527',
            'uNick' => '',
            'uAge'  => 12
        );

        $rules = array(
            'uName' => array('required' => true, 'max' => 16, 'min' => 4),
            'uPwd'  => array('required' => true, 'type' => 'string', 'range' => array(3, 16)),
            'uNick' => array('range' => array(0, 16)),
            'uAge'  => array('type' => 'int', 'range' => array(10,40), 'message' => '年龄范围不符合。')
        );

        $validate = $this->com->validate;

        var_dump($validate->check($data, $rules, true));

        var_dump($validate->error());
    }

    public function httpAction()
    {
        $data = Cola_Com_Http::get('http://www.google.com');

        var_dump(Cola_Com_Http::responseHeader());
    }

    public function captchaAction()
    {
        $this->com->captcha->display();
    }

    public function yamlAction()
    {
        $data = array(
            1 => array('t' => 'txt', 'd' => '<b>foo</b>'),
            2 => array('t' => 'rdo', 'd' => array('菁华 （qīng）    宁可（nìng）   冠心病（guān）  翘首回望（qiáo）', 'Bar', 'FooBar', 'BarFoo')),
            3 => array('t' => 'txt', 'd' => 'bar')
        );
        $yaml = $this->com->yaml->dump($data);
        echo "<pre>$yaml</pre>";
    }

    public function to404Action()
    {
        $this->response->statusCode(404);
        echo 'foobar';
    }

    public function configAction()
    {
        var_dump(Cola::$config->get('_db'));
    }
}
?>
