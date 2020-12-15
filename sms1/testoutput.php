<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('include/header.php');
require_once('connect.php');
?>
<?php
                
                
                    $invoice = $mysqli->query("select * from tests on  where tests.testCategoryId in(select categoryId from test_category where is_path = '1') order by tests.testCategoryId asc");
                
                    //$isl = $isl0 + 1;
                    
                    $data = array();
                    while($invoiceRow = $invoice->fetch_array()){
                        
                        $id = $invoiceRow['testCategoryId'];
                        unset($invoiceRow['testCategoryId']);
                        $data[$id][] = $invoiceRow;
                    }
                    $sl = 1;
                    foreach($data as $id => $values) {
                    
                        $getCategory = $mysqli->query("select * from test_category where categoryId = '$id'");

                        if($getCategory->num_rows > 0){
                            $categoryArray = $getCategory->fetch_array();
                            ?>
                            <div class="row">
                                <div class="col-lg-12 category">
                                &nbsp;&nbsp;
                                <?php
                                echo $sl.'. '.$categoryArray['categoryName'];
                                ?>
                                </div>
                            </div>
                            <?php
                            //echo "<ol type='i'>";
                            foreach($values as $field) {
                                //echo $field[2];
                                //$getPath = $mysqli->query("select * from pathology where testId = '$field[2]' order by pathologyId asc");
                                
                                //////////////////////////////////////////////////////////////////////////////////////

                                $getCId = $mysqli->query("select reportContentId from report_content where testId = '$field[2]' order by reportContentId asc");
        
                                $rhpid = '';
                                $rhrid = '';
                                while($array = $getCId->fetch_array()){

                                    $r = $mysqli->query("select * from report where reportContentId = '$array[reportContentId]' order by reportId asc");
                                    ?>
                                    <input type="hidden" name="pageSl[]" value="<?php echo $sl; ?>">
                                    <?php
                                    echo '<table border=0 width="100%"><tr>';
                                    $rid1 = '';
                                    $pid1 = '';
                                    while($rows = $r->fetch_array()){

                                    ?>

                                        <td width="<?php echo $rows['columnWidth'] ?>%" style="padding: 5px 0px;">

                                            <?php
                                            $rhrid = $rows['reportHeaderId'];
                                            $pid2 = $rhrid;;
                                            if($rows['resultName'] <> '' && $rows['resultName'] <> ':'){
                                                //echo $rhrid;
                                                //echo $rhpid;
                                                $rid1 = $rhrid;
                                                $pid1 = $rhpid;
                                                if($rhrid == 0){

                                                }
                                                if($rhrid == $rhpid || $rhrid == 0){

                                                }else{
                                                  $getH = $mysqli->query("select * from report_header where reportHeaderId = '$rhrid'");
                                                  $hArray = $getH->fetch_array();
                                                  echo '<b>',$hArray['reportHeader'],'</b><br/>';
                                                }

                                            }
                                            //echo $rid1;
                                            //echo $pid1;
                                            if($rid1 == $pid1 || ($rows['resultName'] <> '' && $rows['resultName'] <> ':') || $rid1 == 0){
                                                
                                            }else{
                                                echo "<br/>";
                                            }
                                            
                                            if($rows['resultName'] <> ''){
                                                echo $rows['resultName'];
                                            }

                                          ?>
                                          <!--</td>
                                          <td>-->
                                          <?php
                                            if($rows['isInput'] == 1){

                        if($array['reportContentId'] == 85 || $array['reportContentId'] == 86 || $array['reportContentId'] == 87 || $array['reportContentId'] == 88 || $array['reportContentId'] == 89){
                                                ?>
                                                   <textarea name="value[<?php echo $rows['reportContentId']; ?>][<?php echo $rows['reportId']; ?>]" cols="100" rows="2" style="border:1px solid;"><?php echo $rows['defaultValue']; ?></textarea>
                                                <?php
                                                }else{
                                                ?>
                                                    <input type="text" name="value[<?php echo $rows['reportContentId']; ?>][<?php echo $rows['reportId']; ?>]" value="<?php echo $rows['defaultValue']; ?>" style="border:1px solid; width: 100px">
                                                <?php
                                                }                       
                                            } 
                                            if($rows['unit'] <> ''){
                                                echo $rows['unit'];
                                            }

                                            ?>
                                            <!--</td>
                                            <td>-->
                                            <?php
                                            if($rows['rangeValue'] <> ''){
                                                echo $rows['rangeValue'];
                                            }
                                            ?>
                                            </td>
                                        <?php
                                        if($rows['resultName'] <> '' && $rows['resultName'] <> ':'){
                                            $rhpid = $rhrid;
                                        }
                                        
                                    }
                                    echo '</tr></table>';
                                    
                                }
                                
                                /////////////////////////////////////////////////////////////////////////////////////

                            }
                            //echo "</ol>";
                        }
                    $sl++;
                    }
                ?>
<?php
require_once('include/footer.php');
}else{
    header("Location:index.php");   
}
?>