<?php
//listallorders
define('_LAO_ORDERIDADMIN','Номер');
define('_LAO_ORDERNAMEADMIN','Название Книги');
define('_LAO_ORDERAUTHORADMIN','Автор Книги');
define('_LAO_ORDERCOUNTADMIN','Тираж');
define('_LAO_ORDERLISTSADMIN','Полос');
define('_LAO_ORDERCHARSADMIN','Кол-во символов');
define('_LAO_ORDERPRICEADMIN','Цена блока');
define('_LAO_ORDERPRICEADDADMIN','Цена Доп. Услуг');
define('_LAO_APPLYY','Применить');
define('_LAO_ORDERID','Номер заказа');
define('_LAO_ALLORDER','Все');
define('_LAO_NOTCOMPL','Недооформленные');
define('_LAO_NOTCOMPCOVER','Недооформлен (загрузка обложки)');
define('_LAO_NOTCOMPDELIV','Недооформлен (выбор доставки)');
define('_LAO_USERMAIL','Email');
define('_LAO_ORDERSTATE','Статус');
define('_LAO_ORDERDATE','Дата');
define('_LAO_ORDERCOUNT','Тираж(от,до)');
define('_LAO_FILTER','Фильтр');
define('_LAO_ORDERPRICE','Цена(от,до)');
define('_LAO_CHANGESTATUS','изменить статус');
define('_LAO_USERORDER', 'Email:');
//vieworderadmin
define('_VOA_OREDERNAME', 'Название:');
define('_VOA_ORDERNUMBLEG', 'Заказ №: ');
define('_VOA_AUTHOR', 'Автор:');
define('_VOA_COUNT', 'Тираж:');
define('_VOA_PAGES', 'Страниц:');
define('_VOA_SYMB', 'Символов:');
define('_VOA_SOFTCOVER', 'Мягкая');
define('_VOA_HARDCOVER', 'Твердая');
define('_VOA_COVER', 'Обложка:');
define('_VOA_FORMAT', 'Формат бумаги:');
define('_VOA_PAPERTYPE', 'Тип бумаги:');
define('_VOA_BIND', 'Крепление:');
define('_VOA_ADDSERVICE', 'Дополнительные услуги:');
define('_VOA_BLOCKPRICE', 'Цена за все блоки:');
define('_VOA_RUB','руб.');
define('_VOA_ADDSERVPRICE', 'Цена за дополнительные услуги:');
define('_VOA_COVERPRICE', 'Цена за все обложки:');
define('_VOA_BINDPRICE', 'Цена за все крепления:');
define('_VOA_COLOR', 'Тип печати:');
define('_VOA_TYPEDELIVER', 'Тип доставки:');
define('_VOA_PICKUP', 'Самовывоз');
define('_VOA_PROVIDER', 'Фирма доставки:');
define('_VOA_ADDRESS', 'Адрес доставки:');
define('_VOA_CT', 'г. ');
define('_VOA_STR', 'ул. ');
define('_VOA_H', 'д. ');
define('_VOA_APT', 'кв./оф. ');
define('_VOA_B', 'стр. ');
define('_VOA_DELIVPRICE', 'Стоимость доставки:');
define('_VOA_TOTAL', 'Стоимость заказа:');
define('_VOA_CONTIN', 'Продолжить оформление');
define('_VOA_DBLOCK','Скачать блок');
define('_VOA_DBLOCKPDF','Скачать PDF блока');
define('_VOA_DCOVER','Скачать обложку');
define('_VOA_DCOVERPDF','Скачать PDF обложки');

//ordersforpay
define('_OFP_PAY', 'Оплата');
define('_OFP_NUM', 'Номер');
define('_OFP_PRICE', 'Сумма');
define('_OFP_STATUS', 'Статус');
define('_OFP_ACTION', 'Действие');
define('_OFP_CONF', 'Подтвердить оплату');
define('_OFP_RUB', 'руб.');
define('_OFP_DATE', 'Дата');
define('_OFP_EMAIL', 'EMail');

//ordersformod
define('_OFM_TITLE', 'Модерация');
define('_OFM_NUM', 'Номер');
define('_OFM_AUTHOR', 'Автор');
define('_OFM_COUNT', 'Тираж');
define('_OFM_NAME', 'Название книги');
define('_OFM_PAGES', 'Страниц');
define('_OFM_ACTION', 'Действие');
define('_OFM_EMAIL', 'Email');
define('_OFM_GETDOC','Скачать doc(x)');
define('_OFM_GETPDF','Скачать PDF блока');
define('_OFM_GETCOVER', 'Скачать обложку');
define('_OFM_GETPDFC','Скачать PDF обложки');
define('_OFM_REASON','Причина отказа');
define('_OFM_SEND', 'отправить');
define('_OFM_NEXT','Прошел модерацию');
define('_OFM_NEXTEDIT','Отправить на ручную верстку');
define('_OFM_DENY','Отклонить');

//ordersformanualedit
define('_OFME_TITLE', 'Ручнная верстка');
define('_OFME_NUM', 'Номер');
define('_OFME_AUTHOR', 'Автор');
define('_OFME_COUNT', 'Тираж');
define('_OFME_NAME', 'Название книги');
define('_OFME_PAGES', 'Страниц');
define('_OFME_ACTION', 'Действие');
define('_OFME_EMAIL', 'Email');
define('_OFME_GETDOC','Скачать doc(x)');
define('_OFME_GETPDF','Скачать PDF блока');
define('_OFME_GETCOVER', 'Скачать обложку');
define('_OFME_GETPDFC','Скачать PDF обложки');
define('_OFME_REASON','Причина отказа');
define('_OFME_SEND', 'отправить');
define('_OFME_REPLACEBLOCKPDF','Загрузить/заменить PDF блока');
define('_OFME_REPLACECOVERPDF','Загрузить/заменить PDF обложки');
define('_OFME_GETCOVERDESIGN', 'Скачать изображение для обложки');
define('_OFME_FILEREPLACED',' Файл загружен/заменен');
define('_OFME_NEXT','Отправить в типографию');

//editstatus
define('_ES_FULLDELETE','Полное удаление заказа');
define('_ES_DELETE','Удалить');
define('_ES_CONFDELETE','Вы уверены что хотите удалить?');
define('_ES_NOTCOMPCOVER','Недооформлен (загрузка обложки)');
define('_ES_NOTCOMPDELIV','Недооформлен (выбор доставки)');
define('_ES_NOTCOMPPAY','Недооформлен (выбор оплаты)');
define('_ES_COMPL','Оформлен');
define('_ES_TITLE','Редактирование статуса');
define('_ES_NAME','Название');
define('_ES_CURSTATE','Состояние');
define('_ES_ACTION','Действие');
define('_ES_APPLY', 'Применить');
define('_ES_STATUS','Статус');
define('_ES_STEP','Шаг оформления');
define('_ES_NOTSET','Не задан');

//editisbn
define('_EISBN_TITLE','Управление ISBN');
define('_EISBN_FREENUM','Свободные номера');
define('_EISBN_USEDNOTPAYNUM','Занятные, не оплаченные номера');
define('_EISBN_USEDNUM','Занятные и оплаченные номера');
define('_EISBN_NUM','Номер ISBN');
define('_EISBN_ADDDATE','Дата добавления');
define('_EISBN_DEL','Удалить');
define('_EISBN_ADD','Добавить');
define('_EISBN_ORDERID','Номер заказа');
define('_EISBN_FREEZEDATE','Дата присвоения');
define('_EISBN_GETFREE','Освободить');
define('_EISBN_ITSPAY','Оплачен');

//ordersmakeup
define('_OMU_TITLE','Отделка');
define('_OMU_GETDATAORDER','Получить из печати');
define('_OMU_ORDERINFO','Информация о заказе');
define('_OMU_LISTORDERS','Список заказов');
define('_OMU_AUTHOR', 'Автор:');
define('_OMU_COUNT', 'Тираж:');
define('_OMU_PAGES', 'Страниц:');
define('_OMU_SYMB', 'Символов:');
define('_OMU_SOFTCOVER', 'Мягкая');
define('_OMU_HARDCOVER', 'Твердая');
define('_OMU_COVER', 'Обложка:');
define('_OMU_FORMAT', 'Формат бумаги:');
define('_OMU_PAPERTYPE', 'Тип бумаги:');
define('_OMU_BIND', 'Крепление:');
define('_OMU_ADDSERVICE', 'Дополнительные услуги:');
define('_OMU_VIEW','Просмотреть');
define('_OMU_OREDERNAME', 'Название:');
define('_OMU_COLOR', 'Цветность');
define('_OMU_CHANGESTATUS','Заказ изменил статус с "Печать" на "Отделка"');

//ordersdelivery
define('_OD_CREATEDELIVER','Формирование отправки');
define('_OD_TITLE','Доставка');
define('_OD_GETDATAORDER','Получить из отделки');
define('_OD_CHANGESTATUS1','Заказ изменил статус с "Отделка" на "На отправке"');
define('_OD_CHANGESTATUS2','Заказ изменил статус с "На отправке" на "Отправлен"');
define('_OD_DISPATCH','Отправлен');
define('_OD_DISPATCHT','Отправка');
define('_OD_PICKUP','Самовывоз');
define('_OD_ORDERNUM','Заказ №');
define('_OD_CT', 'г. ');
define('_OD_STR', 'ул. ');
define('_OD_H', 'д. ');
define('_OD_APT', 'кв./оф. ');
define('_OD_B', 'стр. ');

//zayavkaprint
define('_ZP_TITLE','Заявки на печать');
define('_ZP_NUMl','Номер');
define('_ZP_LINK','Ссылка');
define('_ZP_DOWNLOAD','Скачать');
//orderswaitupload
define('_OWU_TITLE','Отправка в типографию');
define('_OWU_NUM','Номер');
define('_OWU_DATE','Дата создания');
define('_OWU_UPLOAD','Выполнить загрузку сейчас');
//orderstatechanges
define('_OSC_TITLE','Изменение статуса');
define('_OSC_NUM','Номер');
define('_OSC_STATE','Статус');
define('_OSC_USER','Пользователь');
define('_OSC_DATE','Дата');
define('_OSC_NEWPROJ','Новый проект');
define('_OSC_NEWCOVER','Перешел в заказ, загрузка обложки');
define('_OSC_DELIV','Выбор доставки');
define('_OSC_FILTER','Фильтр');
define('_OSC_ORDERID','Номер заказа:');
define('_OSC_APPLYY','Применить');

//ordersonprint
define('_OOP_TITLE', 'Печать');
define('_OOP_NUM','Номер');
define('_OOP_NAME','Название');
define('_OOP_AUTHOR','Автор');
define('_OOP_COUNT','Тираж');
define('_OOP_ACTION','Действия');
define('_OOP_GETBLOCK','Скачать блок');
define('_OOP_GETOVER','Скачать обложку');