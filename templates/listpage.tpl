						<nav class="post-pagination">
                                <ul class="pagination">
                                  <li class="pagination-first">
									<a href="<?php echo $action."?p=1";?>">«</a></li>
                                    
									<?php
                                    for($i=($curpage-2);$i<=$curpage+2;$i++){
                                        if ($i>0 && $i<=$pages){
                                            if ($i!=$curpage){?>    
                                                <li class="pagination-num"><a href="<?php echo $action."&amp;p=".$i; ?>"><?php echo $i;?></a></li>  
                                            <?php }else{?>
                                                <li class="pagination-num" style="padding: .3em .9em; border-bottom: 2px solid #555;"><?php echo $i;
                                            }
                                        }
                                    } ?></li>
                                    <li class="pagination-last">
                                	<a href="<?php echo $action."&amp;p=".$pages; ?>">»</a>
									</li>
                                </ul>
                                </nav>
                                
                         