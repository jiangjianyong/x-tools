> 在excel中如果在一个默认的格中输入或复制超长数字字符串，它会显示为科学计算法，例如身份证号码，解决方法是把表格设置文本格式或在输入前加一个单引号。
使用PHPExcel来生成excel，也会遇到同样的问题，解决方法有三种：
### 1、设置单元格为文本

```
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Simple');
//设置A3单元格为文本
$objPHPExcel->getActiveSheet()->getStyle('A3')->getNumberFormat()
        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//也可以设置整行或整列的style
/*
//E 列为文本
$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()
        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//第三行为文本
$objPHPExcel->getActiveSheet()->getStyle('3')->getNumberFormat()
        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
*/
```

> 更多的格式可以在PHPExcel/Style/NumberFormat.php中找到。注意：上述的设置对长数字字符串还是以文本方式来显示科学计数法的结果，原因可能php在处理大数字时采用的科学计数法。

### 2、在设置值的时候显示的指定数据类型

```
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Simple');
 
$objPHPExcel->getActiveSheet()->setCellValueExplicit('D1',
                                 123456789033,
                                 PHPExcel_Cell_DataType::TYPE_STRING);
 ```
 
### 3、在数字字符串前加一个空格使之成为字符串

```
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Simple');
 
$objPHPExcel->getActiveSheet()->setCellValue('D1', ' ' . 123456789033);
```

> 推荐使用第二、三种，第一种没有根本解决问题。
 
