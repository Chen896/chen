<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../PHPExcel.php';

/**
 * PHPExcel [https://github.com/PHPOffice/PHPExcel]
 * @date 2017-08-01 14:51
 */
class Excel
{
    private $objPHPExcel = null;

    /**
     * [读取Excel表格数据，支持多Sheet]
     * @return [array]
     */
    public static function getExcelData($filename, $sheet=false)
    {
        #读取表格数据【自动识别文件类型】
        $objExcel = PHPExcel_IOFactory::load($filename);
        $sheetData = array();

        #是否多Sheet
        if($sheet === false){
            $sheetData = $objExcel->getSheet(0)->toArray(null, true, true, true);

        }else{
            $num = $objExcel->getSheetCount();

            for($i=0; $i<$num; $i++){
                $sheetData[$i] = $objExcel->getSheet($i)->toArray(null, true, true, true);
            }
        }
        return $sheetData;
    }

    /**
     * [数据保存到Excel表格，支持多Sheet]
     * @param string $filename
     */
    public function save($data, $ext='xls', $name='', $path='')
    {
        # a）Create new PHPExcel object
        if($this->objPHPExcel === null){
            $this->objPHPExcel = new PHPExcel();
        }

        # b）Set document properties
        $this->setDocumentProperties();

        # c）Add data
        if(!isset($data["width"]))  $data["width"]=array();
        if(!isset($data["height"]))  $data["height"]=array();
        if(!isset($data["imgIndex"])) $data["imgIndex"]=array();

        $num = 0;
        foreach($data['title'] as $key=>$title){
            if($num != 0){
                $this->objPHPExcel->createSheet();
            }

            $this->objPHPExcel->setActiveSheetIndex($num);
            $this->objPHPExcel->getActiveSheet()->setTitle($key);

            $this->setCellTitle($title, $data["width"]);
            $this->setCellValue($data["data"][$key], $data["imgIndex"], $data["height"]);

            $num++;
        }

        # d）Set active sheet index to the first sheet
        $this->objPHPExcel->setActiveSheetIndex(0);

        # e）
        if(empty($name)) $name = date('YmdHis').rand(100, 999);
        if($ext != 'xls') $ext = 'xlsx';

        $type = $ext=='xls' ? 'Excel5' : 'Excel2007';
        $filename = $name.'.'.$ext;

        # f）
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $type);
        $newFilename = iconv('utf-8','gbk',$filename);

        if(empty($path)){
            # download
            $this->downloadExcel($newFilename, $objWriter);
        }

        $objWriter->save($path.$newFilename);
        return $path.$filename;
    }

    #1.设置单元格Title
    private function setCellTitle($title, $width)
    {
        $i=1;
        foreach($title as $v){
            $name=$this->getCellName($i);
            $k=$i-1;

            $objColumn = $this->objPHPExcel->getActiveSheet()->getColumnDimension($name);
            if(isset($width[$k]) && $width[$k]){
                $objColumn->setWidth($width[$k]);
            }else{
                $objColumn->setAutoSize(true);
            }

            $this->objPHPExcel->getActiveSheet()->setCellValue($name.'1', $v);
            $i++;
        }
        return true;
    }

    #2.设置单元格的值
    private function setCellValue($content, $imgIndex, $height)
    {
        $row=2;
        foreach($content as $val){
            $i=1;
            foreach($val as $v){
                $name=$this->getCellName($i).$row;
                $k=$i-1;

                # 1.指定图片在第几列
                if(isset($imgIndex[$k]) && $imgIndex[$k]==1){
                    if(file_exists($v)){
                        $this->setCellImage($name, $v);

                        $objRow = $this->objPHPExcel->getActiveSheet()->getRowDimension($row);
                        if(isset($height[$k]) && $height[$k]){
                            $objRow->setRowHeight($height[$k]);
                        }else{
                            $objRow->setRowHeight(60);
                        }
                    }
                # 2.文本内容
                }else{
                    $this->objPHPExcel->getActiveSheet()->setCellValue($name, $v,PHPExcel_Cell_DataType::TYPE_STRING);
                }
                $i++;
            }
            $row++;
        }
        return true;
    }

    #3.设置文档属性
    private function setDocumentProperties()
    {
        $this->objPHPExcel->getProperties()
                ->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        return $this;
    }

    #4.获取单元格名
    private function getCellName($i)
    {
        $code = null;
        while($i){
            $i = $i-1;
            $n = $i%26+1;

            $code = chr($n+64).$code;  #返回对应的字母
            $i = floor($i/26);         #舍去法取整
        }
        return $code;
    }

    #5.设置单元格图片
    private function setCellImage($cell, $img)
    {
        $objDrawing = new PHPExcel_Worksheet_Drawing();

        $objDrawing->setName('img');
        $objDrawing->setDescription('img');
        $objDrawing->setPath($img);
        $objDrawing->setHeight(60);
        $objDrawing->setCoordinates($cell);
        $objDrawing->setOffsetX(10);
        $objDrawing->setOffsetY(10);
        $objDrawing->setRotation(0);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(36);
        $objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());

        return $this;
    }

    #6.直接下载表格文件
    private function downloadExcel($filename, $objWriter)
    {
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");

        $objWriter->save('php://output');
        exit;
    }



}

// $data = Excel::getExcelData('C:\Users\chineon\Downloads\Format_GAOPOST0421.xlsx.xls');
// var_dump($data);

 #标题
$title1 = array('产品SKU','产品主图','产品名称','产品英文名称','产品品类（代码）','重量','长','宽','高','海关申报代码','英文申报品名','中文申报品名','申报价值','申报币种','采购价','采购币种','默认供应商代码','销售价格','销售运费','建立原因','供应商产品地址','供应商品号','款式代码','成品','运营方式','贴标容易度','产品销售状态','销售负责人','开发负责人','自定义分类','是否需要质检','组织机构（代码）','申报说明','是否包含电池','是否为仿制品','样品数量');  #产品

$title2 = array('产品SKU','图片URL','是否主图(Y/N)');   #产品图片
$title3 = array('产品SKU','包材代码','包材数量','仓库代码');   #产品包材

$dataList = array(
    "title"=>array('产品'=>$title1, '产品图片'=>$title2, '产品包材'=>$title3),
    "imgIndex"=>array(0, 1),  #第二列生成图片
    "width"=>array(0),
    "height"=>array(0)
);

$temp1 = array(array('A'=>'111', 'B'=>'./Tulips.jpg'));
$temp2 = array(array('A'=>'222', 'B'=>'D:/www/Chen/php_demo/PHPExcel-1.8/Demo20170801/Tulips.jpg'));
$temp3 = array(array('A'=>'333'));


$dataList["data"] = array('产品'=>$temp1, '产品图片'=>$temp2, '产品包材'=>$temp3);
$obj = new Excel();
$obj->save($dataList);