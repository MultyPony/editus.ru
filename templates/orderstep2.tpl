    <form name="order" method="post" action="editus.php?do=orderstep3">
        <div class="entry-content" id="block">
            <h2>Выберите параметры книги</h2>
            <h3>Цветность блока</h3>

            <!-- Цвет -->
            <table width="100%">
                <tr align="center">
                    <td>
                        <label for="bblackp">
                            <img src="/img/black.jpg" title="Черно-белая печать" alt="Черно-белая печать"><br>Черно-белая
                            печать
                        </label>
                        <input id="bblackp" type="radio" name="colorblock" value="black" />
                    </td>
                    <td>
                        <label for="bcolorp">
                            <img src="../img/color.jpg" title="Цветная печать" alt="Цветная печать"><br>Цветная печать
                        </label>
                        <input id="bcolorp" type="radio" name="colorblock" value="color" />
                    </td>
                </tr>
            </table>

            <!-- Тип бумаги -->
            <div id="paperTypeBlock" style="display: none;"></div>


            <!-- Крепление (нов) -->
            <div id="binding" class="entry-content">
                <h3>Выберите переплет книги</h3>
                <div class="binding-wrap">
                    <div class="">
                        <!-- span7 -->
                        <table width="100%">
                            <tr align="center">
                                <th colspan="3">Мягкая обложка</th>
                            </tr>
                            <tr id="binding-soft" align="center">
                                <!-- Вставл сюда -->
                            </tr>
                            <!-- <tr align="center">
                                <td colspan="3" style="border:none;"><br />
                                </td>
                            </tr> -->
                        </table>
                    </div>
                    <div class="">
                        <!-- span5 -->
                        <table width="100%">
                            <tr align="center">
                                <th colspan="2">Твердая обложка</th>
                            </tr>
                            <tr id="binding-hard" align="center">
                                <!-- Вставл сюда -->
                            </tr>
                            <!-- <tr align="center">
                                <td colspan="2" style="border:none;"><br />
                                </td>
                            </tr> -->
                        </table>
                    </div>
                </div>
                <p><a class="more-link" href="new/pereplet.html" target="_blank">Какой переплет выбрать?</a></p>
            </div>

            <!-- Ламинация -->
            <div class="lamination-wrap" style="display: none;">
                <h3 class="lamination__title">Ламинация</h3>
                <label class="lamination__label">
                    <input class="lamination__input" type="radio" name="lamination" value="matte">Матовая
                </label>
                <label class="lamination__label">
                    <input class="lamination__input" type="radio" name="lamination" value="glossy">Глянцевая
                </label>
            </div>

            <!-- Тираж -->
            <div id="count" style="display: none;">
                <h3>Объем</h3>
                <table width="100%">
                    <tr>
                        <td>Тираж*:</td>
                        <td><input id="softcount" type="text" name="count" size="6" maxlength="3" value="1" />
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Дополнительные услуги -->
            <section id="additional-services" style="display: none;">
                <h2>Дополнительные услуги</h2>
                <table id="isbn">
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" id="10" name="10" value="2000">
                                <label>
                                    <input type="checkbox" name="isbn" value="10"> Издательский пакет (ISBN, номера УДК, ББК, авторский знак, 16 обязательных экземпляров книги в РКП (Федеральный Закон "Об обязательном экземпляре документов") ( <a href="http://www.bookchamber.ru/oe.html" target="_blank">?</a> )
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div id="delivery" class="validate-form">
                    <h5>Тип доставки</h5>
                    <label class="inline-label">
                        <input type="radio" name="typedeliv" value="pickup" /> Самовывоз
                    </label>
                    <label class="inline-label">
                        <input type="radio" name="typedeliv" value="deliver" /> Доставка
                    </label>
                    <label class="inline-label cdek-label">
                        <input type="radio" name="typedeliv" value="pickup-point" onclick='window.cartWidjet.open()' /> Пункт самовывоза
                    </label>
                </div>

                <!-- Поля для СДЭК -->
                <div id="pvz_cdek" style="display: none;">
                    <div>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="text-align: right; width:35%">
                                        <span id="show_pvz_address">Адрес ПВЗ:</span>
                                    </td>
                                    <td style="text-align: left; vertical-align: middle;">
                                        <input id="os3_pvz_address" type="text" name="os3_pvz_address" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; width:35%">
                                        <span id="show_delivery_price">Стоимость доставки:</span>
                                    </td>
                                    <td style="text-align: left; vertical-align: middle;">
                                        <input id="os3_delivery_price" type="text" readonly>
                                        <input id="hidden_del_price" type="hidden" value="0" name="os3_delivery_price" />
                                        <input id="hidden_del_citytoid" type="hidden" value="0" name="os3_delivery_citytoid" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="deliveryaddress" style="display: none;">
                    <div>
                        <table width="100%">
                            <tr>
                                <td style="text-align: right; width:35%">
                                    <span id="selectaddress"><?php echo _OS3_SELECTADDRESS; ?></span>
                                    <span id="selectaddressbill" style="display: none;"><?php echo _OS3_SELECTADDRESSBILL; ?></span>
                                </td>
                                <td style="text-align: left; vertical-align: middle;">
                                    <select id="os3_addresses_sel" name="os3_addreses">
                                        <?php
                                        foreach ($addreses as $cur) {
                                            if ($cur['addressId'] == $data2['11']) {
                                                $sel = 'selected="selected"';
                                            }
                                        ?><option <?php echo $sel;
                                                        $sel = ''; ?> value="<?php echo $cur['addressId'] ?>"><?php echo $this->xss($cur['addressIndex'] . ', ' . $cur['addressCity'] . ', ' . $cur['addressStr'] . ', ' . $cur['addressHouse'] . ', ' . $cur['addressApt']); ?></option><?php
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                        ?><option value="new"><?php echo _OS3_ADDADDRESE; ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="newaddress" style="display: none;">
                        <table width="100%">
                            <tr>
                                <td style="text-align: right; width:35%;"><label for="os30"><?php echo _OS3_ADDRESSCONTACT; ?></label></td>
                                <td><input id="os30" type="text" name="os3_addresscontact" value="<?php
                                                                                                    if (!empty($data2['0'])) {
                                                                                                        echo $this->xss($data2['0']);
                                                                                                    } else {
                                                                                                        echo $this->xss($data['0']);
                                                                                                    }
                                                                                                    ?>" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os31"><?php echo _OS3_ADDRESSTELEPHONE; ?></label></td>
                                <td><input id="os31" type="text" name="os3_addresstelephone" value="<?php
                                                                                                    if (!empty($data2['1'])) {
                                                                                                        echo $this->xss($data2['1']);
                                                                                                    } else {
                                                                                                        echo $this->xss($data['4']);
                                                                                                    }
                                                                                                    ?>" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os3_country_sel"><?php echo _OS3_ADDRESSCOUNTRY; ?></label></td>
                                <td>
                                    <select id="os3_country_sel" name="os3_country">
                                        <?php foreach ($countrys as $cur) {
                                        ?><option value="<?php echo $cur['CountryId'] ?>"><?php echo $cur['CountryName']; ?></option><?php
                                                                                                                                    }
                                                                                                                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os3_region_sel"><?php echo _OS3_ADDRESSREGION; ?></label></td>
                                <td>
                                    <select id="os3_region_sel" name="os3_region">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os34"><?php echo _OS3_ADDRESSINDEX; ?></label></td>
                                <td><input id="os34" type="text" name="os3_addressindex" value="" /></td>
                            </tr>
                            <tr id="os35_tr">
                                <td style="text-align: right;"><label for="os35"><?php echo _OS3_ADDRESSCITY; ?></label></td>
                                <td><input id="os35" type="text" name="os3_addresscity" value="" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os36"><?php echo _OS3_ADDRESSSTR; ?></label></td>
                                <td><input id="os36" type="text" name="os3_addressstr" value="" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os37"><?php echo _OS3_ADDRESSHOUSE; ?></label></td>
                                <td><input id="os37" type="text" name="os3_addresshouse" value="" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os38"><?php echo _OS3_ADDRESSBUILD; ?></label></td>
                                <td><input id="os38" type="text" name="os3_addressbuild" value="" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os39"><?php echo _OS3_ADDRESSAPT; ?></label></td>
                                <td><input id="os39" type="text" name="os3_addressapt" value="" /></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><label for="os341"><?php echo _OS3_ADDRESSCOMMENT; ?></label></td>
                                <td><textarea id="os341" rows="15" cols="20" name="os3_addresscomment" style="height: 37px;"></textarea></td>
                            </tr>
                        </table>
                        <br>
                        <input type="button" class="button" id="saveandselnewaddress" value="<?php echo _OS3_SAVEANDSEL; ?>" />
                    </div>
                </div>

                <div id="deliveryfirm" style="display: none;">
                    <div id="providers" style="display: none;">
                        <table width="100%">
                            <tr>
                                <td style="text-align: right; width:35%;"><?php echo _OS3_SELPROVIDERS; ?></td>
                                <td>
                                    <select id="os3_providers_sel" name="os3_providers">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </section>

            <!-- <input type="button" id="topapercover" class="button" value="Назад" /> -->
            <input id="toadd" type="button" class="button red" value="Далее" />
        </div> <!-- id="block" -->

        <div class="entry-content" id="add" style="display: none;">
            <div id="total">
                <!-- START OF TOTAL -->                                                                                                                    
                <table width="100%">
                    <tr>
                        <td colspan="2">
                            <h3 class="typeofcover"></h3>
                        </td>
                    </tr>
                    <tr>
                        <td><img class="bind_img" src="" border="0"></td>
                        <td>Размер: <b><?php echo $format_name;?></b> <?php echo $format_size_text;?><br>
                            Крепление: <span class="bind_name"></span><br>
                            <!-- Обложка цветная с матовой ламинацией<br> -->
                            Обложка цветная с <span class="lamination_type"></span> ламинацией<br>
                            Блок: <span class="pr_printtypeblock_name"></span>, <span class="pr_papertypeblock_name"></span>, <?php echo $pages; ?> стр.<br>
                            Тираж: <b><span class="count"></span> экз. </b><br>
                            <div class="pur_kley_message"></div>
                        </td>
                    </tr>
                </table>

                
                    <h2>Итого: <span class="label" id="vpr"><span class="total"></span></span> руб.</h2>Ориентировочная дата готовности: <span class="date-of-readiness"></span><br><br>
               
                    <table>
                        <tr>
                            <td>Стоимость печати тиража: </td>
                            <td><span class="total"></span> руб.</td>
                        </tr>
                        <tr>
                            <td>Стоимость доставки: </td>
                            <td><span class="delivcost"></span> руб.</td>
                        </tr>
                    </table>
                    <h2>Итого: <span class="label" id="vpr"><?php echo $total + $delivcost; ?></span> руб.</h2>Ориентировочная дата готовности: <span class="date-of-readiness"></span><br><br>
              

                <div class="alert">
                    <strong> ВНИМАНИЕ: </strong>Стоимость указана за услуги печати с <strong>готовых</strong> оригинал-макетов. Выполните верстку <a href="new/verstka.html" target="_blank">самостоятельно</a> или <strong>закажите подготовку макета</strong> и получите <span class="label">Издательский пакет бесплатно! </span> <a href="offer.php">Подробнее >></a>
                </div>

                <input type="hidden" name="totalor" id="totslpriceor" value="" />
                <input type="hidden" name="total" id="totslprice" value="" />
                <!-- END OF TOTAL -->
            </div>
            <input type="hidden" name="cover" value="" />
            <input type="button" id="topaperblock" class="button" value="Пересчитать" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button red" value="Перейти к дизайну обложки" />
        </div>

        <input type="text" hidden name="book-width" value="<?php echo $_SESSION['book_width'] ?>">
        <input type="text" hidden name="book-height" value="<?php echo $_SESSION['book_height'] ?>">
        <input type="text" hidden name="volume" value="<?php echo $_SESSION['pages'] ?>">
        <input type="text" hidden name="size" value="<?php echo $_SESSION['book_format_id'] ?>">
        <input type="text" hidden name="orderid" value="<?php echo $orderid; ?>">
    </form>

    <script type="text/javascript">
        window.cartWidjet = new ISDEKWidjet({
            defaultCity: 'auto',
            cityFrom: 'Москва',
            hidedelt: true,
            popup: true,
            onChoose: function(wat) {
                window.pvz = wat;
                window.showPvzFields();

            },
        });
    </script>