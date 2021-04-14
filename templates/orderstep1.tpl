<fieldset id="os1">
    <legend class="orderstepname">
        <h2>Оформление заказа:
            <span id="nameandauthorleg">название и автор</span>
            <span id="resblockleg" style="display: none;">загрузка текста</span></h2>
        </h2>
    </legend>
    <form method="post" action="editus.php?do=orderstep2" style="margin: 0;">
        <div id="authorname">
            <p class="input-wrap">
                <label for="os1_name">Название книги:</label>
                <input id="os1_name" type="text" name="book-name" placeholder="<?php echo $this->xss(_OS1_PROJECTSUFF . $orderid); ?> "/>
                <span class="error-empty error-bookname">Введите название книги</span>
            </p>
            <p class="input-wrap">
                <label for="os1_author">Автор:</label>
                <input id="os1_author" type="text" name="book-author" placeholder="<?php echo $this->xss($author); ?> "/>
                <span class="error-empty error-author">Введите имя автора</span>
            </p>
            <div>
                <input type="button" class="button red" id="toresultblock" value="Далее" />
            </div>
        </div>

        <div id="resultblock" style="display: none;" >
            <p>
                Поддерживаемый формат - PDF.<br>
                Загружая PDF-файл, проверьте настройки: <strong>PDF/X-1a:2001 гарантирует качественную печать и отсутствие ошибок</strong>
                <a class="head" href="new/pdf.html" target="_blank">(требования к PDF)</a>. 
            </p>
            <!-- .entry-content -->
            <div class="entry-content">
                <p>
                <a href="template.php" class="more-link" target="_blank">Как подготовить макет книги самостоятельно?<span class="meta-nav"> →</span></a>
                </p>
            </div>
            <!-- .entry-content -->
            <div>
                <div>
                    <div class="flex">
                        <input type="button" class="button red" id="uploadblock" value="Загрузить блок" />
                        <p id="load-error"></p>
                    </div>
                    <input type="file" id="uploadblock_file" accept=".pdf" style="display: none;" />
                </div>
            </div>
            <span style="display: none; cursor:pointer;" id="uploadblock_after">Загрузить повторно</span>
            
            <!-- LOADING -->
            <section class="loading-block" style="display: none;">
                <div class="loadingio-spinner-rolling-ukqrsssj2un">
                    <div class="ldio-8024eleltpf">
                        <div></div>
                    </div>
                </div>
                <p class="loading-text">Файл загружен. Идет проверка...</p>
            </section>
            

            <p id="messerror" style="display: none;"></p>

            <table id="pdf-info" style="display: none;">
                <tr>
                    <td>Размер книги: </td>
                    <td style="padding-left:10px;" id="os1_booksize"></td>
                </tr>
                <tr>
                    <td>Количество страниц: </td>
                    <td style="padding-left:10px;" id="os1_pagenumber"></td>
                </tr>
            </table>
            <!-- <div > -->
                <!-- <a href="/book-parameters.php"> -->
                    <input id="book-parameters-btn" type="submit" class="button red" value="Выбрать параметры книги" style="display: none;"/>
                <!-- </a> -->
            <!-- </div> -->
        </div>
        <input type="text" hidden name="book-size">
        <input type="text" hidden name="book-width">
        <input type="text" hidden name="book-height">
        <input type="text" hidden name="page-count">
    </form>
</fieldset>
<!-- <input id="os1_author" type="text" name="os1_author" placeholder="<?php echo $this->xss($author); ?> "  onfocus="this.value='';"/> -->