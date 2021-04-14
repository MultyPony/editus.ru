    <!-- <fieldset id="os3"> -->
    <!-- <legend class="orderstepname"> -->
    <!-- <h2>Оформление заказа: дизайн обложки</h2> -->
    <h2>Дизайн обложки</h2>
    <!-- </legend> -->
    <form method="post" action="editus.php?do=orderstep4">
        <div class="entry-content">
            <label>
                <input type="radio" name="cover-option" id="" value="load" checked>
                Загрузить свою обложку
            </label>
            <label>
                <input type="radio" name="cover-option" id="" value="editor">
                Редактор обложки
            </label>
            <p>
                Скачайте шаблон обложки с рассчитанными под Ваш заказ размерами, подготовьте макет согласно нашим рекомендациям и загрузите Ваш готовый файл обложки.
                <a class="more-link" target="_blank" href="new/cover.html"> Как подготовить макет обложки самостоятельно?
                    <span class="meta-nav">→</span>
                </a>
            </p>
            <div class="alert info" id="templatecover">
                Загружаемое изображение должно быть в
                <span style="font-weight: bold;">формате PDF с разрешением не менее 300 dpi</span></br>
            </div>

            <div>

                <div>
                    <div>
                        <div class="flex">
                            <input type="button" class="button red" id="uploadblock" value="Загрузить обложку" />
                            <p id="load-error"></p>
                        </div>
                        <input type="file" id="uploadblock_file" accept=".pdf" style="display: none;" />
                    </div>
                </div>


                <!-- LOADING -->
                <section class="loading-block" style="display: none;">
                    <div class="loadingio-spinner-rolling-ukqrsssj2un">
                        <div class="ldio-8024eleltpf">
                            <div></div>
                        </div>
                    </div>
                    <p class="loading-text">Файл загружен. Идет проверка...</p>
                </section>
                
                <!-- <p id="mess" style="">Изображение не соответствует размерам шаблона</p> -->
            </div>
            <div id="coverlayout" style="display: none;">
                <table>
                    <tbody>
                        <tr>
                            <td>Загруженный файл обложки:</td>
                            <td><a href="/include/get.php?uid=10857&amp;oid=149021&amp;o=cover">скачать</a></td>
                        </tr>
                        <tr>
                            <td>Готовый к печати макет PDF:</td>
                            <td>
                                <a href="/include/get.php?uid=10857&amp;oid=149021&amp;o=coverlayot" target="_blank">скачать</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="alert">
                    Для просмотра макета необходимо установить <a target="_blank" href="//get.adobe.com/reader/">Adobe Acrobat Reader</a>&nbsp;<a target="_blank" href="//get.adobe.com/reader/"><img style="height:25px; vertical-align: bottom;" src="img/get_adobe_reader.gif" alt="Adobe Reader"></a>
                </div>
            </div>
            <div>
                <input type="hidden" value="<?php echo $orderid; ?>" name="orderid" id="orderid">
                <input type="hidden" value="1" name="os2_newo">
                <input type="hidden" value="149021" name="os2_orderid" id="os2_orderid">
                <input type="hidden" value="10857" name="os2_userid" id="os2_userid">

                <p id="os2_agreement" style="display: none;"><input type="checkbox" name="agreement" id="os2_agreement_ch"> Я утверждаю готовый макет PDF к печати</p>

                <input type="submit" style="display: none;" class="button red" id="tonextstep" value="Перейти к доставке и оплате">
            </div>
            <input style="display: none" type="submit" class="button red" id="" value="Проверить макеты">
        </div> <!-- entry-content -->
    </form>
    <!-- </fieldset> -->